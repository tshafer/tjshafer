<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SpotifyController extends Controller
{
    public function authorize()
    {
        $clientId = env('SPOTIFY_CLIENT_ID');
        $redirectUri = url('/spotify/callback');
        
        if (!$clientId) {
            return response('SPOTIFY_CLIENT_ID not set in .env file', 500);
        }
        
        $scopes = 'user-read-currently-playing user-read-recently-played user-top-read user-read-private user-read-email playlist-read-private';
        $authUrl = 'https://accounts.spotify.com/authorize?' . http_build_query([
            'client_id' => $clientId,
            'response_type' => 'code',
            'redirect_uri' => $redirectUri,
            'scope' => $scopes,
        ]);
        
        return redirect($authUrl);
    }
    
    public function callback(Request $request)
    {
        $code = $request->get('code');
        $error = $request->get('error');
        
        if ($error) {
            return view('spotify.result', [
                'success' => false,
                'message' => 'Authorization failed: ' . $error
            ]);
        }
        
        if (!$code) {
            return view('spotify.result', [
                'success' => false,
                'message' => 'No authorization code received'
            ]);
        }
        
        $clientId = env('SPOTIFY_CLIENT_ID');
        $clientSecret = env('SPOTIFY_CLIENT_SECRET');
        $redirectUri = url('/spotify/callback');
        
        if (!$clientId || !$clientSecret) {
            return view('spotify.result', [
                'success' => false,
                'message' => 'Spotify credentials not configured in .env file'
            ]);
        }
        
        try {
            // Exchange authorization code for tokens
            $tokenResponse = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]);
            
            if (!$tokenResponse->successful()) {
                $errorData = $tokenResponse->json();
                return view('spotify.result', [
                    'success' => false,
                    'message' => 'Failed to exchange code: ' . ($errorData['error_description'] ?? 'Unknown error')
                ]);
            }
            
            $data = $tokenResponse->json();
            $refreshToken = $data['refresh_token'] ?? null;
            
            if (!$refreshToken) {
                return view('spotify.result', [
                    'success' => false,
                    'message' => 'No refresh token received. You may need to delete your app and recreate it.'
                ]);
            }
            
            return view('spotify.result', [
                'success' => true,
                'refresh_token' => $refreshToken,
                'instructions' => 'Copy the refresh token above and add it to your .env file as: SPOTIFY_REFRESH_TOKEN=' . $refreshToken
            ]);
            
        } catch (\Exception $e) {
            return view('spotify.result', [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
    
    public function nowPlaying()
    {
        $clientId = env('SPOTIFY_CLIENT_ID');
        $clientSecret = env('SPOTIFY_CLIENT_SECRET');
        $refreshToken = env('SPOTIFY_REFRESH_TOKEN');

        if (!$clientId || !$clientSecret || !$refreshToken) {
            return response()->json(['error' => 'Spotify credentials not configured'], 500);
        }

        try {
            // Get access token using refresh token
            $tokenResponse = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $refreshToken,
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
            ]);

            if (!$tokenResponse->successful()) {
                return response()->json(['error' => 'Failed to authenticate with Spotify'], 500);
            }

            $accessToken = $tokenResponse->json()['access_token'];

            // Get currently playing track
            $nowPlayingResponse = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/player/currently-playing');

            if ($nowPlayingResponse->status() === 204 || !$nowPlayingResponse->successful()) {
                // No track currently playing, get recently played instead
                $recentResponse = Http::withToken($accessToken)
                    ->get('https://api.spotify.com/v1/me/player/recently-played?limit=1');

                if ($recentResponse->successful() && count($recentResponse->json()['items']) > 0) {
                    $track = $recentResponse->json()['items'][0]['track'];
                    return response()->json([
                        'is_playing' => false,
                        'track' => [
                            'name' => $track['name'],
                            'artist' => implode(', ', array_column($track['artists'], 'name')),
                            'album' => $track['album']['name'],
                            'artwork' => $track['album']['images'][0]['url'] ?? null,
                            'url' => $track['external_urls']['spotify'],
                        ],
                    ]);
                }

                return response()->json(['error' => 'No track information available'], 404);
            }

            $data = $nowPlayingResponse->json();
            $track = $data['item'];

            return response()->json([
                'is_playing' => $data['is_playing'],
                'track' => [
                    'name' => $track['name'],
                    'artist' => implode(', ', array_column($track['artists'], 'name')),
                    'album' => $track['album']['name'],
                    'artwork' => $track['album']['images'][0]['url'] ?? null,
                    'url' => $track['external_urls']['spotify'],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch Spotify data: ' . $e->getMessage()], 500);
        }
    }
    
    private function getAccessToken()
    {
        $clientId = env('SPOTIFY_CLIENT_ID');
        $clientSecret = env('SPOTIFY_CLIENT_SECRET');
        $refreshToken = env('SPOTIFY_REFRESH_TOKEN');

        if (!$clientId || !$clientSecret || !$refreshToken) {
            return ['error' => 'Spotify credentials not configured'];
        }

        $tokenResponse = Http::asForm()->post('https://accounts.spotify.com/api/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ]);

        if (!$tokenResponse->successful()) {
            $errorData = $tokenResponse->json();
            return ['error' => 'Failed to refresh token: ' . ($errorData['error_description'] ?? 'Unknown error')];
        }

        return $tokenResponse->json()['access_token'];
    }
    
    public function topArtists(Request $request)
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $timeRange = $request->get('time_range', 'medium_term');
            $limit = $request->get('limit', 10);
            
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/top/artists', [
                    'time_range' => $timeRange,
                    'limit' => $limit,
                ]);
            
            if (!$response->successful()) {
                $errorData = $response->json();
                $statusCode = $response->status();
                
                if ($statusCode === 403 || ($errorData['error']['message'] ?? '') === 'Insufficient client scope') {
                    return response()->json([
                        'error' => 'Missing permissions. Please re-authorize with all required scopes.',
                        'reauthorize_url' => url('/spotify/auth')
                    ], 403);
                }
                
                return response()->json([
                    'error' => 'Failed to fetch top artists: ' . ($errorData['error']['message'] ?? 'HTTP ' . $statusCode)
                ], 500);
            }
            
            if (!isset($response->json()['items']) || empty($response->json()['items'])) {
                return response()->json(['error' => 'No top artists data available'], 404);
            }
            
            $artists = array_map(function($artist) {
                return [
                    'name' => $artist['name'],
                    'genres' => $artist['genres'],
                    'popularity' => $artist['popularity'],
                    'image' => $artist['images'][0]['url'] ?? null,
                    'url' => $artist['external_urls']['spotify'],
                ];
            }, $response->json()['items']);
            
            return response()->json(['artists' => $artists]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function topTracks(Request $request)
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $timeRange = $request->get('time_range', 'medium_term');
            $limit = $request->get('limit', 10);
            
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/top/tracks', [
                    'time_range' => $timeRange,
                    'limit' => $limit,
                ]);
            
            if (!$response->successful()) {
                $errorData = $response->json();
                $statusCode = $response->status();
                
                if ($statusCode === 403 || ($errorData['error']['message'] ?? '') === 'Insufficient client scope') {
                    return response()->json([
                        'error' => 'Missing permissions. Please re-authorize with all required scopes.',
                        'reauthorize_url' => url('/spotify/auth')
                    ], 403);
                }
                
                return response()->json([
                    'error' => 'Failed to fetch top tracks: ' . ($errorData['error']['message'] ?? 'HTTP ' . $statusCode)
                ], 500);
            }
            
            if (!isset($response->json()['items']) || empty($response->json()['items'])) {
                return response()->json(['error' => 'No top tracks data available'], 404);
            }
            
            $tracks = array_map(function($track) {
                return [
                    'name' => $track['name'],
                    'artist' => implode(', ', array_column($track['artists'], 'name')),
                    'album' => $track['album']['name'],
                    'artwork' => $track['album']['images'][0]['url'] ?? null,
                    'url' => $track['external_urls']['spotify'],
                    'duration_ms' => $track['duration_ms'],
                ];
            }, $response->json()['items']);
            
            return response()->json(['tracks' => $tracks]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function recentlyPlayed(Request $request)
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $limit = $request->get('limit', 20);
            
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/player/recently-played', [
                    'limit' => $limit,
                ]);
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch recently played'], 500);
            }
            
            $tracks = array_map(function($item) {
                $track = $item['track'];
                return [
                    'name' => $track['name'],
                    'artist' => implode(', ', array_column($track['artists'], 'name')),
                    'album' => $track['album']['name'],
                    'artwork' => $track['album']['images'][2]['url'] ?? $track['album']['images'][0]['url'] ?? null,
                    'url' => $track['external_urls']['spotify'],
                    'played_at' => $item['played_at'],
                ];
            }, $response->json()['items']);
            
            return response()->json(['tracks' => $tracks]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function playlists(Request $request)
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $limit = $request->get('limit', 12);
            
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/playlists', [
                    'limit' => $limit,
                ]);
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch playlists'], 500);
            }
            
            $playlists = array_map(function($playlist) {
                return [
                    'name' => $playlist['name'],
                    'description' => $playlist['description'],
                    'image' => $playlist['images'][0]['url'] ?? null,
                    'tracks_count' => $playlist['tracks']['total'],
                    'url' => $playlist['external_urls']['spotify'],
                    'owner' => $playlist['owner']['display_name'] ?? $playlist['owner']['id'],
                ];
            }, $response->json()['items']);
            
            return response()->json(['playlists' => $playlists]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function profile()
    {
        $accessToken = $this->getAccessToken();
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me');
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch profile'], 500);
            }
            
            $data = $response->json();
            return response()->json([
                'display_name' => $data['display_name'] ?? $data['id'],
                'followers' => $data['followers']['total'] ?? 0,
                'image' => $data['images'][0]['url'] ?? null,
                'url' => $data['external_urls']['spotify'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function genres()
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/top/artists', [
                    'time_range' => 'medium_term',
                    'limit' => 50,
                ]);
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch artists'], 500);
            }
            
            $genres = [];
            foreach ($response->json()['items'] as $artist) {
                foreach ($artist['genres'] as $genre) {
                    $genres[$genre] = ($genres[$genre] ?? 0) + 1;
                }
            }
            
            arsort($genres);
            $topGenres = array_slice(array_keys($genres), 0, 10);
            
            return response()->json(['genres' => $topGenres, 'counts' => array_slice($genres, 0, 10, true)]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function topAlbums(Request $request)
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            $timeRange = $request->get('time_range', 'medium_term');
            $limit = $request->get('limit', 12);
            
            $response = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/top/tracks', [
                    'time_range' => $timeRange,
                    'limit' => 50,
                ]);
            
            if (!$response->successful()) {
                return response()->json(['error' => 'Failed to fetch tracks'], 500);
            }
            
            $albums = [];
            foreach ($response->json()['items'] as $track) {
                $albumId = $track['album']['id'];
                if (!isset($albums[$albumId])) {
                    $albums[$albumId] = [
                        'name' => $track['album']['name'],
                        'artist' => implode(', ', array_column($track['album']['artists'], 'name')),
                        'image' => $track['album']['images'][0]['url'] ?? null,
                        'url' => $track['album']['external_urls']['spotify'],
                        'count' => 0,
                    ];
                }
                $albums[$albumId]['count']++;
            }
            
            usort($albums, fn($a, $b) => $b['count'] <=> $a['count']);
            $topAlbums = array_slice($albums, 0, $limit);
            
            return response()->json(['albums' => $topAlbums]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    public function stats()
    {
        $accessToken = $this->getAccessToken();
        
        if (is_array($accessToken) && isset($accessToken['error'])) {
            return response()->json($accessToken, 500);
        }
        
        if (!$accessToken) {
            return response()->json(['error' => 'Authentication failed'], 500);
        }
        
        try {
            // Get top tracks for stats
            $tracksResponse = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/top/tracks', [
                    'time_range' => 'long_term',
                    'limit' => 50,
                ]);
            
            if (!$tracksResponse->successful()) {
                return response()->json(['error' => 'Failed to fetch stats'], 500);
            }
            
            $tracks = $tracksResponse->json()['items'];
            $totalDuration = array_sum(array_column($tracks, 'duration_ms'));
            $totalHours = round($totalDuration / 1000 / 60 / 60, 1);
            
            // Get unique artists
            $artists = [];
            foreach ($tracks as $track) {
                foreach ($track['artists'] as $artist) {
                    $artists[$artist['id']] = $artist['name'];
                }
            }
            
            // Get top artists count
            $artistsResponse = Http::withToken($accessToken)
                ->get('https://api.spotify.com/v1/me/top/artists', [
                    'time_range' => 'long_term',
                    'limit' => 50,
                ]);
            
            $uniqueArtists = count($artists);
            
            return response()->json([
                'total_listening_hours' => $totalHours,
                'unique_artists' => $uniqueArtists,
                'top_tracks_count' => count($tracks),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}

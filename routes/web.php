<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpotifyController;

Route::get('/', function () {
    return view('home');
});

Route::get('/spotify/auth', [SpotifyController::class, 'authorize'])->name('spotify.authorize');
Route::get('/spotify/callback', [SpotifyController::class, 'callback'])->name('spotify.callback');
Route::get('/api/spotify/now-playing', [SpotifyController::class, 'nowPlaying']);
Route::get('/api/spotify/top-artists', [SpotifyController::class, 'topArtists']);
Route::get('/api/spotify/top-tracks', [SpotifyController::class, 'topTracks']);
Route::get('/api/spotify/recently-played', [SpotifyController::class, 'recentlyPlayed']);
Route::get('/api/spotify/playlists', [SpotifyController::class, 'playlists']);
Route::get('/api/spotify/profile', [SpotifyController::class, 'profile']);
Route::get('/api/spotify/genres', [SpotifyController::class, 'genres']);
Route::get('/api/spotify/top-albums', [SpotifyController::class, 'topAlbums']);
Route::get('/api/spotify/stats', [SpotifyController::class, 'stats']);

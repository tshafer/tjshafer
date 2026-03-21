@extends('layouts.site')

@section('title', 'Music & Spotify · Shafer LLC')

@section('meta_description', 'Live Spotify stats — now playing, top artists, tracks, playlists, and listening history. Tom Shafer / Shafer LLC.')

@section('content')
    <section class="border-b border-white/10 bg-panel/40">
        <div class="max-w-6xl mx-auto px-5 sm:px-8 py-12 lg:py-16">
            <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-8">
                <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="" width="80" height="80" class="h-16 w-16 sm:h-20 sm:w-20 rounded-full object-cover ring-2 ring-copper/35 shrink-0" aria-hidden="true">
                <div>
                    <p class="font-mono text-copper text-xs tracking-[0.35em] uppercase mb-2">Listening</p>
                    <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight">Music &amp; Spotify</h1>
                </div>
            </div>
            <p class="text-muted max-w-2xl leading-relaxed">
                Connected to Spotify — what’s on right now, what’s on repeat, and the rabbit holes I’ve been down lately.
            </p>
            <a href="{{ route('home') }}#music" class="inline-flex items-center gap-2 mt-8 text-sm text-muted hover:text-copper transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                Back to home
            </a>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-24">
        <div class="space-y-8">
            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <div class="space-y-6 text-muted leading-relaxed mb-8">
                    <p>
                        Music is a big part of my life. Whether I'm coding, working out, or just relaxing, you'll usually find me with headphones on. I have a wide-ranging taste in music, from indie rock to electronic, jazz to classical.
                    </p>
                </div>

                <div id="spotify-widget" class="bg-panel-2 border border-white/10 rounded-sm p-6 mb-0">
                    <div class="flex items-center gap-4">
                        <div id="spotify-artwork" class="w-20 h-20 bg-panel-3 rounded-sm flex items-center justify-center flex-shrink-0 overflow-hidden">
                            <svg class="w-10 h-10 text-spotify" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.84-.179-.84-.66 0-.359.24-.66.54-.779 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.242 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div id="spotify-status" class="text-spotify text-xs font-medium mb-1 flex items-center gap-2">
                                <span class="inline-flex w-2 h-2 bg-spotify rounded-full"></span>
                                Currently playing
                            </div>
                            <div id="spotify-track" class="text-warm font-medium truncate">Loading...</div>
                            <div id="spotify-artist" class="text-muted text-sm truncate"></div>
                        </div>
                        <a id="spotify-link" href="#" target="_blank" rel="noopener" class="flex-shrink-0 text-muted hover:text-spotify transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                    <h2 class="text-xl font-semibold text-warm">Top Artists</h2>
                    <div class="flex gap-2 text-xs">
                        <button type="button" onclick="loadTopArtists('short_term', this)" class="px-3 py-1 rounded bg-panel-2 hover:bg-panel-3 text-muted hover:text-warm transition-colors">4 weeks</button>
                        <button type="button" onclick="loadTopArtists('medium_term', this)" class="px-3 py-1 rounded bg-copper text-ink transition-colors">6 months</button>
                        <button type="button" onclick="loadTopArtists('long_term', this)" class="px-3 py-1 rounded bg-panel-2 hover:bg-panel-3 text-muted hover:text-warm transition-colors">All time</button>
                    </div>
                </div>
                <div id="top-artists" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div class="col-span-full text-center text-muted py-8">Loading...</div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                    <h2 class="text-xl font-semibold text-warm">Top Tracks</h2>
                    <div class="flex gap-2 text-xs">
                        <button type="button" onclick="loadTopTracks('short_term', this)" class="px-3 py-1 rounded bg-panel-2 hover:bg-panel-3 text-muted hover:text-warm transition-colors">4 weeks</button>
                        <button type="button" onclick="loadTopTracks('medium_term', this)" class="px-3 py-1 rounded bg-copper text-ink transition-colors">6 months</button>
                        <button type="button" onclick="loadTopTracks('long_term', this)" class="px-3 py-1 rounded bg-panel-2 hover:bg-panel-3 text-muted hover:text-warm transition-colors">All time</button>
                    </div>
                </div>
                <div id="top-tracks" class="space-y-2">
                    <div class="text-center text-muted py-8">Loading...</div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <h2 class="text-xl font-semibold text-warm mb-6">Recently Played</h2>
                <div id="recently-played" class="space-y-2 max-h-96 overflow-y-auto">
                    <div class="text-center text-muted py-8">Loading...</div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <h2 class="text-xl font-semibold text-warm mb-6">Listening Stats</h2>
                <div id="stats" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-panel-2 border border-white/10 rounded-sm p-6">
                        <div class="text-muted text-sm mb-2">Total Listening</div>
                        <div id="total-hours" class="text-3xl font-semibold text-warm">-</div>
                        <div class="text-muted text-xs mt-1">hours</div>
                    </div>
                    <div class="bg-panel-2 border border-white/10 rounded-sm p-6">
                        <div class="text-muted text-sm mb-2">Top Artists</div>
                        <div id="top-tracks-count" class="text-3xl font-semibold text-warm">-</div>
                        <div class="text-muted text-xs mt-1">tracks analyzed</div>
                    </div>
                    <div class="bg-panel-2 border border-white/10 rounded-sm p-6">
                        <div class="text-muted text-sm mb-2">Unique Artists</div>
                        <div id="unique-artists" class="text-3xl font-semibold text-warm">-</div>
                        <div class="text-muted text-xs mt-1">discovered</div>
                    </div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <h2 class="text-xl font-semibold text-warm mb-6">Top Genres</h2>
                <div id="genres" class="flex flex-wrap gap-3">
                    <div class="text-muted py-4">Loading...</div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                    <h2 class="text-xl font-semibold text-warm">Top Albums</h2>
                    <div class="flex gap-2 text-xs">
                        <button type="button" onclick="loadTopAlbums('short_term', this)" class="px-3 py-1 rounded bg-panel-2 hover:bg-panel-3 text-muted hover:text-warm transition-colors">4 weeks</button>
                        <button type="button" onclick="loadTopAlbums('medium_term', this)" class="px-3 py-1 rounded bg-copper text-ink transition-colors">6 months</button>
                        <button type="button" onclick="loadTopAlbums('long_term', this)" class="px-3 py-1 rounded bg-panel-2 hover:bg-panel-3 text-muted hover:text-warm transition-colors">All time</button>
                    </div>
                </div>
                <div id="top-albums" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="col-span-full text-center text-muted py-8">Loading...</div>
                </div>
            </div>

            <div class="bg-panel border border-white/10 rounded-sm p-8">
                <h2 class="text-xl font-semibold text-warm mb-6">Playlists</h2>
                <div id="playlists" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <div class="col-span-full text-center text-muted py-8">Loading...</div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let currentTimeRange = 'medium_term';

        async function updateSpotifyWidget() {
            try {
                const response = await fetch('/api/spotify/now-playing');
                const data = await response.json();

                const widget = document.getElementById('spotify-widget');
                const status = document.getElementById('spotify-status');
                const track = document.getElementById('spotify-track');
                const artist = document.getElementById('spotify-artist');
                const artwork = document.getElementById('spotify-artwork');
                const link = document.getElementById('spotify-link');

                if (data.error) {
                    widget.style.display = 'none';
                    return;
                }

                if (data.track) {
                    track.textContent = data.track.name;
                    artist.textContent = data.track.artist;
                    link.href = data.track.url;

                    if (data.track.artwork) {
                        artwork.innerHTML = `<img src="${data.track.artwork}" alt="" class="w-20 h-20 rounded-sm object-cover">`;
                    }

                    if (!data.is_playing) {
                        status.innerHTML = '<span class="inline-flex w-2 h-2 bg-muted rounded-full"></span> Recently played';
                    } else {
                        status.innerHTML = '<span class="inline-flex w-2 h-2 bg-spotify rounded-full animate-pulse"></span> Currently playing';
                    }
                }
            } catch (error) {
                console.error('Error fetching Spotify data:', error);
                const widget = document.getElementById('spotify-widget');
                if (widget) widget.style.display = 'none';
            }
        }

        async function loadTopArtists(timeRange = 'medium_term', button = null) {
            currentTimeRange = timeRange;
            const container = document.getElementById('top-artists');
            container.innerHTML = '<div class="col-span-full text-center text-muted py-4">Loading...</div>';

            if (button) {
                document.querySelectorAll('[onclick*="loadTopArtists"]').forEach(btn => {
                    btn.classList.remove('bg-copper', 'text-ink');
                    btn.classList.add('bg-panel-2', 'text-muted');
                });
                button.classList.add('bg-copper', 'text-ink');
                button.classList.remove('bg-panel-2', 'text-muted');
            }

            try {
                const response = await fetch(`/api/spotify/top-artists?time_range=${timeRange}`);
                const data = await response.json();

                if (data.error) {
                    const needsReauth = data.error.includes('Missing permissions') ||
                                       data.error.includes('Failed to refresh token') ||
                                       data.error.includes('not configured') ||
                                       data.error.includes('Insufficient');
                    const errorMsg = needsReauth
                        ? `<div class="col-span-full text-center py-4">
                            <div class="text-red-400 mb-2">Unable to load artists</div>
                            <div class="text-muted text-xs mb-3">${data.error}</div>
                            <a href="${data.reauthorize_url || '/spotify/auth'}" class="inline-block bg-copper hover:bg-copper-hover text-ink px-4 py-2 rounded text-xs font-medium transition-colors">Re-authorize Spotify</a>
                        </div>`
                        : `<div class="col-span-full text-center text-red-400 py-4">${data.error}</div>`;
                    container.innerHTML = errorMsg;
                    return;
                }

                if (data.artists && data.artists.length > 0) {
                    container.innerHTML = data.artists.map((artist, index) => `
                        <a href="${artist.url}" target="_blank" rel="noopener" class="group bg-panel-2 border border-white/10 rounded-sm p-4 hover:border-spotify transition-all">
                            <div class="aspect-square rounded-sm bg-panel-3 mb-3 overflow-hidden flex items-center justify-center">
                                ${artist.image
                                    ? `<img src="${artist.image}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform">`
                                    : `<svg class="w-12 h-12 text-muted" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/></svg>`
                                }
                            </div>
                            <div class="text-warm font-medium text-sm truncate">${index + 1}. ${artist.name}</div>
                            ${artist.genres.length > 0 ? `<div class="text-muted text-xs truncate mt-1">${artist.genres[0]}</div>` : ''}
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-muted py-4">No artists found</div>';
                }
            } catch (error) {
                console.error('Error loading top artists:', error);
                container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Error loading artists</div>';
            }
        }

        async function loadTopTracks(timeRange = 'medium_term', button = null) {
            currentTimeRange = timeRange;
            const container = document.getElementById('top-tracks');
            container.innerHTML = '<div class="text-center text-muted py-4">Loading...</div>';

            if (button) {
                document.querySelectorAll('[onclick*="loadTopTracks"]').forEach(btn => {
                    btn.classList.remove('bg-copper', 'text-ink');
                    btn.classList.add('bg-panel-2', 'text-muted');
                });
                button.classList.add('bg-copper', 'text-ink');
                button.classList.remove('bg-panel-2', 'text-muted');
            }

            try {
                const response = await fetch(`/api/spotify/top-tracks?time_range=${timeRange}`);
                const data = await response.json();

                if (data.error) {
                    const needsReauth = data.error.includes('Missing permissions') ||
                                       data.error.includes('Failed to refresh token') ||
                                       data.error.includes('not configured') ||
                                       data.error.includes('Insufficient');
                    const errorMsg = needsReauth
                        ? `<div class="text-center py-4">
                            <div class="text-red-400 mb-2">Unable to load tracks</div>
                            <div class="text-muted text-xs mb-3">${data.error}</div>
                            <a href="${data.reauthorize_url || '/spotify/auth'}" class="inline-block bg-copper hover:bg-copper-hover text-ink px-4 py-2 rounded text-xs font-medium transition-colors">Re-authorize Spotify</a>
                        </div>`
                        : `<div class="text-center text-red-400 py-4">${data.error}</div>`;
                    container.innerHTML = errorMsg;
                    return;
                }

                if (data.tracks && data.tracks.length > 0) {
                    container.innerHTML = data.tracks.map((track, index) => `
                        <a href="${track.url}" target="_blank" rel="noopener" class="flex items-center gap-4 p-3 bg-panel-2 border border-white/10 rounded-sm hover:border-spotify transition-all group">
                            <span class="text-muted text-sm font-mono w-6">${String(index + 1).padStart(2, '0')}</span>
                            ${track.artwork ? `<img src="${track.artwork}" alt="" class="w-12 h-12 rounded object-cover">` : '<div class="w-12 h-12 bg-panel-3 rounded"></div>'}
                            <div class="flex-1 min-w-0">
                                <div class="text-warm font-medium truncate group-hover:text-spotify">${track.name}</div>
                                <div class="text-muted text-sm truncate">${track.artist}</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="text-center text-muted py-4">No tracks found</div>';
                }
            } catch (error) {
                console.error('Error loading top tracks:', error);
                container.innerHTML = '<div class="text-center text-red-400 py-4">Error loading tracks</div>';
            }
        }

        async function loadRecentlyPlayed() {
            const container = document.getElementById('recently-played');
            try {
                const response = await fetch('/api/spotify/recently-played');
                const data = await response.json();

                if (data.error) {
                    container.innerHTML = '<div class="text-center text-red-400 py-4">Unable to load recently played</div>';
                    return;
                }

                if (data.tracks && data.tracks.length > 0) {
                    container.innerHTML = data.tracks.map(track => {
                        const date = new Date(track.played_at);
                        const timeAgo = getTimeAgo(date);
                        return `
                            <a href="${track.url}" target="_blank" rel="noopener" class="flex items-center gap-3 p-3 bg-panel-2 border border-white/10 rounded-sm hover:border-spotify transition-all group">
                                ${track.artwork ? `<img src="${track.artwork}" alt="" class="w-12 h-12 rounded object-cover flex-shrink-0">` : '<div class="w-12 h-12 bg-panel-3 rounded flex-shrink-0"></div>'}
                                <div class="flex-1 min-w-0">
                                    <div class="text-warm font-medium truncate group-hover:text-spotify">${track.name}</div>
                                    <div class="text-muted text-sm truncate">${track.artist} • ${timeAgo}</div>
                                </div>
                            </a>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = '<div class="text-center text-muted py-4">No recently played tracks</div>';
                }
            } catch (error) {
                console.error('Error loading recently played:', error);
                container.innerHTML = '<div class="text-center text-red-400 py-4">Error loading recently played</div>';
            }
        }

        async function loadPlaylists() {
            const container = document.getElementById('playlists');
            try {
                const response = await fetch('/api/spotify/playlists');
                const data = await response.json();

                if (data.error) {
                    container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Unable to load playlists</div>';
                    return;
                }

                if (data.playlists && data.playlists.length > 0) {
                    container.innerHTML = data.playlists.map(playlist => `
                        <a href="${playlist.url}" target="_blank" rel="noopener" class="group bg-panel-2 border border-white/10 rounded-sm overflow-hidden hover:border-spotify transition-all">
                            <div class="aspect-square bg-panel-3 relative">
                                ${playlist.image
                                    ? `<img src="${playlist.image}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform">`
                                    : `<div class="w-full h-full flex items-center justify-center"><svg class="w-16 h-16 text-muted" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg></div>`
                                }
                            </div>
                            <div class="p-4">
                                <div class="text-warm font-medium text-sm truncate mb-1 group-hover:text-spotify">${playlist.name}</div>
                                <div class="text-muted text-xs">${playlist.tracks_count} tracks</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-muted py-4">No playlists found</div>';
                }
            } catch (error) {
                console.error('Error loading playlists:', error);
                container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Error loading playlists</div>';
            }
        }

        function getTimeAgo(date) {
            const seconds = Math.floor((new Date() - date) / 1000);
            if (seconds < 60) return 'Just now';
            const minutes = Math.floor(seconds / 60);
            if (minutes < 60) return `${minutes}m ago`;
            const hours = Math.floor(minutes / 60);
            if (hours < 24) return `${hours}h ago`;
            const days = Math.floor(hours / 24);
            return `${days}d ago`;
        }

        async function loadGenres() {
            const container = document.getElementById('genres');
            try {
                const response = await fetch('/api/spotify/genres');
                const data = await response.json();

                if (data.error) {
                    container.innerHTML = '<div class="text-red-400 py-4">Unable to load genres</div>';
                    return;
                }

                if (data.genres && data.genres.length > 0) {
                    container.innerHTML = data.genres.map((genre, index) => {
                        const count = data.counts[genre] || 0;
                        return `
                            <div class="group bg-panel-2 border border-white/10 rounded-sm px-4 py-2 hover:border-spotify transition-all cursor-default">
                                <div class="flex items-center gap-2">
                                    <span class="text-muted text-xs font-mono">${index + 1}</span>
                                    <span class="text-warm font-medium text-sm">${genre}</span>
                                    <span class="text-muted text-xs">(${count})</span>
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = '<div class="text-muted py-4">No genres found</div>';
                }
            } catch (error) {
                console.error('Error loading genres:', error);
                container.innerHTML = '<div class="text-red-400 py-4">Error loading genres</div>';
            }
        }

        async function loadTopAlbums(timeRange = 'medium_term', button = null) {
            const container = document.getElementById('top-albums');
            container.innerHTML = '<div class="col-span-full text-center text-muted py-4">Loading...</div>';

            if (button) {
                document.querySelectorAll('[onclick*="loadTopAlbums"]').forEach(btn => {
                    btn.classList.remove('bg-copper', 'text-ink');
                    btn.classList.add('bg-panel-2', 'text-muted');
                });
                button.classList.add('bg-copper', 'text-ink');
                button.classList.remove('bg-panel-2', 'text-muted');
            }

            try {
                const response = await fetch(`/api/spotify/top-albums?time_range=${timeRange}`);
                const data = await response.json();

                if (data.error) {
                    container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Unable to load albums</div>';
                    return;
                }

                if (data.albums && data.albums.length > 0) {
                    container.innerHTML = data.albums.map(album => `
                        <a href="${album.url}" target="_blank" rel="noopener" class="group bg-panel-2 border border-white/10 rounded-sm overflow-hidden hover:border-spotify transition-all">
                            <div class="aspect-square bg-panel-3 relative">
                                ${album.image
                                    ? `<img src="${album.image}" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform">`
                                    : `<div class="w-full h-full flex items-center justify-center"><svg class="w-16 h-16 text-muted" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/></svg></div>`
                                }
                                <div class="absolute top-2 right-2 bg-spotify text-ink text-xs font-bold px-2 py-1 rounded-full">
                                    ${album.count}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="text-warm font-medium text-sm truncate mb-1 group-hover:text-spotify">${album.name}</div>
                                <div class="text-muted text-xs truncate">${album.artist}</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-muted py-4">No albums found</div>';
                }
            } catch (error) {
                console.error('Error loading top albums:', error);
                container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Error loading albums</div>';
            }
        }

        async function loadStats() {
            try {
                const response = await fetch('/api/spotify/stats');
                const data = await response.json();

                if (data.error) {
                    document.getElementById('total-hours').textContent = '-';
                    document.getElementById('top-tracks-count').textContent = '-';
                    document.getElementById('unique-artists').textContent = '-';
                    return;
                }

                document.getElementById('total-hours').textContent = data.total_listening_hours || '-';
                document.getElementById('top-tracks-count').textContent = data.top_tracks_count || '-';
                document.getElementById('unique-artists').textContent = data.unique_artists || '-';
            } catch (error) {
                console.error('Error loading stats:', error);
            }
        }

        updateSpotifyWidget();
        loadTopArtists('medium_term');
        loadTopTracks('medium_term');
        loadRecentlyPlayed();
        loadPlaylists();
        loadGenres();
        loadTopAlbums('medium_term');
        loadStats();

        setInterval(updateSpotifyWidget, 30000);
    </script>
@endpush

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tom Shafer - tjshafer.com</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="border-b border-slate-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <nav class="flex items-center justify-between h-16">
                    <div class="text-lg font-semibold text-white">
                        tjshafer.com
                    </div>
                    <div class="flex items-center gap-8">
                        <a href="#about" class="text-slate-400 hover:text-white transition-colors text-sm font-medium">About</a>
                        <a href="#music" class="text-slate-400 hover:text-white transition-colors text-sm font-medium">Music</a>
                        <a href="#contact" class="text-slate-400 hover:text-white transition-colors text-sm font-medium">Contact</a>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-4xl mx-auto px-6 lg:px-8 py-16 lg:py-24">
                <!-- Hero Section -->
                <div class="mb-24 lg:mb-32">
                    <h1 class="text-5xl lg:text-6xl font-semibold mb-6 text-white leading-tight">
                        Tom Shafer
                    </h1>
                    <p class="text-xl lg:text-2xl text-slate-400 mb-4 leading-relaxed">
                        Software Developer & Creative Problem Solver
                    </p>
                    <div class="flex items-center gap-2 text-slate-500 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>Arizona, United States</span>
                    </div>
                </div>

                <!-- About Section -->
                <section id="about" class="mb-24 lg:mb-32">
                    <h2 class="text-2xl font-semibold mb-8 text-white">
                        About
                    </h2>
                    <div class="space-y-6 text-slate-400 leading-relaxed">
                        <p class="text-lg">
                            Welcome to my personal website! I'm <span class="text-white font-medium">41 years old</span> and I call <span class="text-white font-medium">Arizona</span> home.
                        </p>
                        <p>
                            I'm passionate about building great software and solving complex problems. This site serves as my personal space on the web, where I share my work, thoughts, and connect with others in the tech community.
                        </p>
                        <p>
                            Whether you're here to learn more about my projects, collaborate on something interesting, or just say hello, I'd love to hear from you!
                        </p>
                    </div>
                </section>

                <!-- Skills/Interests Section -->
                <section class="mb-24 lg:mb-32">
                    <h2 class="text-2xl font-semibold mb-8 text-white">
                        What I Do
                    </h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-slate-700 transition-colors">
                            <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 text-white">Development</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Building web applications and software solutions
                            </p>
                        </div>
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-slate-700 transition-colors">
                            <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 text-white">Innovation</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Exploring new technologies and creative solutions
                            </p>
                        </div>
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-6 hover:border-slate-700 transition-colors">
                            <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center mb-4">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 text-white">Collaboration</h3>
                            <p class="text-slate-400 text-sm leading-relaxed">
                                Working with teams to achieve great results
                            </p>
                        </div>
                    </div>
                </section>

                <!-- Music Section -->
                <section id="music" class="mb-24 lg:mb-32">
                    <h2 class="text-2xl font-semibold mb-8 text-white">
                        Music
                    </h2>
                    <div class="space-y-8">
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <div class="space-y-6 text-slate-400 leading-relaxed mb-8">
                                <p>
                                    Music is a big part of my life. Whether I'm coding, working out, or just relaxing, you'll usually find me with headphones on. I have a wide-ranging taste in music, from indie rock to electronic, jazz to classical.
                                </p>
                            </div>
                            
                            <!-- Currently Playing Widget -->
                            <div id="spotify-widget" class="bg-slate-800 border border-slate-700 rounded-lg p-6 mb-0">
                                <div class="flex items-center gap-4">
                                    <div id="spotify-artwork" class="w-20 h-20 bg-slate-700 rounded-lg flex items-center justify-center flex-shrink-0 overflow-hidden">
                                        <svg class="w-10 h-10 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.84-.179-.84-.66 0-.359.24-.66.54-.779 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.242 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div id="spotify-status" class="text-green-500 text-xs font-medium mb-1 flex items-center gap-2">
                                            <span class="inline-flex w-2 h-2 bg-green-500 rounded-full"></span>
                                            Currently playing
                                        </div>
                                        <div id="spotify-track" class="text-white font-medium truncate">Loading...</div>
                                        <div id="spotify-artist" class="text-slate-400 text-sm truncate"></div>
                                    </div>
                                    <a id="spotify-link" href="#" target="_blank" class="flex-shrink-0 text-slate-400 hover:text-green-500 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Top Artists -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-white">Top Artists</h3>
                                <div class="flex gap-2 text-xs">
                                    <button onclick="loadTopArtists('short_term', this)" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">4 weeks</button>
                                    <button onclick="loadTopArtists('medium_term', this)" class="px-3 py-1 rounded bg-blue-600 text-white transition-colors">6 months</button>
                                    <button onclick="loadTopArtists('long_term', this)" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">All time</button>
                                </div>
                            </div>
                            <div id="top-artists" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                                <div class="col-span-full text-center text-slate-400 py-8">Loading...</div>
                            </div>
                        </div>

                        <!-- Top Tracks -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-white">Top Tracks</h3>
                                <div class="flex gap-2 text-xs">
                                    <button onclick="loadTopTracks('short_term', this)" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">4 weeks</button>
                                    <button onclick="loadTopTracks('medium_term', this)" class="px-3 py-1 rounded bg-blue-600 text-white transition-colors">6 months</button>
                                    <button onclick="loadTopTracks('long_term', this)" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">All time</button>
                                </div>
                            </div>
                            <div id="top-tracks" class="space-y-2">
                                <div class="text-center text-slate-400 py-8">Loading...</div>
                            </div>
                        </div>

                        <!-- Recently Played -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Recently Played</h3>
                            <div id="recently-played" class="space-y-2 max-h-96 overflow-y-auto">
                                <div class="text-center text-slate-400 py-8">Loading...</div>
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Listening Stats</h3>
                            <div id="stats" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
                                    <div class="text-slate-400 text-sm mb-2">Total Listening</div>
                                    <div id="total-hours" class="text-3xl font-semibold text-white">-</div>
                                    <div class="text-slate-500 text-xs mt-1">hours</div>
                                </div>
                                <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
                                    <div class="text-slate-400 text-sm mb-2">Top Artists</div>
                                    <div id="top-tracks-count" class="text-3xl font-semibold text-white">-</div>
                                    <div class="text-slate-500 text-xs mt-1">tracks analyzed</div>
                                </div>
                                <div class="bg-slate-800 border border-slate-700 rounded-lg p-6">
                                    <div class="text-slate-400 text-sm mb-2">Unique Artists</div>
                                    <div id="unique-artists" class="text-3xl font-semibold text-white">-</div>
                                    <div class="text-slate-500 text-xs mt-1">discovered</div>
                                </div>
                            </div>
                        </div>

                        <!-- Genre Breakdown -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Top Genres</h3>
                            <div id="genres" class="flex flex-wrap gap-3">
                                <div class="text-slate-400 py-4">Loading...</div>
                            </div>
                        </div>

                        <!-- Top Albums -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-xl font-semibold text-white">Top Albums</h3>
                                <div class="flex gap-2 text-xs">
                                    <button onclick="loadTopAlbums('short_term', this)" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">4 weeks</button>
                                    <button onclick="loadTopAlbums('medium_term', this)" class="px-3 py-1 rounded bg-blue-600 text-white transition-colors">6 months</button>
                                    <button onclick="loadTopAlbums('long_term', this)" class="px-3 py-1 rounded bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white transition-colors">All time</button>
                                </div>
                            </div>
                            <div id="top-albums" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="col-span-full text-center text-slate-400 py-8">Loading...</div>
                            </div>
                        </div>

                        <!-- Playlists -->
                        <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                            <h3 class="text-xl font-semibold text-white mb-6">Playlists</h3>
                            <div id="playlists" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                                <div class="col-span-full text-center text-slate-400 py-8">Loading...</div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contact Section -->
                <section id="contact" class="mb-16">
                    <h2 class="text-2xl font-semibold mb-8 text-white">
                        Get In Touch
                    </h2>
                    <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                        <p class="text-slate-400 mb-6 leading-relaxed">
                            Interested in collaborating or just want to say hello? I'd love to hear from you!
                        </p>
                        <a href="mailto:tom@tjshafer.com" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Send Email
                        </a>
                    </div>
                </section>
            </div>
        </main>

        <!-- Footer -->
        <footer class="border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
                <p class="text-center text-slate-500 text-sm">
                    &copy; {{ date('Y') }} Tom Shafer. All rights reserved.
                </p>
            </div>
        </footer>
    </div>

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
                        artwork.innerHTML = `<img src="${data.track.artwork}" alt="Album artwork" class="w-20 h-20 rounded-lg object-cover">`;
                    }

                    if (!data.is_playing) {
                        status.innerHTML = '<span class="inline-flex w-2 h-2 bg-slate-500 rounded-full"></span> Recently played';
                    } else {
                        status.innerHTML = '<span class="inline-flex w-2 h-2 bg-green-500 rounded-full animate-pulse"></span> Currently playing';
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
            container.innerHTML = '<div class="col-span-full text-center text-slate-400 py-4">Loading...</div>';
            
            // Update button states
            if (button) {
                document.querySelectorAll('[onclick*="loadTopArtists"]').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-slate-800', 'text-slate-300');
                });
                button.classList.add('bg-blue-600', 'text-white');
                button.classList.remove('bg-slate-800', 'text-slate-300');
            }
            
            try {
                const response = await fetch(`/api/spotify/top-artists?time_range=${timeRange}`);
                const data = await response.json();
                
                if (data.error) {
                    container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Unable to load artists</div>';
                    return;
                }
                
                if (data.artists && data.artists.length > 0) {
                    container.innerHTML = data.artists.map((artist, index) => `
                        <a href="${artist.url}" target="_blank" class="group bg-slate-800 border border-slate-700 rounded-lg p-4 hover:border-green-500 transition-all">
                            <div class="aspect-square rounded-lg bg-slate-700 mb-3 overflow-hidden flex items-center justify-center">
                                ${artist.image 
                                    ? `<img src="${artist.image}" alt="${artist.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">`
                                    : `<svg class="w-12 h-12 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/></svg>`
                                }
                            </div>
                            <div class="text-white font-medium text-sm truncate">${index + 1}. ${artist.name}</div>
                            ${artist.genres.length > 0 ? `<div class="text-slate-400 text-xs truncate mt-1">${artist.genres[0]}</div>` : ''}
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-slate-400 py-4">No artists found</div>';
                }
            } catch (error) {
                console.error('Error loading top artists:', error);
                container.innerHTML = '<div class="col-span-full text-center text-red-400 py-4">Error loading artists</div>';
            }
        }

        async function loadTopTracks(timeRange = 'medium_term', button = null) {
            currentTimeRange = timeRange;
            const container = document.getElementById('top-tracks');
            container.innerHTML = '<div class="text-center text-slate-400 py-4">Loading...</div>';
            
            // Update button states
            if (button) {
                document.querySelectorAll('[onclick*="loadTopTracks"]').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-slate-800', 'text-slate-300');
                });
                button.classList.add('bg-blue-600', 'text-white');
                button.classList.remove('bg-slate-800', 'text-slate-300');
            }
            
            try {
                const response = await fetch(`/api/spotify/top-tracks?time_range=${timeRange}`);
                const data = await response.json();
                
                if (data.error) {
                    container.innerHTML = '<div class="text-center text-red-400 py-4">Unable to load tracks</div>';
                    return;
                }
                
                if (data.tracks && data.tracks.length > 0) {
                    container.innerHTML = data.tracks.map((track, index) => `
                        <a href="${track.url}" target="_blank" class="flex items-center gap-4 p-3 bg-slate-800 border border-slate-700 rounded-lg hover:border-green-500 transition-all group">
                            <span class="text-slate-500 text-sm font-mono w-6">${String(index + 1).padStart(2, '0')}</span>
                            ${track.artwork ? `<img src="${track.artwork}" alt="${track.name}" class="w-12 h-12 rounded object-cover">` : '<div class="w-12 h-12 bg-slate-700 rounded"></div>'}
                            <div class="flex-1 min-w-0">
                                <div class="text-white font-medium truncate group-hover:text-green-500">${track.name}</div>
                                <div class="text-slate-400 text-sm truncate">${track.artist}</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="text-center text-slate-400 py-4">No tracks found</div>';
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
                            <a href="${track.url}" target="_blank" class="flex items-center gap-3 p-3 bg-slate-800 border border-slate-700 rounded-lg hover:border-green-500 transition-all group">
                                ${track.artwork ? `<img src="${track.artwork}" alt="${track.name}" class="w-12 h-12 rounded object-cover flex-shrink-0">` : '<div class="w-12 h-12 bg-slate-700 rounded flex-shrink-0"></div>'}
                                <div class="flex-1 min-w-0">
                                    <div class="text-white font-medium truncate group-hover:text-green-500">${track.name}</div>
                                    <div class="text-slate-400 text-sm truncate">${track.artist} • ${timeAgo}</div>
                                </div>
                            </a>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = '<div class="text-center text-slate-400 py-4">No recently played tracks</div>';
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
                        <a href="${playlist.url}" target="_blank" class="group bg-slate-800 border border-slate-700 rounded-lg overflow-hidden hover:border-green-500 transition-all">
                            <div class="aspect-square bg-slate-700 relative">
                                ${playlist.image 
                                    ? `<img src="${playlist.image}" alt="${playlist.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">`
                                    : `<div class="w-full h-full flex items-center justify-center"><svg class="w-16 h-16 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.37 4.37 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z"/></svg></div>`
                                }
                            </div>
                            <div class="p-4">
                                <div class="text-white font-medium text-sm truncate mb-1 group-hover:text-green-500">${playlist.name}</div>
                                <div class="text-slate-400 text-xs">${playlist.tracks_count} tracks</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-slate-400 py-4">No playlists found</div>';
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
                            <div class="group bg-slate-800 border border-slate-700 rounded-lg px-4 py-2 hover:border-green-500 transition-all cursor-default">
                                <div class="flex items-center gap-2">
                                    <span class="text-slate-400 text-xs font-mono">${index + 1}</span>
                                    <span class="text-white font-medium text-sm">${genre}</span>
                                    <span class="text-slate-500 text-xs">(${count})</span>
                                </div>
                            </div>
                        `;
                    }).join('');
                } else {
                    container.innerHTML = '<div class="text-slate-400 py-4">No genres found</div>';
                }
            } catch (error) {
                console.error('Error loading genres:', error);
                container.innerHTML = '<div class="text-red-400 py-4">Error loading genres</div>';
            }
        }

        async function loadTopAlbums(timeRange = 'medium_term', button = null) {
            const container = document.getElementById('top-albums');
            container.innerHTML = '<div class="col-span-full text-center text-slate-400 py-4">Loading...</div>';
            
            if (button) {
                document.querySelectorAll('[onclick*="loadTopAlbums"]').forEach(btn => {
                    btn.classList.remove('bg-blue-600', 'text-white');
                    btn.classList.add('bg-slate-800', 'text-slate-300');
                });
                button.classList.add('bg-blue-600', 'text-white');
                button.classList.remove('bg-slate-800', 'text-slate-300');
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
                        <a href="${album.url}" target="_blank" class="group bg-slate-800 border border-slate-700 rounded-lg overflow-hidden hover:border-green-500 transition-all">
                            <div class="aspect-square bg-slate-700 relative">
                                ${album.image 
                                    ? `<img src="${album.image}" alt="${album.name}" class="w-full h-full object-cover group-hover:scale-110 transition-transform">`
                                    : `<div class="w-full h-full flex items-center justify-center"><svg class="w-16 h-16 text-slate-500" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z"/><path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd"/></svg></div>`
                                }
                                <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                    ${album.count}
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="text-white font-medium text-sm truncate mb-1 group-hover:text-green-500">${album.name}</div>
                                <div class="text-slate-400 text-xs truncate">${album.artist}</div>
                            </div>
                        </a>
                    `).join('');
                } else {
                    container.innerHTML = '<div class="col-span-full text-center text-slate-400 py-4">No albums found</div>';
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

        // Load everything on page load
        updateSpotifyWidget();
        loadTopArtists('medium_term');
        loadTopTracks('medium_term');
        loadRecentlyPlayed();
        loadPlaylists();
        loadGenres();
        loadTopAlbums('medium_term');
        loadStats();

        // Update currently playing every 30 seconds
        setInterval(updateSpotifyWidget, 30000);
    </script>
</body>
</html>
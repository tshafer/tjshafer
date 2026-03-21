<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spotify setup · Shafer LLC</title>

    <link rel="icon" type="image/png" href="{{ asset('images/tom-shafer-logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-mono:400,500|italiana:400|jost:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans relative z-10">
    <div class="min-h-screen flex items-center justify-center px-5 py-12">
        <div class="max-w-2xl w-full">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="Tom Shafer" width="72" height="72" class="h-16 w-16 sm:h-[4.5rem] sm:w-[4.5rem] rounded-full object-cover ring-2 ring-copper/35">
            </div>
            <p class="font-mono text-xs text-copper uppercase tracking-[0.25em] mb-4 text-center">shafer.llc</p>
            <div class="bg-panel border border-white/10 rounded-sm p-8">
                @if(isset($success) && $success && isset($refresh_token))
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-spotify/15 rounded-full flex items-center justify-center ring-1 ring-spotify/30">
                                <svg class="w-6 h-6 text-spotify" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h1 class="font-display text-2xl text-warm">Success</h1>
                        </div>
                        <p class="text-muted mb-6">Your refresh token has been generated. Copy it below and add it to your <code class="bg-panel-2 px-2 py-1 rounded-sm text-sm text-warm">.env</code> file.</p>
                    </div>

                    <div class="bg-panel-2 border border-white/10 rounded-sm p-6 mb-6">
                        <label class="block text-xs font-medium text-muted mb-2 font-mono uppercase tracking-wider">Refresh token</label>
                        <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                            <input
                                type="text"
                                id="refreshToken"
                                value="{{ $refresh_token }}"
                                readonly
                                class="flex-1 min-w-0 bg-ink border border-white/10 rounded-sm px-4 py-3 text-warm font-mono text-sm focus:outline-none focus:border-copper"
                            >
                            <button
                                type="button"
                                onclick="copyToken()"
                                class="bg-copper hover:bg-copper-hover text-ink px-4 py-3 rounded-sm font-medium text-sm transition-colors whitespace-nowrap shrink-0"
                            >
                                Copy
                            </button>
                        </div>
                    </div>

                    <div class="bg-copper/10 border border-copper/25 rounded-sm p-4 mb-6">
                        <p class="text-sm text-copper mb-3 font-medium"><strong>Next steps</strong></p>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-muted">
                            <li>Open your <code class="bg-panel-2 px-1 py-0.5 rounded-sm text-xs text-warm">.env</code> file</li>
                            <li>Add or update this line:</li>
                        </ol>
                        <div class="mt-3 bg-ink border border-white/10 rounded-sm p-3">
                            <code class="text-sm text-spotify break-all">SPOTIFY_REFRESH_TOKEN={{ $refresh_token }}</code>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-4">
                        <a href="/" class="bg-copper hover:bg-copper-hover text-ink px-6 py-3 rounded-sm font-medium transition-colors text-sm inline-flex items-center justify-center">
                            Go to home
                        </a>
                        <button
                            type="button"
                            onclick="copyEnvLine()"
                            class="bg-panel-2 hover:bg-panel-3 border border-white/10 text-warm px-6 py-3 rounded-sm font-medium transition-colors text-sm"
                        >
                            Copy .env line
                        </button>
                    </div>
                @else
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-500/15 rounded-full flex items-center justify-center ring-1 ring-red-500/25">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h1 class="font-display text-2xl text-warm">Setup failed</h1>
                        </div>
                        <div class="bg-red-500/10 border border-red-500/20 rounded-sm p-4 mb-6">
                            <p class="text-red-400">{{ $message ?? 'An unknown error occurred' }}</p>
                        </div>
                    </div>

                    <a href="/spotify/auth" class="inline-block bg-copper hover:bg-copper-hover text-ink px-6 py-3 rounded-sm font-medium transition-colors text-sm">
                        Try again
                    </a>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyToken() {
            const tokenInput = document.getElementById('refreshToken');
            tokenInput.select();
            tokenInput.setSelectionRange(0, 99999);
            document.execCommand('copy');

            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('bg-spotify', 'hover:opacity-90', 'text-ink');
            button.classList.remove('bg-copper', 'hover:bg-copper-hover');

            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-spotify', 'hover:opacity-90', 'text-ink');
                button.classList.add('bg-copper', 'hover:bg-copper-hover');
            }, 2000);
        }

        function copyEnvLine() {
            const refreshToken = document.getElementById('refreshToken').value;
            const envLine = `SPOTIFY_REFRESH_TOKEN=${refreshToken}`;
            navigator.clipboard.writeText(envLine).then(() => {
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.add('bg-spotify', 'text-ink', 'border-spotify/40');
                button.classList.remove('bg-panel-2', 'hover:bg-panel-3', 'border-white/10');

                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-spotify', 'text-ink', 'border-spotify/40');
                    button.classList.add('bg-panel-2', 'hover:bg-panel-3', 'border-white/10');
                }, 2000);
            });
        }
    </script>
</body>
</html>

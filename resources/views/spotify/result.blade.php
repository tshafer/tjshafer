<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spotify Setup - tjshafer.com</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen antialiased">
    <div class="min-h-screen flex items-center justify-center px-6 py-12">
        <div class="max-w-2xl w-full">
            <div class="bg-slate-900 border border-slate-800 rounded-lg p-8">
                @if(isset($success) && $success && isset($refresh_token))
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h1 class="text-2xl font-semibold text-white">Success!</h1>
                        </div>
                        <p class="text-slate-400 mb-6">Your refresh token has been generated. Copy it below and add it to your <code class="bg-slate-800 px-2 py-1 rounded text-sm">.env</code> file.</p>
                    </div>
                    
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-6 mb-6">
                        <label class="block text-xs font-medium text-slate-400 mb-2">Your Refresh Token:</label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="text" 
                                id="refreshToken" 
                                value="{{ $refresh_token }}" 
                                readonly
                                class="flex-1 bg-slate-900 border border-slate-700 rounded px-4 py-3 text-white font-mono text-sm focus:outline-none focus:border-blue-500"
                            >
                            <button 
                                onclick="copyToken()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded font-medium text-sm transition-colors whitespace-nowrap"
                            >
                                Copy
                            </button>
                        </div>
                    </div>
                    
                    <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4 mb-6">
                        <p class="text-sm text-blue-400 mb-3"><strong>Next steps:</strong></p>
                        <ol class="list-decimal list-inside space-y-2 text-sm text-slate-300">
                            <li>Open your <code class="bg-slate-800 px-1 py-0.5 rounded text-xs">.env</code> file</li>
                            <li>Add or update this line:</li>
                        </ol>
                        <div class="mt-3 bg-slate-900 border border-slate-700 rounded p-3">
                            <code class="text-sm text-green-400">SPOTIFY_REFRESH_TOKEN={{ $refresh_token }}</code>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors text-sm">
                            Go to Home
                        </a>
                        <button 
                            onclick="copyEnvLine()" 
                            class="bg-slate-800 hover:bg-slate-700 text-white px-6 py-3 rounded-lg font-medium transition-colors text-sm"
                        >
                            Copy .env Line
                        </button>
                    </div>
                @else
                    <div class="mb-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-red-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h1 class="text-2xl font-semibold text-white">Setup Failed</h1>
                        </div>
                        <div class="bg-red-500/10 border border-red-500/20 rounded-lg p-4 mb-6">
                            <p class="text-red-400">{{ $message ?? 'An unknown error occurred' }}</p>
                        </div>
                    </div>
                    
                    <a href="/spotify/auth" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors text-sm">
                        Try Again
                    </a>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyToken() {
            const tokenInput = document.getElementById('refreshToken');
            tokenInput.select();
            tokenInput.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');
            
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Copied!';
            button.classList.add('bg-green-600', 'hover:bg-green-700');
            button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            
            setTimeout(() => {
                button.textContent = originalText;
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700');
            }, 2000);
        }
        
        function copyEnvLine() {
            const refreshToken = document.getElementById('refreshToken').value;
            const envLine = `SPOTIFY_REFRESH_TOKEN=${refreshToken}`;
            navigator.clipboard.writeText(envLine).then(() => {
                const button = event.target;
                const originalText = button.textContent;
                button.textContent = 'Copied!';
                button.classList.add('bg-green-600', 'hover:bg-green-700');
                button.classList.remove('bg-slate-800', 'hover:bg-slate-700');
                
                setTimeout(() => {
                    button.textContent = originalText;
                    button.classList.remove('bg-green-600', 'hover:bg-green-700');
                    button.classList.add('bg-slate-800', 'hover:bg-slate-700');
                }, 2000);
            });
        }
    </script>
</body>
</html>

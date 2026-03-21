<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Tom Shafer — software and projects under Shafer LLC. Based in Arizona.')">

    <title>@yield('title', 'Tom Shafer · Shafer LLC')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/tom-shafer-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/tom-shafer-logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-mono:400,500|italiana:400|jost:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen font-sans">
    <div class="min-h-screen flex flex-col relative z-10">
        <header class="sticky top-0 z-40 border-b border-white/10 bg-ink/85 backdrop-blur-md">
            <div class="max-w-6xl mx-auto px-5 sm:px-8">
                <nav class="flex items-center justify-between min-h-[4.25rem] gap-3 py-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group min-w-0 shrink">
                        <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="Tom Shafer" width="40" height="40" class="h-9 w-9 sm:h-10 sm:w-10 rounded-full object-cover ring-2 ring-copper/35 shadow-md shrink-0 group-hover:ring-copper/60 transition-shadow">
                        <div class="hidden sm:flex flex-col min-w-0 leading-tight">
                            <span class="font-display text-lg tracking-wide text-warm truncate">shafer<span class="text-copper">.</span>llc</span>
                            <span class="font-mono text-[0.65rem] uppercase tracking-[0.2em] text-muted">Limited liability company</span>
                        </div>
                    </a>
                    <div class="flex items-center gap-3 sm:gap-5 min-w-0">
                        <a href="https://shafer.llc" rel="noopener" class="font-mono text-xs uppercase tracking-wider text-copper hover:text-copper-hover transition-colors hidden md:inline shrink-0">shafer.llc</a>
                        @include('partials.nav')
                    </div>
                </nav>
            </div>
        </header>

        <main class="flex-1">
            @yield('content')
        </main>

        <footer class="border-t border-white/10 bg-panel/50">
            <div class="max-w-6xl mx-auto px-5 sm:px-8 py-10 flex flex-col gap-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4 text-center sm:text-left">
                        <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="" width="48" height="48" class="h-12 w-12 rounded-full object-cover ring-1 ring-copper/30 shrink-0" aria-hidden="true">
                        <p class="text-muted text-sm">
                            <span class="font-display text-warm text-base tracking-wide">shafer<span class="text-copper">.</span>llc</span>
                            <span class="block font-mono text-[0.65rem] uppercase tracking-[0.2em] mt-1">© {{ date('Y') }} Shafer LLC · Arizona</span>
                        </p>
                    </div>
                    <a href="https://shafer.llc" rel="noopener" class="font-mono text-xs text-copper hover:text-copper-hover transition-colors">shafer.llc →</a>
                </div>
                <nav class="flex flex-wrap justify-center gap-x-4 gap-y-2 text-xs text-muted font-mono uppercase tracking-wider border-t border-white/10 pt-8">
                    <a href="{{ route('projects.index') }}" class="hover:text-copper transition-colors">Projects</a>
                    <a href="{{ route('writing.index') }}" class="hover:text-copper transition-colors">Writing</a>
                    <a href="{{ route('now') }}" class="hover:text-copper transition-colors">Now</a>
                    <a href="{{ route('uses') }}" class="hover:text-copper transition-colors">Uses</a>
                    <a href="{{ route('booking') }}" class="hover:text-copper transition-colors">Book</a>
                    <a href="{{ route('resume') }}" class="hover:text-copper transition-colors">Résumé</a>
                    <a href="{{ route('colophon') }}" class="hover:text-copper transition-colors">Colophon</a>
                    <a href="{{ route('feed') }}" class="hover:text-copper transition-colors">RSS</a>
                </nav>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>

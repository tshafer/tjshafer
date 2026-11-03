<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'Tom Shafer runs Shafer LLC: Laravel, WordPress, and PHP + Vue. Based in Arizona.')">

    <title>@yield('title', 'Tom Shafer · Shafer LLC')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/tom-shafer-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/tom-shafer-logo.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=ibm-plex-mono:400,500" rel="stylesheet" />

    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex flex-col font-sans">
    <header class="border-b border-white/10">
        <nav class="max-w-6xl w-full mx-auto px-5 sm:px-8 py-4 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="" width="32" height="32" class="h-8 w-8 rounded-full object-cover">
                <span>tom<span class="text-copper">.</span>shafer</span>
            </a>
            <div class="flex items-center gap-4 sm:gap-6 text-sm">
                <a href="{{ route('projects.index') }}" class="{{ request()->routeIs('projects.*') ? 'text-warm' : 'text-muted hover:text-warm' }}">Projects</a>
                <a href="https://shafer.llc/contact" rel="noopener" class="text-copper hover:text-warm">Start a project</a>
            </div>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-white/10">
        <p class="max-w-6xl mx-auto px-5 sm:px-8 py-6 text-xs text-muted">
            © {{ date('Y') }} Shafer LLC · Arizona · <a href="mailto:tom@shafer.llc" class="hover:text-copper">tom@shafer.llc</a> · <a href="https://shafer.llc" rel="noopener" class="hover:text-copper">shafer.llc</a>
        </p>
    </footer>
</body>
</html>

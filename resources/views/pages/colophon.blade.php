@extends('layouts.site')

@section('title', 'Colophon · Tom Shafer')

@section('meta_description', 'How tjshafer.com is built: stack, fonts, and privacy-minded notes.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Colophon</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-12">How this site is made</p>

        <div class="article-markdown max-w-2xl space-y-8 text-muted leading-relaxed">
            <section>
                <h2 class="font-display text-2xl text-warm mb-3">Stack</h2>
                <ul class="list-disc list-inside space-y-2 text-sm">
                    <li><strong class="text-warm">Framework:</strong> Laravel 13, PHP 8.5</li>
                    <li><strong class="text-warm">Frontend:</strong> Blade, Tailwind CSS 4, Vite</li>
                    <li><strong class="text-warm">Content:</strong> Markdown posts in <code class="text-copper">content/posts/</code>, JSON for projects</li>
                    <li><strong class="text-warm">Feed:</strong> <a href="{{ route('feed') }}" class="text-copper hover:text-copper-hover">RSS</a></li>
                </ul>
            </section>
            <section>
                <h2 class="font-display text-2xl text-warm mb-3">Typography</h2>
                <p class="text-sm">Italiana (display), Jost (UI), IBM Plex Mono (mono) — served via <a href="https://fonts.bunny.net" rel="noopener" class="text-copper hover:text-copper-hover">Bunny Fonts</a>.</p>
            </section>
            <section>
                <h2 class="font-display text-2xl text-warm mb-3">Analytics &amp; privacy</h2>
                <p class="text-sm">This site does not use mainstream third-party analytics (for example Google Analytics). Traffic is measured with <strong class="text-warm">our own setup</strong> on <a href="https://observe.dply.io" rel="noopener noreferrer" class="text-copper hover:text-copper-hover">observe.dply.io</a> — privacy-oriented page views and referrers, no ad tracking or cross-site profiles.</p>
            </section>
        </div>
    </div>
@endsection

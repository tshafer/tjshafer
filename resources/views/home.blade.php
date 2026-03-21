@extends('layouts.site')

@section('title', 'Tom Shafer · Shafer LLC')

@section('content')
    <section class="relative overflow-hidden border-b border-white/10">
        <div class="absolute inset-0 bg-gradient-to-br from-copper/10 via-transparent to-transparent pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-[min(55vw,28rem)] h-full border-l border-copper/20 pointer-events-none hidden lg:block animate-shimmer opacity-40"></div>
        <div class="max-w-6xl mx-auto px-5 sm:px-8 pt-14 pb-20 lg:pt-20 lg:pb-28 relative">
            <div class="max-w-4xl opacity-0 animate-[rise-fade_0.85s_cubic-bezier(0.22,1,0.36,1)_forwards]">
                <div class="flex flex-col sm:flex-row gap-10 sm:gap-12 items-start mb-10">
                    <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="Tom Shafer — web developer" width="176" height="176" class="w-36 h-36 sm:w-44 sm:h-44 rounded-full object-cover ring-2 ring-copper/40 shadow-xl shrink-0 mx-auto sm:mx-0">
                    <div class="flex-1 min-w-0 text-center sm:text-left">
                        <p class="font-mono text-copper text-xs sm:text-sm tracking-[0.35em] uppercase mb-6">Operated by Tom Shafer</p>
                        <h1 class="font-display text-warm text-[clamp(2.75rem,10vw,6.5rem)] leading-[0.92] tracking-tight mb-8">
                            shafer<span class="text-copper">.</span>llc
                        </h1>
                    </div>
                </div>
                <p class="text-balance text-lg sm:text-xl text-muted max-w-xl mb-10 leading-relaxed font-normal">
                    This site and related work are held under <strong class="text-warm font-semibold">Shafer LLC</strong> — a small Arizona company for software, consulting, and creative projects.
                </p>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4">
                    <a href="https://shafer.llc" rel="noopener" class="inline-flex items-center gap-2 rounded-sm bg-copper px-5 py-3 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                        Visit shafer.llc
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <span class="inline-flex items-center gap-2 text-sm text-muted">
                        <svg class="w-4 h-4 text-copper shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        Arizona, United States
                    </span>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-24">
        <section id="about" class="mb-24 lg:mb-32">
            <h2 class="font-display text-3xl sm:text-4xl mb-3 text-warm tracking-tight">
                About
            </h2>
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-10">Shafer LLC</p>
            <div class="space-y-6 text-muted leading-relaxed max-w-2xl">
                <p class="text-lg text-warm/90">
                    Welcome. I'm <span class="text-warm font-semibold">Tom Shafer</span> — <span class="text-warm font-semibold">42</span>, based in <span class="text-warm font-semibold">Arizona</span>, and I run this site under <span class="text-warm font-semibold">Shafer LLC</span>.
                </p>
                <p>
                    I build software and like hard problems. This domain is my home on the web for projects, experiments, and staying in touch with people in tech.
                </p>
                @if (($social['employer'] ?? null) || ! empty($social['maintains']) || ! empty($social['sites_built']))
                    <div class="space-y-3 text-muted">
                        @if ($social['employer'] ?? null)
                            <p>
                                I currently work at
                                <a href="{{ $social['employer']['url'] }}" rel="noopener" class="text-copper hover:text-copper-hover underline decoration-copper/35 underline-offset-4">{{ $social['employer']['name'] }}</a>.
                            </p>
                        @endif
                        @if (! empty($social['maintains']))
                            <p>
                                I maintain
                                @foreach ($social['maintains'] as $m)
                                    <a href="{{ $m['url'] }}" rel="noopener" class="text-copper hover:text-copper-hover underline decoration-copper/35 underline-offset-4">{{ $m['name'] }}</a>@if (! $loop->last), @endif
                                @endforeach.
                            </p>
                        @endif
                        @if (! empty($social['sites_built']))
                            <p>
                                Sites I've built include
                                @foreach ($social['sites_built'] as $s)
                                    <a href="{{ $s['url'] }}" rel="noopener" class="text-copper hover:text-copper-hover underline decoration-copper/35 underline-offset-4">{{ $s['name'] }}</a>@if (! $loop->last) and @endif
                                @endforeach.
                            </p>
                        @endif
                    </div>
                @endif
                <p>
                    If you're curious about work under the LLC, want to collaborate, or just want to say hello, reach out — I read every message.
                </p>
            </div>
        </section>

        <section class="mb-24 lg:mb-32">
            <h2 class="font-display text-3xl sm:text-4xl mb-10 text-warm tracking-tight">
                What I Do
            </h2>
            <div class="grid md:grid-cols-3 gap-5">
                <div class="bg-panel border border-white/10 rounded-sm p-6 hover:border-copper/40 transition-colors">
                    <div class="w-10 h-10 bg-panel-2 rounded-sm flex items-center justify-center mb-4 ring-1 ring-white/5">
                        <svg class="w-5 h-5 text-copper" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-warm">Development</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        Web apps, APIs, and pragmatic software under the LLC
                    </p>
                </div>
                <div class="bg-panel border border-white/10 rounded-sm p-6 hover:border-copper/40 transition-colors">
                    <div class="w-10 h-10 bg-panel-2 rounded-sm flex items-center justify-center mb-4 ring-1 ring-white/5">
                        <svg class="w-5 h-5 text-copper" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-warm">Innovation</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        New tools, sharp edges, and creative experiments
                    </p>
                </div>
                <div class="bg-panel border border-white/10 rounded-sm p-6 hover:border-copper/40 transition-colors">
                    <div class="w-10 h-10 bg-panel-2 rounded-sm flex items-center justify-center mb-4 ring-1 ring-white/5">
                        <svg class="w-5 h-5 text-copper" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-warm">Collaboration</h3>
                    <p class="text-muted text-sm leading-relaxed">
                        Partnering with teams to ship real outcomes
                    </p>
                </div>
            </div>
        </section>

        @if (($github ?? null) || ! empty($social['testimonials']) || ! empty($social['trusted_by']) || ! empty($social['sites_built']) || ! empty($social['maintains']) || ($social['employer'] ?? null))
            <section class="mb-24 lg:mb-32" aria-label="Social proof">
                <h2 class="font-display text-3xl sm:text-4xl mb-10 text-warm tracking-tight">
                    Out there
                </h2>
                <div class="grid gap-8 @if ($github ?? null) lg:grid-cols-2 @endif">
                    @if ($github ?? null)
                        <div class="bg-panel border border-white/10 rounded-sm p-6">
                            <h3 class="text-sm font-mono uppercase tracking-wider text-copper mb-4">GitHub</h3>
                            <div class="flex items-center gap-4">
                                <img src="{{ $github['avatar_url'] ?? '' }}" alt="" class="w-16 h-16 rounded-full ring-1 ring-white/10" width="64" height="64">
                                <div>
                                    <a href="{{ $github['html_url'] ?? '#' }}" rel="noopener" class="text-lg font-semibold text-warm hover:text-copper transition-colors">{{ $github['login'] ?? config('site.github_username') }}</a>
                                    <div class="flex flex-wrap gap-4 mt-2 text-sm text-muted">
                                        @if(isset($github['public_repos']))
                                            <span><strong class="text-warm">{{ number_format($github['public_repos']) }}</strong> repos</span>
                                        @endif
                                        @if(isset($github['followers']))
                                            <span><strong class="text-warm">{{ number_format($github['followers']) }}</strong> followers</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="space-y-6">
                        @if ($social['employer'] ?? null)
                            <div class="bg-panel border border-white/10 rounded-sm p-6">
                                <h3 class="text-sm font-mono uppercase tracking-wider text-copper mb-3">Day job</h3>
                                <p class="text-sm text-muted">
                                    <a href="{{ $social['employer']['url'] }}" rel="noopener" class="text-warm hover:text-copper transition-colors font-medium">{{ $social['employer']['name'] }}</a>
                                </p>
                            </div>
                        @endif
                        @if (! empty($social['maintains']))
                            <div class="bg-panel border border-white/10 rounded-sm p-6">
                                <h3 class="text-sm font-mono uppercase tracking-wider text-copper mb-3">I maintain</h3>
                                <ul class="text-sm text-muted space-y-2 list-none pl-0">
                                    @foreach ($social['maintains'] as $m)
                                        <li>
                                            <a href="{{ $m['url'] }}" rel="noopener" class="text-warm hover:text-copper transition-colors">{{ $m['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (! empty($social['sites_built']))
                            <div class="bg-panel border border-white/10 rounded-sm p-6">
                                <h3 class="text-sm font-mono uppercase tracking-wider text-copper mb-3">Sites I built</h3>
                                <ul class="text-sm text-muted space-y-2 list-none pl-0">
                                    @foreach ($social['sites_built'] as $s)
                                        <li>
                                            <a href="{{ $s['url'] }}" rel="noopener" class="text-warm hover:text-copper transition-colors">{{ $s['name'] }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (! empty($social['trusted_by']))
                            <div class="bg-panel border border-white/10 rounded-sm p-6">
                                <h3 class="text-sm font-mono uppercase tracking-wider text-copper mb-3">Trusted by</h3>
                                <p class="text-sm text-muted">{{ implode(' · ', $social['trusted_by']) }}</p>
                            </div>
                        @endif
                        @foreach ($social['testimonials'] ?? [] as $t)
                            <blockquote class="bg-panel border border-white/10 rounded-sm p-6">
                                <p class="text-warm/90 leading-relaxed text-sm">“{{ $t['quote'] ?? '' }}”</p>
                                <footer class="mt-3 text-xs font-mono text-muted">
                                    — {{ $t['name'] ?? '' }}@if(!empty($t['role'])), {{ $t['role'] }} @endif
                                </footer>
                            </blockquote>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section id="music" class="mb-24 lg:mb-32">
            <h2 class="font-display text-3xl sm:text-4xl mb-3 text-warm tracking-tight">
                Music
            </h2>
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-muted mb-8">Spotify</p>
            <div class="bg-panel border border-white/10 rounded-sm p-8 max-w-2xl flex flex-col sm:flex-row sm:items-center gap-6">
                <div class="w-14 h-14 rounded-sm bg-panel-2 ring-1 ring-white/10 flex items-center justify-center shrink-0">
                    <svg class="w-8 h-8 text-spotify" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.84-.179-.84-.66 0-.359.24-.66.54-.779 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.242 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-muted leading-relaxed mb-4">
                        Headphones are almost always on — coding, training, or winding down. Live now-playing, top artists, playlists, and listening stats live on a dedicated page.
                    </p>
                    <a href="{{ route('music') }}" class="inline-flex items-center gap-2 rounded-sm bg-copper px-5 py-2.5 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                        Open music &amp; Spotify
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <section id="contact" class="mb-16">
            <h2 class="font-display text-3xl sm:text-4xl mb-3 text-warm tracking-tight">
                Contact
            </h2>
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-10">Shafer LLC</p>
            <div class="bg-panel border border-white/10 rounded-sm p-8 max-w-xl">
                <p class="text-muted mb-6 leading-relaxed">
                    For collaborations, consulting, or a friendly hello — email is best. Business on the web lives at <a href="https://shafer.llc" rel="noopener" class="text-copper hover:text-copper-hover underline decoration-copper/40 underline-offset-4">shafer.llc</a>.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-copper hover:bg-copper-hover text-ink px-6 py-3 rounded-sm font-medium transition-colors text-sm">
                        Contact form
                    </a>
                    <a href="mailto:tj@tjshafer.com" class="inline-flex items-center gap-2 border border-white/15 hover:border-copper/50 text-warm px-6 py-3 rounded-sm font-medium transition-colors text-sm">
                        tj@tjshafer.com
                    </a>
                    <a href="https://shafer.llc" rel="noopener" class="inline-flex items-center gap-2 border border-white/15 hover:border-copper/50 text-warm px-6 py-3 rounded-sm font-medium transition-colors text-sm">
                        shafer.llc
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection

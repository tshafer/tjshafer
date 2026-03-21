@extends('layouts.site')

@section('title', 'Uses · Tom Shafer')

@section('meta_description', 'Hardware, software, editor, and hosting stack Tom Shafer uses day to day.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Uses</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-12">Tools &amp; setup</p>

        <div class="grid gap-10 md:grid-cols-2 max-w-4xl">
            <div class="bg-panel border border-white/10 rounded-sm p-6">
                <h2 class="text-lg font-semibold text-warm mb-4">Hardware</h2>
                <ul class="text-muted space-y-2 text-sm leading-relaxed list-disc list-inside">
                    <li>Customize this list — laptop, displays, audio, desk.</li>
                    <li>Arizona-based; desert hours, reliable power &amp; network.</li>
                </ul>
            </div>
            <div class="bg-panel border border-white/10 rounded-sm p-6">
                <h2 class="text-lg font-semibold text-warm mb-4">Software</h2>
                <ul class="text-muted space-y-2 text-sm leading-relaxed list-disc list-inside">
                    <li><strong class="text-warm">Editor:</strong> Cursor / VS Code–family — tune to taste.</li>
                    <li><strong class="text-warm">Stack:</strong> Laravel, PHP, Tailwind, Vite, SQLite/MySQL as needed.</li>
                    <li><strong class="text-warm">Terminal:</strong> zsh, git, Composer, npm.</li>
                </ul>
            </div>
            <div class="bg-panel border border-white/10 rounded-sm p-6 md:col-span-2">
                <h2 class="text-lg font-semibold text-warm mb-4">Hosting &amp; deploy</h2>
                <p class="text-muted text-sm leading-relaxed">
                    This site runs on <strong class="text-warm">Laravel</strong> with assets built by <strong class="text-warm">Vite</strong>. Plug in your real host (Forge, Vapor, Docker, etc.) here — it helps people evaluating how you ship.
                </p>
            </div>
        </div>
    </div>
@endsection

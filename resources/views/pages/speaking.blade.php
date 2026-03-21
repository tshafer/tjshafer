@extends('layouts.site')

@section('title', 'Speaking & media · Tom Shafer')

@section('meta_description', 'Talks, podcasts, and media featuring Tom Shafer.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Speaking &amp; media</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-12">Appearances</p>
        <p class="text-muted max-w-2xl mb-10 leading-relaxed">
            Curated list — edit <code class="text-copper text-sm">content/speaking.json</code> to add real events, URLs, and embeds.
        </p>

        <ul class="space-y-4 max-w-3xl">
            @forelse ($items as $item)
                <li class="bg-panel border border-white/10 rounded-sm p-6">
                    <div class="flex flex-wrap items-baseline justify-between gap-2 mb-2">
                        <h2 class="text-lg font-semibold text-warm">{{ $item['title'] ?? 'Untitled' }}</h2>
                        <span class="text-xs font-mono text-muted uppercase tracking-wider">{{ $item['format'] ?? 'Event' }}</span>
                    </div>
                    <p class="text-sm text-muted mb-1">{{ $item['event'] ?? '' }} @if(!empty($item['date'])) · {{ $item['date'] }} @endif</p>
                    @if(!empty($item['notes']))
                        <p class="text-sm text-muted/90 mt-2">{{ $item['notes'] }}</p>
                    @endif
                    @if(!empty($item['url']))
                        <a href="{{ $item['url'] }}" rel="noopener" class="inline-flex mt-3 text-sm text-copper hover:text-copper-hover">Watch / listen →</a>
                    @endif
                </li>
            @empty
                <li class="text-muted">No entries yet.</li>
            @endforelse
        </ul>
    </div>
@endsection

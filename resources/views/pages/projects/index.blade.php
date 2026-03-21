@extends('layouts.site')

@section('title', 'Projects · Tom Shafer')

@section('meta_description', 'Selected projects and case studies from Tom Shafer / Shafer LLC.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Projects</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-8">Portfolio</p>

        @if ($allTags->isNotEmpty())
            <div class="flex flex-wrap gap-2 mb-12">
                <a href="{{ route('projects.index') }}"
                   class="rounded-sm px-3 py-1 text-xs font-mono uppercase tracking-wider border transition-colors {{ $activeTag ? 'border-white/10 text-muted hover:border-copper/40' : 'border-copper/50 text-copper' }}">
                    All
                </a>
                @foreach ($allTags as $tag)
                    <a href="{{ route('projects.index', ['tag' => $tag]) }}"
                       class="rounded-sm px-3 py-1 text-xs font-mono uppercase tracking-wider border transition-colors {{ $activeTag === $tag ? 'border-copper/50 text-copper' : 'border-white/10 text-muted hover:border-copper/40' }}">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        @endif

        <ul class="space-y-6">
            @forelse ($projects as $project)
                <li class="bg-panel border border-white/10 rounded-sm p-8 hover:border-copper/30 transition-colors">
                    <h2 class="font-display text-2xl text-warm mb-2">{{ $project['title'] ?? 'Project' }}</h2>
                    <p class="text-muted text-sm leading-relaxed mb-3">{{ $project['summary'] ?? '' }}</p>
                    @if(!empty($project['outcome']))
                        <p class="text-sm text-warm/90 mb-4"><strong class="text-copper">Outcome:</strong> {{ $project['outcome'] }}</p>
                    @endif
                    @if(!empty($project['stack']))
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach ($project['stack'] as $tech)
                                <span class="rounded-sm bg-panel-2 px-2 py-0.5 text-xs font-mono text-muted">{{ $tech }}</span>
                            @endforeach
                        </div>
                    @endif
                    <div class="flex flex-wrap gap-4 text-sm">
                        @if(!empty($project['links']['live']))
                            <a href="{{ $project['links']['live'] }}" rel="noopener" class="text-copper hover:text-copper-hover">Live →</a>
                        @endif
                        @if(!empty($project['links']['repo']))
                            <a href="{{ $project['links']['repo'] }}" rel="noopener" class="text-muted hover:text-warm">Repository →</a>
                        @endif
                    </div>
                </li>
            @empty
                <li class="text-muted">No projects match this filter.</li>
            @endforelse
        </ul>
    </div>
@endsection

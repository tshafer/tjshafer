@extends('layouts.site')

@section('title', 'Projects · Tom Shafer')

@section('meta_description', 'Apps and tools from Shafer LLC.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-10">Projects</h1>

        <ul class="space-y-8 max-w-2xl">
            @foreach ($projects as $project)
                <li>
                    <h2 class="text-lg text-warm">
                        @if (! empty($project['links']['live']))
                            <a href="{{ $project['links']['live'] }}" rel="noopener" class="hover:text-copper">{{ $project['title'] }}</a>
                        @else
                            {{ $project['title'] }}
                        @endif
                    </h2>
                    <p class="text-muted text-sm leading-relaxed mt-1">{{ $project['summary'] }}</p>
                </li>
            @endforeach
        </ul>

        <p class="mt-12 text-sm text-muted">
            Client work is at <a href="https://shafer.llc/portfolio" rel="noopener" class="text-warm hover:text-copper">shafer.llc</a>.
            <a href="https://shafer.llc/contact" rel="noopener" class="text-copper hover:text-warm">Start a project</a>.
        </p>
    </div>
@endsection

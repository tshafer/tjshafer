@extends('layouts.site')

@section('title', 'Writing · Tom Shafer')

@section('meta_description', 'Dev log and notes — Markdown posts from tjshafer.com.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-10">Writing</h1>

        <ul class="space-y-4 max-w-2xl">
            @forelse ($posts as $post)
                <li class="border-b border-white/10 pb-4">
                    <a href="{{ route('writing.show', $post['slug']) }}" class="group">
                        <span class="font-display text-xl text-warm group-hover:text-copper transition-colors">{{ $post['title'] }}</span>
                        <span class="block text-xs font-mono text-muted mt-1">{{ $post['date'] }}</span>
                        @if(!empty($post['excerpt']))
                            <p class="text-sm text-muted mt-2 leading-relaxed">{{ $post['excerpt'] }}</p>
                        @endif
                    </a>
                </li>
            @empty
                <li class="text-muted">No posts yet — add a <code class="text-copper">.md</code> file under <code class="text-copper">content/posts/</code>.</li>
            @endforelse
        </ul>
    </div>
@endsection

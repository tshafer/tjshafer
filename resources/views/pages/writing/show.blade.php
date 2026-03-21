@extends('layouts.site')

@section('title', e($post['title']).' · Writing')

@section('meta_description', $post['excerpt'] ?? \Illuminate\Support\Str::limit(strip_tags($post['body']), 160))

@section('content')
    <article class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <header class="max-w-2xl mb-10">
            <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-4">
                <a href="{{ route('writing.index') }}" class="hover:text-copper-hover">Writing</a>
            </p>
            <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">{{ $post['title'] }}</h1>
            <time class="text-sm font-mono text-muted" datetime="{{ $post['date'] }}">{{ $post['date'] }}</time>
        </header>
        <div class="article-markdown max-w-2xl text-muted leading-relaxed">
            {!! $post['html'] !!}
        </div>
    </article>
@endsection

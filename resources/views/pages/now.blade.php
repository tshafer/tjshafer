@extends('layouts.site')

@section('title', 'Now · Tom Shafer')

@section('meta_description', 'What Tom Shafer is focused on lately — a /now page.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Now</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-8">Current focus</p>
        @if(!empty($updated))
            <p class="text-xs font-mono text-muted mb-10">Last updated: {{ $updated }}</p>
        @endif
        <div class="article-markdown max-w-2xl text-muted leading-relaxed">
            {!! $html !!}
        </div>
    </div>
@endsection

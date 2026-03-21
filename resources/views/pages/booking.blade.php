@extends('layouts.site')

@section('title', 'Book a call · Tom Shafer')

@section('meta_description', 'Schedule time with Tom Shafer — intro calls and consulting.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Book a call</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-10">Calendar</p>

        @if($embedUrl)
            <div class="max-w-4xl rounded-sm border border-white/10 overflow-hidden bg-panel min-h-[600px]">
                <iframe src="{{ $embedUrl }}" title="Booking calendar" class="w-full h-[min(80vh,720px)] border-0" loading="lazy"></iframe>
            </div>
        @else
            <div class="max-w-xl bg-panel border border-white/10 rounded-sm p-8">
                <p class="text-muted leading-relaxed mb-6">
                    Embed Cal.com, Calendly, or similar by setting <code class="text-copper text-sm">SITE_BOOKING_EMBED_URL</code> in your <code class="text-copper text-sm">.env</code> (full embed URL).
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-sm bg-copper px-5 py-3 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                    Contact form instead
                </a>
            </div>
        @endif
    </div>
@endsection

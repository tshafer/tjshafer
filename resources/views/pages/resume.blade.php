@extends('layouts.site')

@section('title', 'Résumé · Tom Shafer')

@section('meta_description', 'Tom Shafer — résumé, JSON Resume download, and optional PDF.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Résumé</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-10">CV</p>

        <div class="flex flex-wrap gap-4 mb-12">
            <a href="{{ url('/resume.json') }}" rel="noopener" class="inline-flex items-center gap-2 rounded-sm border border-white/15 px-4 py-2 text-sm text-warm hover:border-copper/50 transition-colors">
                Download JSON Resume
            </a>
            @if (file_exists(public_path('resume.pdf')))
                <a href="{{ asset('resume.pdf') }}" rel="noopener" class="inline-flex items-center gap-2 rounded-sm bg-copper px-4 py-2 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                    Download PDF
                </a>
            @else
                <span class="text-xs text-muted self-center">Add <code class="text-copper">public/resume.pdf</code> for a PDF button.</span>
            @endif
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-sm border border-white/15 px-4 py-2 text-sm text-muted hover:text-warm transition-colors print:hidden">
                Print this page
            </button>
        </div>

        @if ($resume)
            <div class="max-w-3xl space-y-10 text-muted print:text-black">
                <header class="border-b border-white/10 pb-8 print:border-gray-300">
                    <div class="flex flex-col sm:flex-row gap-8 items-start">
                        <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="" class="w-28 h-28 rounded-full object-cover ring-2 ring-copper/35 shrink-0 print:hidden" width="112" height="112">
                        <div>
                            <h2 class="font-display text-3xl text-warm print:text-black">{{ $resume['basics']['name'] ?? 'Tom Shafer' }}</h2>
                            @if(!empty($resume['basics']['label']))
                                <p class="text-copper print:text-gray-700 mt-1">{{ $resume['basics']['label'] }}</p>
                            @endif
                            <p class="text-sm mt-4 space-y-1">
                                @if(!empty($resume['basics']['email']))
                                    <span class="block">{{ $resume['basics']['email'] }}</span>
                                @endif
                                @if(!empty($resume['basics']['url']))
                                    <a href="{{ $resume['basics']['url'] }}" class="text-copper hover:underline print:text-black">{{ $resume['basics']['url'] }}</a>
                                @endif
                            </p>
                            @if(!empty($resume['basics']['summary']))
                                <p class="text-sm mt-4 leading-relaxed text-warm/90 print:text-gray-800">{{ $resume['basics']['summary'] }}</p>
                            @endif
                        </div>
                    </div>
                </header>

                @if(!empty($resume['work']))
                    <section>
                        <h3 class="font-display text-xl text-warm print:text-black mb-4">Experience</h3>
                        <ul class="space-y-6 text-sm">
                            @foreach ($resume['work'] as $job)
                                <li>
                                    <div class="font-semibold text-warm print:text-black">{{ $job['name'] ?? '' }}</div>
                                    <div class="text-muted print:text-gray-600">{{ $job['position'] ?? '' }} @if(!empty($job['startDate'])) · {{ $job['startDate'] }} @endif</div>
                                    @if(!empty($job['summary']))
                                        <p class="mt-2 leading-relaxed">{{ $job['summary'] }}</p>
                                    @endif
                                    @if(!empty($job['highlights']))
                                        <ul class="mt-2 list-disc list-inside space-y-1">
                                            @foreach ($job['highlights'] as $h)
                                                <li>{{ $h }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif

                @if(!empty($resume['skills']))
                    <section>
                        <h3 class="font-display text-xl text-warm print:text-black mb-4">Skills</h3>
                        <ul class="space-y-3 text-sm">
                            @foreach ($resume['skills'] as $skill)
                                <li>
                                    <span class="text-warm print:text-black font-medium">{{ $skill['name'] ?? '' }}</span>
                                    @if(!empty($skill['keywords']))
                                        <span class="text-muted print:text-gray-600"> — {{ implode(', ', $skill['keywords']) }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif
            </div>
        @else
            <p class="text-muted">Could not load <code class="text-copper">public/resume.json</code>.</p>
        @endif
    </div>
@endsection

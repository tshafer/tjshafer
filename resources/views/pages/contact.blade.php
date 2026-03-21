@extends('layouts.site')

@section('title', 'Contact · Tom Shafer')

@section('meta_description', 'Contact Tom Shafer / Shafer LLC — secure form with honeypot anti-spam.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Contact</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-10">Shafer LLC</p>

        @if (session('status'))
            <div class="mb-8 rounded-sm border border-spotify/40 bg-spotify/10 px-4 py-3 text-sm text-warm max-w-xl">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid gap-12 lg:grid-cols-2 max-w-5xl">
            <div>
                <p class="text-muted leading-relaxed mb-6">
                    Prefer email? <a href="mailto:tj@tjshafer.com" class="text-copper hover:text-copper-hover">tj@tjshafer.com</a>
                    · <a href="https://shafer.llc" rel="noopener" class="text-copper hover:text-copper-hover">shafer.llc</a>
                </p>
                <form method="post" action="{{ route('contact.store') }}" class="relative space-y-5 max-w-md">
                    @csrf
                    <div class="absolute -left-[9999px] opacity-0 w-0 h-0 overflow-hidden" aria-hidden="true">
                        <label>Leave blank</label>
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>
                    <div>
                        <label for="name" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Name</label>
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               class="w-full rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none">
                        @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Email</label>
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               class="w-full rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none">
                        @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="message" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Message</label>
                        <textarea id="message" name="message" rows="6" required
                                  class="w-full rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none resize-y">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="rounded-sm bg-copper px-6 py-3 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                        Send message
                    </button>
                </form>
            </div>
            <div class="hidden lg:flex items-center justify-center">
                <img src="{{ asset('images/tom-shafer-logo.png') }}" alt="" class="w-48 h-48 rounded-full object-cover ring-2 ring-copper/35 opacity-90" width="192" height="192">
            </div>
        </div>
    </div>
@endsection

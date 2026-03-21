@extends('layouts.site')

@section('title', 'Book a call · Tom Shafer')

@section('meta_description', 'Schedule time with Tom Shafer — intro calls and consulting.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Book a call</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-4">Calendar</p>
        <p class="text-muted text-sm max-w-2xl mb-10 leading-relaxed">
            Pick a slot in <strong class="text-warm font-normal">{{ $timezoneLabel }}</strong>. You will get a confirmation by email once the request is accepted.
        </p>

        @if (session('status'))
            <div class="mb-8 rounded-sm border border-spotify/40 bg-spotify/10 px-4 py-3 text-sm text-warm max-w-xl">
                {{ session('status') }}
            </div>
        @endif

        @if ($slotsByDay->isEmpty())
            <div class="max-w-xl bg-panel border border-white/10 rounded-sm p-8">
                <p class="text-muted leading-relaxed mb-6">
                    No openings in the next few days. Try again later or reach out directly.
                </p>
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 rounded-sm bg-copper px-5 py-3 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                    Contact form
                </a>
            </div>
        @else
            <form method="post" action="{{ route('booking.store') }}" class="relative max-w-3xl space-y-10">
                @csrf
                <div class="absolute -left-[9999px] opacity-0 w-0 h-0 overflow-hidden" aria-hidden="true">
                    <label>Leave blank</label>
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <fieldset class="space-y-8 border-0 p-0 m-0">
                    <legend class="sr-only">Choose a time</legend>
                    @foreach ($slotsByDay as $dateKey => $daySlots)
                        @php
                            $dayHeading = \Carbon\Carbon::parse($dateKey.' 12:00:00', $timezoneLabel)->format('l, F j');
                        @endphp
                        <div>
                            <h2 class="font-mono text-xs uppercase tracking-[0.2em] text-copper mb-4">{{ $dayHeading }}</h2>
                            <ul class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($daySlots as $slot)
                                    @php
                                        $slotValue = $slot['startUtc']->utc()->format('Y-m-d\TH:i:s\Z').'|'.$slot['endUtc']->utc()->format('Y-m-d\TH:i:s\Z');
                                    @endphp
                                    <li>
                                        <label class="flex cursor-pointer items-center gap-3 rounded-sm border border-white/10 bg-panel px-4 py-3 text-sm text-warm transition-colors has-[:checked]:border-copper/60 has-[:checked]:bg-copper/5 hover:border-white/20">
                                            <input type="radio" name="booking_slot" value="{{ $slotValue }}" class="shrink-0 border-white/30 text-copper focus:ring-copper" {{ old('booking_slot') === $slotValue ? 'checked' : '' }} required>
                                            <span>{{ $slot['label'] }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </fieldset>

                @error('slot')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror
                @error('booking_slot')
                    <p class="text-red-400 text-sm">{{ $message }}</p>
                @enderror

                <div class="space-y-5 border-t border-white/10 pt-10">
                    <div>
                        <label for="booking-name" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Name</label>
                        <input id="booking-name" name="name" type="text" required value="{{ old('name') }}"
                               class="w-full max-w-md rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none">
                        @error('name')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="booking-email" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Email</label>
                        <input id="booking-email" name="email" type="email" required value="{{ old('email') }}"
                               class="w-full max-w-md rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none">
                        @error('email')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="booking-message" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Notes <span class="text-muted normal-case tracking-normal">(optional)</span></label>
                        <textarea id="booking-message" name="message" rows="4"
                                  class="w-full max-w-xl rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none resize-y">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-400 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="rounded-sm bg-copper px-6 py-3 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                        Request this time
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection

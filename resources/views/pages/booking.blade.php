@extends('layouts.site')

@section('title', 'Book a call · Tom Shafer')

@section('meta_description', 'Schedule time with Tom Shafer — intro calls and consulting.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-4">Book a call</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-6">Calendar</p>
        <p class="text-muted text-sm max-w-2xl mb-8 leading-relaxed">
            All times are in <strong class="text-warm font-normal">{{ $timezoneLabel }}</strong>. Pick one slot, add your details, and I will follow up by email to confirm.
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
            <form method="post" action="{{ route('booking.store') }}" class="relative max-w-2xl" id="booking-form">
                @csrf
                <div class="absolute -left-[9999px] opacity-0 w-0 h-0 overflow-hidden" aria-hidden="true">
                    <label>Leave blank</label>
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="rounded-lg border border-white/10 bg-panel/80 p-5 sm:p-6 mb-8">
                    <h2 class="font-display text-lg text-warm mb-3">How it works</h2>
                    <ol class="text-sm text-muted space-y-2 list-none counter-reset-[step] pl-0">
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-copper/40 bg-copper/10 font-mono text-xs text-copper" aria-hidden="true">1</span>
                            <span><span class="text-warm">Choose a day</span> — open a row below.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-copper/40 bg-copper/10 font-mono text-xs text-copper" aria-hidden="true">2</span>
                            <span><span class="text-warm">Tap a time</span> — one slot per request.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full border border-copper/40 bg-copper/10 font-mono text-xs text-copper" aria-hidden="true">3</span>
                            <span><span class="text-warm">Send the request</span> — I will confirm by email.</span>
                        </li>
                    </ol>
                </div>

                <div class="mb-6" data-booking-picker>
                    <p class="text-xs font-mono uppercase tracking-wider text-muted mb-4" id="slot-section-label">Available times</p>

                    @foreach ($slotsByDay as $dateKey => $daySlots)
                        @php
                            $day = \Carbon\Carbon::parse($dateKey.' 12:00:00', $timezoneLabel);
                            $todayStart = \Carbon\Carbon::now($timezoneLabel)->startOfDay();
                            $dayStart = $day->copy()->startOfDay();
                            if ($dayStart->equalTo($todayStart)) {
                                $dayPrimary = 'Today';
                                $daySecondary = $day->format('l, M j');
                            } elseif ($dayStart->equalTo($todayStart->copy()->addDay())) {
                                $dayPrimary = 'Tomorrow';
                                $daySecondary = $day->format('l, M j');
                            } else {
                                $dayPrimary = $day->format('l');
                                $daySecondary = $day->format('M j, Y');
                            }
                            $count = $daySlots->count();
                        @endphp
                        <details
                            name="booking-day"
                            class="booking-day group mb-3 rounded-lg border border-white/10 bg-panel overflow-hidden transition-[border-color,box-shadow] open:border-copper/35 open:ring-1 open:ring-copper/20"
                            @if ($loop->first) open @endif
                        >
                            <summary class="cursor-pointer list-none [&::-webkit-details-marker]:hidden flex w-full items-center justify-between gap-4 px-4 py-4 sm:px-5 sm:py-4 text-left hover:bg-white/[0.03] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-copper/50 focus-visible:ring-offset-2 focus-visible:ring-offset-ink">
                                <span class="min-w-0">
                                    <span class="block font-display text-xl sm:text-2xl text-warm tracking-tight">{{ $dayPrimary }}</span>
                                    <span class="mt-0.5 block text-sm text-muted">{{ $daySecondary }} · {{ $count }} {{ $count === 1 ? 'slot' : 'slots' }}</span>
                                </span>
                                <span class="shrink-0 text-copper/80 transition-transform duration-200 group-open:rotate-180" aria-hidden="true">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </summary>
                            <div class="border-t border-white/5 px-4 pb-5 pt-1 sm:px-5">
                                <fieldset class="border-0 p-0 m-0">
                                    <legend class="sr-only">Times for {{ $dayPrimary }}, {{ $daySecondary }}</legend>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-4">
                                        @foreach ($daySlots as $slot)
                                            @php
                                                $slotValue = $slot['startUtc']->utc()->format('Y-m-d\TH:i:s\Z').'|'.$slot['endUtc']->utc()->format('Y-m-d\TH:i:s\Z');
                                                $startLocal = \Carbon\Carbon::parse($slot['startUtc'])->timezone($timezoneLabel);
                                                $endLocal = \Carbon\Carbon::parse($slot['endUtc'])->timezone($timezoneLabel);
                                                if ($startLocal->format('A') === $endLocal->format('A')) {
                                                    $timeLine = $startLocal->format('g:i').'–'.$endLocal->format('g:i A');
                                                } else {
                                                    $timeLine = $startLocal->format('g:i A').' – '.$endLocal->format('g:i A');
                                                }
                                            @endphp
                                            <label class="relative block cursor-pointer rounded-md border border-white/10 bg-ink/40 px-4 py-3.5 text-center transition-all hover:border-white/20 hover:bg-ink/60 has-[:checked]:border-copper has-[:checked]:bg-copper/10 has-[:checked]:shadow-[inset_0_0_0_1px_rgba(194,123,53,0.35)] focus-within:ring-2 focus-within:ring-copper/50 focus-within:ring-offset-2 focus-within:ring-offset-ink">
                                                <input
                                                    type="radio"
                                                    name="booking_slot"
                                                    value="{{ $slotValue }}"
                                                    class="peer sr-only"
                                                    data-slot-label="{{ $dayPrimary }} · {{ $daySecondary }} · {{ $timeLine }}"
                                                    {{ old('booking_slot') === $slotValue ? 'checked' : '' }}
                                                    @if ($loop->parent->first && $loop->first) required @endif
                                                >
                                                <span class="block font-semibold text-warm text-base leading-tight">{{ $timeLine }}</span>
                                                <span class="mt-1 block text-[0.65rem] font-mono uppercase tracking-wider text-muted/90">{{ (int) config('booking.slot_minutes', 30) }} min</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </fieldset>
                            </div>
                        </details>
                    @endforeach
                </div>

                <p class="mb-8 min-h-[1.25rem] text-sm text-copper/90" id="booking-slot-summary" role="status" aria-live="polite" hidden></p>

                @error('slot')
                    <p class="text-red-400 text-sm mb-4">{{ $message }}</p>
                @enderror
                @error('booking_slot')
                    <p class="text-red-400 text-sm mb-4">{{ $message }}</p>
                @enderror

                <div class="space-y-5 border-t border-white/10 pt-10">
                    <h2 class="font-display text-xl text-warm">Your details</h2>
                    <p class="text-sm text-muted -mt-2">So I can reply and confirm the time.</p>
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
                    <button type="submit" class="rounded-sm bg-copper px-6 py-3.5 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                        Send request
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection

@push('scripts')
    @if (! $slotsByDay->isEmpty())
        <script>
            (function () {
                var form = document.getElementById('booking-form');
                var summaryEl = document.getElementById('booking-slot-summary');
                if (!form || !summaryEl) return;

                function updateSummary() {
                    var checked = form.querySelector('input[name="booking_slot"]:checked');
                    if (checked && checked.dataset.slotLabel) {
                        summaryEl.hidden = false;
                        summaryEl.textContent = 'Selected: ' + checked.dataset.slotLabel;
                    } else {
                        summaryEl.hidden = true;
                        summaryEl.textContent = '';
                    }
                }

                form.addEventListener('change', function (e) {
                    if (e.target && e.target.name === 'booking_slot') updateSummary();
                });
                updateSummary();
            })();
        </script>
    @endif
@endpush

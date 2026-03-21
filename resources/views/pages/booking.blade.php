@extends('layouts.site')

@section('title', 'Book a call · Tom Shafer')

@section('meta_description', 'Schedule time with Tom Shafer — intro calls and consulting.')

@section('content')
    @php
        $slotMins = (int) config('booking.slot_minutes', 30);
    @endphp
    <div class="page-booking relative max-w-6xl mx-auto px-5 sm:px-8 py-14 sm:py-20 lg:py-24">
        {{-- Top accent --}}
        <div class="pointer-events-none absolute left-1/2 top-0 h-px w-[min(100%,42rem)] -translate-x-1/2 bg-gradient-to-r from-transparent via-copper/50 to-transparent" aria-hidden="true"></div>
        <div class="pointer-events-none absolute left-1/2 top-6 hidden h-24 w-px -translate-x-1/2 bg-gradient-to-b from-copper/30 to-transparent sm:block" aria-hidden="true"></div>

        @if (session('status'))
            <div class="mb-10 max-w-2xl rounded-xl border border-spotify/35 bg-spotify/10 px-5 py-4 text-sm text-warm">
                {{ session('status') }}
            </div>
        @endif

        @if ($slotsByDay->isEmpty())
            <header class="mb-10 max-w-2xl">
                <p class="mb-4 font-mono text-[0.65rem] uppercase tracking-[0.35em] text-copper">Schedule</p>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl text-warm leading-[1.05] tracking-tight">Book a call</h1>
                <p class="mt-6 text-muted leading-relaxed">No openings in the next stretch of the calendar.</p>
            </header>
            <div class="max-w-md rounded-2xl border border-white/10 bg-gradient-to-br from-panel to-panel-2 p-8 shadow-[0_0_0_1px_rgba(255,255,255,0.04)_inset]">
                <p class="text-sm text-muted leading-relaxed mb-8">
                    Check back soon, or send a note and we will find a time manually.
                </p>
                <a href="{{ route('contact') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-copper px-6 py-4 text-sm font-semibold text-ink transition-colors hover:bg-copper-hover sm:w-auto">
                    Open contact form
                </a>
            </div>
        @else
            <header class="relative mb-10 lg:mb-14">
                <div class="grid gap-10 lg:grid-cols-[1fr_minmax(12rem,auto)] lg:items-end lg:gap-12">
                    <div>
                        <p class="mb-4 font-mono text-[0.65rem] uppercase tracking-[0.35em] text-copper">Schedule · Shafer LLC</p>
                        <h1 class="font-display text-4xl sm:text-5xl lg:text-[3.5rem] text-warm leading-[1.02] tracking-tight">
                            Book a call
                        </h1>
                        <p class="mt-6 max-w-xl text-base text-muted leading-relaxed sm:text-lg">
                            Choose one window below. Everything is in <strong class="font-medium text-warm">{{ $timezoneLabel }}</strong>. I will email you to confirm before it is final.
                        </p>
                    </div>
                    <dl class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1 lg:text-right">
                        <div class="rounded-2xl border border-white/10 bg-panel-2/60 px-5 py-4 backdrop-blur-sm">
                            <dt class="font-mono text-[0.65rem] uppercase tracking-wider text-muted">Length</dt>
                            <dd class="mt-1 font-display text-2xl text-warm">{{ $slotMins }} min</dd>
                        </div>
                        <div class="rounded-2xl border border-copper/25 bg-copper/5 px-5 py-4">
                            <dt class="font-mono text-[0.65rem] uppercase tracking-wider text-copper/90">Zone</dt>
                            <dd class="mt-1 text-sm font-medium leading-snug text-warm">{{ $timezoneLabel }}</dd>
                        </div>
                    </dl>
                </div>
            </header>

            <form method="post" action="{{ route('booking.store') }}" class="relative" id="booking-form">
                @csrf
                <div class="absolute -left-[9999px] opacity-0 w-0 h-0 overflow-hidden" aria-hidden="true">
                    <label>Leave blank</label>
                    <input type="text" name="website" tabindex="-1" autocomplete="off">
                </div>

                {{-- Step strip --}}
                <ol class="mb-8 flex flex-wrap gap-4 text-sm text-muted lg:mb-10" aria-label="Steps">
                    <li class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-copper/35 bg-copper/10 font-mono text-xs text-copper">1</span>
                        <span class="text-warm">Pick a day &amp; time</span>
                    </li>
                    <li class="hidden text-white/20 sm:block" aria-hidden="true">→</li>
                    <li class="flex items-center gap-2">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg border border-white/15 bg-panel-2 font-mono text-xs text-muted">2</span>
                        <span>Your details</span>
                    </li>
                </ol>

                {{-- Sticky day jump --}}
                <div class="sticky top-[4.5rem] z-20 -mx-5 mb-8 border-b border-white/5 bg-ink/80 px-5 py-4 backdrop-blur-md lg:static lg:z-0 lg:mx-0 lg:mb-10 lg:border-0 lg:bg-transparent lg:px-0 lg:py-0 lg:backdrop-blur-none">
                    <p class="mb-3 font-mono text-[0.65rem] uppercase tracking-[0.2em] text-muted">Jump to day</p>
                    <div class="flex gap-2 overflow-x-auto pb-1 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" role="tablist" aria-label="Days with availability">
                        @foreach ($slotsByDay as $dateKey => $daySlots)
                            @php
                                $day = \Carbon\Carbon::parse($dateKey.' 12:00:00', $timezoneLabel);
                                $todayStart = \Carbon\Carbon::now($timezoneLabel)->startOfDay();
                                $dayStart = $day->copy()->startOfDay();
                                if ($dayStart->equalTo($todayStart)) {
                                    $chipLabel = 'Today';
                                } elseif ($dayStart->equalTo($todayStart->copy()->addDay())) {
                                    $chipLabel = 'Tomorrow';
                                } else {
                                    $chipLabel = $day->format('D j');
                                }
                            @endphp
                            <button
                                type="button"
                                class="booking-day-chip {{ $loop->first ? 'is-active' : '' }}"
                                data-booking-jump="{{ $dateKey }}"
                                role="tab"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            >
                                {{ $chipLabel }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Days timeline --}}
                <div class="relative mb-10 max-w-3xl lg:pl-8">
                    <div class="absolute left-[0.65rem] top-3 bottom-3 hidden w-px bg-gradient-to-b from-copper/40 via-white/10 to-transparent lg:block" aria-hidden="true"></div>

                    <div class="space-y-6" data-booking-picker>
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
                                id="booking-day-{{ $dateKey }}"
                                data-booking-day="{{ $dateKey }}"
                                class="booking-day group relative rounded-2xl border border-white/10 bg-gradient-to-br from-panel-2/80 to-panel/60 shadow-[0_0_0_1px_rgba(255,255,255,0.03)_inset] transition-[border-color,box-shadow] open:border-copper/40 open:shadow-[0_0_0_1px_rgba(194,123,53,0.2)_inset,0_12px_40px_-20px_rgba(0,0,0,0.5)]"
                                @if ($loop->first) open @endif
                            >
                                <summary class="flex w-full cursor-pointer list-none items-start gap-4 px-5 py-5 sm:px-6 sm:py-5 [&::-webkit-details-marker]:hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-copper/50 focus-visible:ring-offset-2 focus-visible:ring-offset-ink">
                                    <span class="mt-1 hidden h-3 w-3 shrink-0 rounded-full border-2 border-copper/50 bg-copper/30 shadow-[0_0_12px_rgba(194,123,53,0.4)] lg:block" aria-hidden="true"></span>
                                    <span class="min-w-0 flex-1 text-left">
                                        <span class="block font-display text-2xl sm:text-3xl text-warm tracking-tight">{{ $dayPrimary }}</span>
                                        <span class="mt-1 block text-sm text-muted">{{ $daySecondary }} · {{ $count }} {{ $count === 1 ? 'opening' : 'openings' }}</span>
                                    </span>
                                    <span class="shrink-0 rounded-lg border border-white/10 p-2 text-copper transition-transform duration-200 group-open:rotate-180" aria-hidden="true">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </span>
                                </summary>
                                <div class="border-t border-white/5 px-5 pb-6 pt-2 sm:px-6">
                                    <fieldset class="m-0 border-0 p-0">
                                        <legend class="sr-only">Times for {{ $dayPrimary }}, {{ $daySecondary }}</legend>
                                        <p class="mb-4 font-mono text-[0.65rem] uppercase tracking-wider text-muted">Start time</p>
                                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-3.5">
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
                                                <label class="booking-time-pill">
                                                    <input
                                                        type="radio"
                                                        name="booking_slot"
                                                        value="{{ $slotValue }}"
                                                        class="peer sr-only"
                                                        data-slot-label="{{ $dayPrimary }} · {{ $daySecondary }} · {{ $timeLine }}"
                                                        {{ old('booking_slot') === $slotValue ? 'checked' : '' }}
                                                        @if ($loop->parent->first && $loop->first) required @endif
                                                    >
                                                    <span class="font-mono text-base font-semibold tracking-tight text-warm">{{ $timeLine }}</span>
                                                    <span class="mt-1 font-mono text-[0.6rem] uppercase tracking-[0.15em] text-muted/80">{{ $slotMins }} min</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>
                            </details>
                        @endforeach
                    </div>
                </div>

                <div
                    class="mb-10 min-h-[3.5rem] rounded-2xl border border-dashed border-copper/25 bg-copper/[0.06] px-5 py-4 transition-colors"
                    id="booking-slot-summary-wrap"
                    hidden
                >
                    <p class="font-mono text-[0.65rem] uppercase tracking-wider text-copper/90">Your pick</p>
                    <p class="mt-1 font-display text-xl text-warm" id="booking-slot-summary" role="status" aria-live="polite"></p>
                </div>

                @error('slot')
                    <p class="mb-6 text-sm text-red-400">{{ $message }}</p>
                @enderror
                @error('booking_slot')
                    <p class="mb-6 text-sm text-red-400">{{ $message }}</p>
                @enderror

                <div class="max-w-xl space-y-6 rounded-2xl border border-white/10 bg-gradient-to-b from-panel-2/50 to-panel/30 p-6 sm:p-8">
                    <div class="flex items-center gap-3 border-b border-white/10 pb-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/15 bg-panel font-mono text-sm text-copper">2</span>
                        <div>
                            <h2 class="font-display text-2xl text-warm">Your details</h2>
                            <p class="text-sm text-muted">So I can reply and lock the time.</p>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <label for="booking-name" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-wider text-muted">Name</label>
                            <input id="booking-name" name="name" type="text" required value="{{ old('name') }}"
                                   autocomplete="name"
                                   class="w-full rounded-xl border border-white/10 bg-ink/80 px-4 py-3.5 text-warm placeholder:text-muted/50 focus:border-copper focus:outline-none focus:ring-1 focus:ring-copper/40">
                            @error('name')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="booking-email" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-wider text-muted">Email</label>
                            <input id="booking-email" name="email" type="email" required value="{{ old('email') }}"
                                   autocomplete="email"
                                   class="w-full rounded-xl border border-white/10 bg-ink/80 px-4 py-3.5 text-warm placeholder:text-muted/50 focus:border-copper focus:outline-none focus:ring-1 focus:ring-copper/40">
                            @error('email')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="booking-message" class="mb-2 block font-mono text-[0.65rem] uppercase tracking-wider text-muted">Notes <span class="font-sans normal-case tracking-normal text-muted/80">(optional)</span></label>
                            <textarea id="booking-message" name="message" rows="4"
                                      class="w-full resize-y rounded-xl border border-white/10 bg-ink/80 px-4 py-3.5 text-warm placeholder:text-muted/50 focus:border-copper focus:outline-none focus:ring-1 focus:ring-copper/40">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="w-full rounded-xl bg-copper py-4 text-sm font-semibold text-ink transition-colors hover:bg-copper-hover sm:w-auto sm:px-10">
                            Send booking request
                        </button>
                    </div>
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
                var summaryWrap = document.getElementById('booking-slot-summary-wrap');
                if (!form || !summaryEl || !summaryWrap) return;

                function updateSummary() {
                    var checked = form.querySelector('input[name="booking_slot"]:checked');
                    if (checked && checked.dataset.slotLabel) {
                        summaryWrap.hidden = false;
                        summaryEl.textContent = checked.dataset.slotLabel;
                    } else {
                        summaryWrap.hidden = true;
                        summaryEl.textContent = '';
                    }
                }

                form.addEventListener('change', function (e) {
                    if (e.target && e.target.name === 'booking_slot') updateSummary();
                });
                updateSummary();

                var chips = document.querySelectorAll('[data-booking-jump]');
                var detailsList = form.querySelectorAll('details[data-booking-day]');

                chips.forEach(function (chip) {
                    chip.addEventListener('click', function () {
                        var key = chip.getAttribute('data-booking-jump');
                        var target = document.getElementById('booking-day-' + key);
                        if (!target) return;

                        detailsList.forEach(function (d) {
                            d.open = d === target;
                        });

                        chips.forEach(function (c) {
                            c.classList.toggle('is-active', c === chip);
                            c.setAttribute('aria-selected', c === chip ? 'true' : 'false');
                        });

                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    });
                });

                detailsList.forEach(function (detail) {
                    detail.addEventListener('toggle', function () {
                        if (!detail.open) return;
                        var key = detail.getAttribute('data-booking-day');
                        chips.forEach(function (c) {
                            var match = c.getAttribute('data-booking-jump') === key;
                            c.classList.toggle('is-active', match);
                            c.setAttribute('aria-selected', match ? 'true' : 'false');
                        });
                    });
                });
            })();
        </script>
    @endif
@endpush

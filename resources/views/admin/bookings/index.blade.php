@extends('layouts.site')

@section('title', 'Bookings · Admin')

@section('meta_description', 'Manage booking requests.')

@section('content')
    <div class="max-w-6xl mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10">
            <div>
                <h1 class="font-display text-4xl sm:text-5xl text-warm tracking-tight mb-2">Bookings</h1>
                <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper">Admin · {{ $timezoneLabel }}</p>
            </div>
            <form method="post" action="{{ route('admin.bookings.logout') }}">
                @csrf
                <button type="submit" class="text-sm text-muted hover:text-copper transition-colors font-mono uppercase tracking-wider">
                    Sign out
                </button>
            </form>
        </div>

        @if (session('status'))
            <div class="mb-6 rounded-sm border border-spotify/40 bg-spotify/10 px-4 py-3 text-sm text-warm max-w-xl">
                {{ session('status') }}
            </div>
        @endif

        @error('booking')
            <div class="mb-6 rounded-sm border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200 max-w-xl">
                {{ $message }}
            </div>
        @enderror

        @if ($bookings->isEmpty())
            <p class="text-muted">No bookings yet.</p>
        @else
            <div class="overflow-x-auto rounded-sm border border-white/10">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-white/10 font-mono text-xs uppercase tracking-wider text-muted">
                            <th class="px-4 py-3">When ({{ $timezoneLabel }})</th>
                            <th class="px-4 py-3">Guest</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-warm">
                        @foreach ($bookings as $booking)
                            @php
                                $startLocal = $booking->starts_at->copy()->timezone($timezoneLabel);
                                $endLocal = $booking->ends_at->copy()->timezone($timezoneLabel);
                            @endphp
                            <tr class="border-b border-white/5 align-top">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="block font-medium">{{ $startLocal->format('D, M j, Y') }}</span>
                                    <span class="text-muted">{{ $startLocal->format('g:i A') }} – {{ $endLocal->format('g:i A') }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="block">{{ $booking->name }}</span>
                                    <a href="mailto:{{ $booking->email }}" class="text-copper hover:text-copper-hover text-xs break-all">{{ $booking->email }}</a>
                                    @if (filled($booking->message))
                                        <p class="text-muted text-xs mt-2 max-w-xs">{{ \Illuminate\Support\Str::limit($booking->message, 160) }}</p>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <span @class([
                                        'inline-flex rounded-sm px-2 py-0.5 text-xs font-mono uppercase tracking-wider',
                                        'bg-amber-500/15 text-amber-200 border border-amber-500/30' => $booking->status === 'pending',
                                        'bg-spotify/15 text-spotify border border-spotify/30' => $booking->status === 'confirmed',
                                        'bg-white/5 text-muted border border-white/10' => $booking->status === 'cancelled',
                                    ])>{{ $booking->status }}</span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <div class="flex flex-col sm:flex-row gap-2 justify-end">
                                        @if ($booking->status === 'pending')
                                            <form method="post" action="{{ route('admin.bookings.confirm', $booking) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="rounded-sm border border-copper/50 px-3 py-1.5 text-xs font-semibold text-copper hover:bg-copper/10 transition-colors">
                                                    Confirm
                                                </button>
                                            </form>
                                        @endif
                                        @if ($booking->status !== 'cancelled')
                                            <form method="post" action="{{ route('admin.bookings.cancel', $booking) }}" class="inline" onsubmit="return confirm('Cancel this booking?');">
                                                @csrf
                                                <button type="submit" class="rounded-sm border border-white/15 px-3 py-1.5 text-xs text-muted hover:text-warm hover:border-white/25 transition-colors">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
@endsection

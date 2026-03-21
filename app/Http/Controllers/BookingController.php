<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingSlotService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct(
        private BookingSlotService $slots
    ) {}

    public function create(): View
    {
        return view('pages.booking', [
            'slotsByDay' => $this->slots->slotsGroupedByDate(),
            'timezoneLabel' => $this->slots->timezone(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (filled($request->input('website'))) {
            return redirect()->route('booking')->with('status', 'Your call is booked — you will receive a confirmation email.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'booking_slot' => ['required', 'string', 'regex:/^[^|]+\|[^|]+$/'],
        ]);

        [$startRaw, $endRaw] = explode('|', $validated['booking_slot'], 2);
        $startUtc = Carbon::parse($startRaw)->utc();
        $endUtc = Carbon::parse($endRaw)->utc();

        if (! $this->slots->isSlotBookable($startUtc, $endUtc)) {
            return redirect()->route('booking')
                ->withInput($request->except('booking_slot'))
                ->withErrors(['slot' => 'That time is no longer available. Pick another slot.']);
        }

        $booked = DB::transaction(function () use ($validated, $startUtc, $endUtc) {
            $overlap = Booking::query()
                ->blocking()
                ->where('starts_at', '<', $endUtc)
                ->where('ends_at', '>', $startUtc)
                ->lockForUpdate()
                ->exists();

            if ($overlap) {
                return false;
            }

            Booking::query()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'message' => $validated['message'] ?? null,
                'starts_at' => $startUtc,
                'ends_at' => $endUtc,
                'timezone' => 'UTC',
                'status' => 'pending',
            ]);

            return true;
        });

        if (! $booked) {
            return redirect()->route('booking')
                ->withInput($request->except('booking_slot'))
                ->withErrors(['slot' => 'That time was just taken. Pick another slot.']);
        }

        $to = config('site.contact_email');
        $tz = $this->slots->timezone();
        $localStart = $startUtc->copy()->timezone($tz)->format('l, M j, Y g:i A');
        $localEnd = $endUtc->copy()->timezone($tz)->format('g:i A T');

        $body = "New booking request\n\n".
            "Name: {$validated['name']}\n".
            "Email: {$validated['email']}\n".
            "When: {$localStart} – {$localEnd}\n".
            (filled($validated['message'] ?? null) ? "\nNotes:\n{$validated['message']}\n" : '');

        Mail::raw($body, function ($message) use ($validated, $to, $localStart) {
            $message->to($to)
                ->replyTo($validated['email'], $validated['name'])
                ->subject('Booking request: '.$localStart);
        });

        return redirect()->route('booking')->with('status', 'Request sent — check your email for next steps. I will confirm shortly.');
    }
}

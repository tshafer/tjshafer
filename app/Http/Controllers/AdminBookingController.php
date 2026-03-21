<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingSlotService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminBookingController extends Controller
{
    public function __construct(
        private BookingSlotService $slots
    ) {}

    public function index(): View
    {
        $bookings = Booking::query()
            ->orderByRaw("CASE status WHEN 'pending' THEN 0 WHEN 'confirmed' THEN 1 ELSE 2 END")
            ->orderBy('starts_at')
            ->paginate(30);

        return view('admin.bookings.index', [
            'bookings' => $bookings,
            'timezoneLabel' => $this->slots->timezone(),
        ]);
    }

    public function confirm(Booking $booking): RedirectResponse
    {
        if ($booking->status !== 'pending') {
            return back()->withErrors(['booking' => 'Only pending requests can be confirmed.']);
        }

        $booking->update(['status' => 'confirmed']);

        return back()->with('status', 'Marked as confirmed.');
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        if ($booking->status === 'cancelled') {
            return back()->with('status', 'Already cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('status', 'Booking cancelled.');
    }
}

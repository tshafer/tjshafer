<?php

namespace Tests\Feature;

use App\Mail\BookingRequestNotification;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo(Carbon::parse('2025-03-19 08:00:00', 'America/Phoenix'));
    }

    public function test_booking_page_returns_ok(): void
    {
        $this->get('/booking')->assertOk();
    }

    public function test_booking_submission_creates_pending_booking_and_redirects(): void
    {
        Mail::fake();

        $start = Carbon::parse('2025-03-19 13:00:00', 'America/Phoenix')->utc();
        $end = Carbon::parse('2025-03-19 13:30:00', 'America/Phoenix')->utc();
        $slot = $start->format('Y-m-d\TH:i:s\Z').'|'.$end->format('Y-m-d\TH:i:s\Z');

        $response = $this->post('/booking', [
            'name' => 'Alex',
            'email' => 'alex@example.com',
            'message' => 'Quick intro',
            'booking_slot' => $slot,
        ]);

        $response->assertRedirect(route('booking'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('bookings', [
            'email' => 'alex@example.com',
            'status' => 'pending',
        ]);

        Mail::assertSent(BookingRequestNotification::class, function (BookingRequestNotification $mail): bool {
            return $mail->booking->email === 'alex@example.com'
                && str_contains($mail->plainBody, 'Alex');
        });
    }

    public function test_booking_honeypot_does_not_persist(): void
    {
        $before = Booking::query()->count();

        $this->post('/booking', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'website' => 'http://spam.example',
            'booking_slot' => 'invalid',
        ]);

        $this->assertSame($before, Booking::query()->count());
    }
}

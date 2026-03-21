<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Services\BookingIcsGenerator;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookingIcsGeneratorTest extends TestCase
{
    #[Test]
    public function it_builds_a_valid_ics_document(): void
    {
        config(['app.url' => 'https://tjshafer.com']);

        $booking = new Booking;
        $booking->forceFill([
            'name' => 'Alex Example',
            'email' => 'alex@example.com',
            'message' => 'Notes here',
            'starts_at' => Carbon::parse('2025-03-19 20:00:00', 'UTC'),
            'ends_at' => Carbon::parse('2025-03-19 20:30:00', 'UTC'),
            'timezone' => 'UTC',
            'status' => 'pending',
        ]);
        $booking->id = 42;
        $booking->syncOriginal();

        $ics = app(BookingIcsGenerator::class)->forBooking($booking);

        $this->assertStringContainsString('BEGIN:VCALENDAR', $ics);
        $this->assertStringContainsString('END:VCALENDAR', $ics);
        $this->assertStringContainsString('UID:booking-42@tjshafer.com', $ics);
        $this->assertStringContainsString('DTSTART:20250319T200000Z', $ics);
        $this->assertStringContainsString('DTEND:20250319T203000Z', $ics);
        $this->assertStringContainsString('ATTENDEE:mailto:alex@example.com', $ics);
    }
}

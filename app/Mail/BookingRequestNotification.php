<?php

namespace App\Mail;

use App\Models\Booking;
use App\Services\BookingIcsGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingRequestNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $plainBody,
    ) {}

    public function envelope(): Envelope
    {
        $tz = config('booking.timezone', 'America/Phoenix');
        $subjectStart = $this->booking->starts_at->copy()->timezone($tz)->format('M j, Y g:i A');

        return new Envelope(
            subject: 'Booking request: '.$subjectStart,
            replyTo: [
                new Address($this->booking->email, $this->booking->name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            text: 'emails.booking-request',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $ics = app(BookingIcsGenerator::class)->forBooking($this->booking);

        return [
            Attachment::fromData(fn () => $ics, 'booking-request.ics')
                ->withMime('text/calendar; charset=UTF-8'),
        ];
    }
}

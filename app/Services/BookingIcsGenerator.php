<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Str;

class BookingIcsGenerator
{
    public function forBooking(Booking $booking): string
    {
        $host = parse_url((string) config('app.url'), PHP_URL_HOST) ?: 'localhost';
        $uid = 'booking-'.$booking->getKey().'@'.$host;

        $dtStamp = now('UTC')->format('Ymd\THis\Z');
        $dtStart = $booking->starts_at->copy()->utc()->format('Ymd\THis\Z');
        $dtEnd = $booking->ends_at->copy()->utc()->format('Ymd\THis\Z');

        $organizer = config('site.contact_email');
        $summary = $this->escape('Call: '.$booking->name);
        $description = $this->escape(trim(
            "Booking request (pending confirmation)\n\n".
            "Guest: {$booking->name} <{$booking->email}>\n".
            (filled($booking->message) ? "\nNotes:\n".$booking->message."\n" : '')
        ));

        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//tjshafer//Booking//EN',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:'.$uid,
            'DTSTAMP:'.$dtStamp,
            'DTSTART:'.$dtStart,
            'DTEND:'.$dtEnd,
            'SUMMARY:'.$summary,
            'DESCRIPTION:'.$description,
            'ORGANIZER:mailto:'.$organizer,
            'ATTENDEE:mailto:'.$booking->email,
            'STATUS:TENTATIVE',
            'END:VEVENT',
            'END:VCALENDAR',
        ];

        return Str::of(implode("\r\n", $lines))->append("\r\n")->toString();
    }

    private function escape(string $text): string
    {
        $text = str_replace(["\r\n", "\r", "\n"], '\n', $text);

        return str_replace(['\\', ';', ','], ['\\\\', '\\;', '\\,'], $text);
    }
}

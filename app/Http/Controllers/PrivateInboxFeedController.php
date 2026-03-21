<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ContactMessage;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class PrivateInboxFeedController extends Controller
{
    public function __invoke(string $token): Response
    {
        $expected = config('site.inbox_feed_token');
        $expected = is_string($expected) ? trim($expected) : '';
        $token = trim($token);

        if ($expected === '' || ! hash_equals($expected, $token)) {
            abort(404);
        }

        $siteUrl = rtrim((string) config('site.app_url'), '/');
        $feedUrl = $siteUrl.'/feed/inbox/'.$token;
        $tz = config('booking.timezone', 'America/Phoenix');

        $items = $this->collectItems($tz);
        $lastBuildDate = $items->isNotEmpty() ? $items->first()['pubDate'] : now('UTC')->format('r');

        return response()
            ->view('feed.inbox', [
                'siteUrl' => $siteUrl,
                'feedUrl' => $feedUrl,
                'items' => $items,
                'lastBuildDate' => $lastBuildDate,
            ])
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8')
            ->header('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->header('Cache-Control', 'private, no-cache, no-store, must-revalidate');
    }

    /**
     * @return Collection<int, array{guid: string, title: string, pubDate: string, description: string}>
     */
    private function collectItems(string $tz): Collection
    {
        $rows = collect();

        foreach (Booking::query()->latest('created_at')->limit(100)->cursor() as $booking) {
            $start = $booking->starts_at->copy()->timezone($tz);
            $end = $booking->ends_at->copy()->timezone($tz);
            $when = $start->format('l, M j, Y g:i A').' – '.$end->format('g:i A T');

            $body = "Status: {$booking->status}\nEmail: {$booking->email}\nWhen: {$when}\n";
            if (filled($booking->message)) {
                $body .= "\nNotes:\n".$booking->message;
            }

            $rows->push([
                'sort' => $booking->created_at->timestamp,
                'guid' => 'booking-'.$booking->getKey(),
                'title' => 'Booking · '.$booking->name.' ('.$booking->status.')',
                'pubDate' => $booking->created_at->clone()->utc()->format('r'),
                'description' => $body,
            ]);
        }

        foreach (ContactMessage::query()->latest('created_at')->limit(100)->cursor() as $msg) {
            $body = "Email: {$msg->email}\n\n".$msg->message;

            $rows->push([
                'sort' => $msg->created_at->timestamp,
                'guid' => 'contact-'.$msg->getKey(),
                'title' => 'Contact · '.$msg->name,
                'pubDate' => $msg->created_at->clone()->utc()->format('r'),
                'description' => $body,
            ]);
        }

        return $rows
            ->sortByDesc('sort')
            ->take(100)
            ->map(fn (array $row): array => [
                'guid' => $row['guid'],
                'title' => $row['title'],
                'pubDate' => $row['pubDate'],
                'description' => $row['description'],
            ])
            ->values();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class PrivateInboxFeedController extends Controller
{
    public function __invoke(Request $request, string $token): Response
    {
        $expected = config('site.inbox_feed_token');
        $expected = is_string($expected) ? trim($expected) : '';
        $token = trim($token);

        if ($expected === '' || ! hash_equals($expected, $token)) {
            abort(404);
        }

        /*
         * NetNewsWire compares the subscription URL to <atom:link rel="self">.
         *
         * Prefer APP_URL when it looks like a public site (not localhost) so production
         * matches https://tjshafer.com even behind a reverse proxy that presents http://
         * internally. Fall back to the request host for local Valet / artisan serve.
         */
        $siteUrl = $this->publicBaseUrl($request);
        $feedUrl = $siteUrl.'/feed/inbox/'.$token;

        $items = $this->collectItems();
        $lastBuildDate = $items->isNotEmpty()
            ? $items->first()['pubDate']
            : now('UTC')->format(DateTimeInterface::RSS);

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

    private function publicBaseUrl(Request $request): string
    {
        $fromConfig = rtrim((string) config('site.app_url'), '/');

        if ($fromConfig !== '') {
            $host = parse_url($fromConfig, PHP_URL_HOST);
            if (is_string($host) && ! in_array($host, ['localhost', '127.0.0.1', '[::1]'], true)) {
                return $fromConfig;
            }
        }

        return rtrim($request->getSchemeAndHttpHost(), '/');
    }

    /**
     * @return Collection<int, array{guid: string, title: string, pubDate: string, description: string}>
     */
    private function collectItems(): Collection
    {
        $rows = collect();

        foreach (ContactMessage::query()->latest('created_at')->limit(100)->cursor() as $msg) {
            $body = "Email: {$msg->email}\n\n".$msg->message;

            $rows->push([
                'sort' => $msg->created_at->timestamp,
                'guid' => 'contact-'.$msg->getKey(),
                'title' => 'Contact · '.$msg->name,
                'pubDate' => $msg->created_at->clone()->utc()->format(DateTimeInterface::RSS),
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

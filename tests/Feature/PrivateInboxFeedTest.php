<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\ContactMessage;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PrivateInboxFeedTest extends TestCase
{
    use RefreshDatabase;

    private function token(): string
    {
        return str_repeat('a', 32);
    }

    public function test_inbox_feed_returns_not_found_for_wrong_token(): void
    {
        config(['site.inbox_feed_token' => $this->token()]);

        $this->get('/feed/inbox/'.str_repeat('b', 32))->assertNotFound();
    }

    public function test_inbox_feed_returns_not_found_when_token_unconfigured(): void
    {
        config(['site.inbox_feed_token' => null]);

        $this->get('/feed/inbox/'.$this->token())->assertNotFound();
    }

    public function test_inbox_feed_returns_rss_with_contact_and_booking(): void
    {
        config(['site.inbox_feed_token' => $this->token()]);

        ContactMessage::query()->create([
            'name' => 'Alex',
            'email' => 'alex@example.com',
            'message' => 'Hello',
        ]);

        Booking::query()->create([
            'name' => 'Pat',
            'email' => 'pat@example.com',
            'message' => null,
            'starts_at' => Carbon::parse('2025-06-01 15:00:00', 'UTC'),
            'ends_at' => Carbon::parse('2025-06-01 15:30:00', 'UTC'),
            'timezone' => 'UTC',
            'status' => 'pending',
        ]);

        $response = $this->get('/feed/inbox/'.$this->token());

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $response->assertSee('<rss version="2.0"', false);
        $response->assertSee('Contact · Alex', false);
        $response->assertSee('Booking · Pat', false);
    }
}

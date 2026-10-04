<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
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

    public function test_inbox_feed_returns_rss_with_contact(): void
    {
        config(['site.inbox_feed_token' => $this->token()]);

        ContactMessage::query()->create([
            'name' => 'Alex',
            'email' => 'alex@example.com',
            'message' => 'Hello',
        ]);

        $response = $this->get('/feed/inbox/'.$this->token());

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
        $response->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive');
        $response->assertSee('<rss version="2.0"', false);
        $response->assertSee('Contact · Alex', false);
        $response->assertSee('inbox=contact-', false);
    }

    public function test_inbox_feed_uses_app_url_for_atom_self_when_host_is_public(): void
    {
        $token = $this->token();
        config(['site.inbox_feed_token' => $token]);
        config(['site.app_url' => 'https://tjshafer.com']);

        $response = $this->get('/feed/inbox/'.$token);

        $response->assertOk();
        $response->assertSee(
            'href="https://tjshafer.com/feed/inbox/'.$token.'"',
            false
        );
        $response->assertSee('<link>https://tjshafer.com/</link>', false);
    }
}

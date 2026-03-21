<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_application_returns_a_successful_response(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_music_page_returns_a_successful_response(): void
    {
        $this->get('/music')->assertOk();
    }

    public function test_core_site_pages_return_ok(): void
    {
        foreach ([
            '/projects',
            '/writing',
            '/now',
            '/uses',
            '/colophon',
            '/booking',
            '/resume',
            '/contact',
            '/feed.xml',
        ] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_writing_post_page_returns_ok(): void
    {
        $this->get('/writing/site-launch-notes')->assertOk();
    }

    public function test_contact_form_accepts_valid_submission(): void
    {
        $response = $this->post('/contact', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Hello from the test suite.',
        ]);

        $response->assertRedirect(route('contact'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'test@example.com',
        ]);
    }
}

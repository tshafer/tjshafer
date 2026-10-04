<?php

namespace Tests\Feature;

use Tests\TestCase;

class ThemeTest extends TestCase
{
    public function test_terminal_is_default(): void
    {
        $this->get('/')->assertOk()->assertSee('data-theme="terminal"', false)->assertSee('whoami');
    }

    public function test_switching_to_desert_sets_cookie_and_renders_desert(): void
    {
        $this->get('/theme/desert')->assertRedirect()->assertCookie('theme', 'desert');

        $this->withCookie('theme', 'desert')->get('/')
            ->assertSee('data-theme="desert"', false)
            ->assertSee('az-clock', false);
    }

    public function test_unknown_theme_is_rejected(): void
    {
        $this->get('/theme/neon')->assertNotFound();
    }
}

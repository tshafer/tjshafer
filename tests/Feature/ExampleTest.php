<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_site_pages_return_ok(): void
    {
        foreach (['/', '/projects'] as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_removed_pages_are_gone(): void
    {
        foreach (['/music', '/contact', '/now', '/uses', '/colophon', '/resume', '/theme/desert', '/writing', '/writing/site-launch-notes', '/feed.xml'] as $path) {
            $this->get($path)->assertNotFound();
        }
    }
}

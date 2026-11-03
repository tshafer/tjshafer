<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class SiteContent
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function projects(): array
    {
        $path = base_path('content/projects.json');
        if (! File::exists($path)) {
            return [];
        }

        return json_decode(File::get($path), true) ?? [];
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteContent
{
    private function contentPath(string $path): string
    {
        return base_path('content/'.$path);
    }

    public function posts(): Collection
    {
        $dir = $this->contentPath('posts');
        if (! File::isDirectory($dir)) {
            return collect();
        }

        return collect(File::files($dir))
            ->filter(fn (\SplFileInfo $f) => $f->getExtension() === 'md')
            ->map(fn (\SplFileInfo $f) => $this->parsePost($f->getPathname()))
            ->filter()
            ->sortByDesc(fn (array $p) => $p['date'] ?? '')
            ->values();
    }

    public function post(string $slug): ?array
    {
        return $this->posts()->firstWhere('slug', $slug);
    }

    /**
     * @return array{title: string, date: string, slug: string, excerpt: string|null, body: string, html: string}|null
     */
    private function parsePost(string $path): ?array
    {
        $raw = File::get($path);
        if (! preg_match('/^---\s*\r?\n(.*?)\r?\n---\s*\r?\n(.*)/s', $raw, $m)) {
            return null;
        }

        $meta = $this->parseYamlLike($m[1]);
        $body = trim($m[2]);
        $slug = $meta['slug'] ?? null;
        if (! $slug) {
            return null;
        }

        return [
            'title' => $meta['title'] ?? 'Untitled',
            'date' => $meta['date'] ?? '1970-01-01',
            'slug' => $slug,
            'excerpt' => $meta['excerpt'] ?? null,
            'body' => $body,
            'html' => Str::markdown($body),
        ];
    }

    /**
     * Minimal key: value parser for simple front matter.
     *
     * @return array<string, string>
     */
    private function parseYamlLike(string $block): array
    {
        $out = [];
        foreach (preg_split('/\r?\n/', $block) as $line) {
            if (preg_match('/^([a-z0-9_]+):\s*(.*)$/i', trim($line), $mm)) {
                $out[$mm[1]] = trim($mm[2], " \"'");
            }
        }

        return $out;
    }

    public function nowPage(): array
    {
        $path = $this->contentPath('now.md');
        if (! File::exists($path)) {
            return [
                'title' => 'Now',
                'updated' => null,
                'html' => '<p class="text-muted">Nothing here yet — edit <code class="text-copper">content/now.md</code>.</p>',
            ];
        }

        $raw = File::get($path);
        $updated = null;
        if (preg_match('/^---\s*\r?\n(.*?)\r?\n---\s*\r?\n(.*)/s', $raw, $m)) {
            $meta = $this->parseYamlLike($m[1]);
            $updated = $meta['updated'] ?? null;
            $body = trim($m[2]);
        } else {
            $body = trim($raw);
        }

        return [
            'title' => 'Now',
            'updated' => $updated,
            'html' => Str::markdown($body),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function projects(): array
    {
        $path = $this->contentPath('projects.json');
        if (! File::exists($path)) {
            return [];
        }

        return json_decode(File::get($path), true) ?? [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function speaking(): array
    {
        $path = $this->contentPath('speaking.json');
        if (! File::exists($path)) {
            return [];
        }

        return json_decode(File::get($path), true) ?? [];
    }

    /**
     * @return array{
     *     testimonials: array<int, array<string, string>>,
     *     trusted_by: array<int, string>,
     *     sites_built: array<int, array{name: string, url: string}>,
     *     maintains: array<int, array{name: string, url: string}>,
     *     employer: array{name: string, url: string}|null
     * }
     */
    public function social(): array
    {
        $path = $this->contentPath('social.json');
        if (! File::exists($path)) {
            return [
                'testimonials' => [],
                'trusted_by' => [],
                'sites_built' => [],
                'maintains' => [],
                'employer' => null,
            ];
        }

        $data = json_decode(File::get($path), true) ?? [];
        $employer = $data['employer'] ?? null;
        if (! is_array($employer) || empty($employer['name']) || empty($employer['url'])) {
            $employer = null;
        }

        return [
            'testimonials' => $data['testimonials'] ?? [],
            'trusted_by' => $data['trusted_by'] ?? [],
            'sites_built' => $data['sites_built'] ?? [],
            'maintains' => $data['maintains'] ?? [],
            'employer' => $employer,
        ];
    }
}

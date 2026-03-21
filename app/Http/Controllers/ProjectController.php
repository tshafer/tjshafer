<?php

namespace App\Http\Controllers;

use App\Services\SiteContent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request, SiteContent $content): View
    {
        $tag = $request->query('tag');
        $projects = collect($content->projects());

        if (is_string($tag) && $tag !== '') {
            $projects = $projects->filter(function (array $p) use ($tag) {
                $stack = $p['stack'] ?? [];

                return in_array($tag, $stack, true);
            });
        }

        $allTags = collect($content->projects())
            ->pluck('stack')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('pages.projects.index', [
            'projects' => $projects->values(),
            'allTags' => $allTags,
            'activeTag' => $tag,
        ]);
    }
}

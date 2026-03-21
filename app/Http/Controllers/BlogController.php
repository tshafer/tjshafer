<?php

namespace App\Http\Controllers;

use App\Services\SiteContent;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(SiteContent $content): View
    {
        return view('pages.writing.index', [
            'posts' => $content->posts(),
        ]);
    }

    public function show(string $slug, SiteContent $content): View
    {
        $post = $content->post($slug);
        abort_unless($post, 404);

        return view('pages.writing.show', [
            'post' => $post,
        ]);
    }
}

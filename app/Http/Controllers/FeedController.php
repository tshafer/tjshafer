<?php

namespace App\Http\Controllers;

use App\Services\SiteContent;
use Illuminate\Http\Response;

class FeedController extends Controller
{
    public function __invoke(SiteContent $content): Response
    {
        $posts = $content->posts();

        return response()
            ->view('feed', [
                'posts' => $posts,
                'siteUrl' => rtrim((string) config('site.app_url'), '/'),
            ])
            ->header('Content-Type', 'application/rss+xml; charset=UTF-8');
    }
}

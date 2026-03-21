<?php

namespace App\Http\Controllers;

use App\Services\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function __invoke(Request $request, SiteContent $content)
    {
        $username = config('site.github_username');
        $github = null;
        if (is_string($username) && $username !== '') {
            $token = config('site.github_token');
            $github = Cache::remember('site.github.'.$username.($token ? '.auth' : ''), 3600, function () use ($username, $token) {
                try {
                    $headers = [
                        'Accept' => 'application/vnd.github+json',
                        'User-Agent' => config('app.name', 'Laravel').' (personal site)',
                    ];
                    if (is_string($token) && $token !== '') {
                        $headers['Authorization'] = 'Bearer '.$token;
                    }

                    $response = Http::timeout(4)
                        ->withHeaders($headers)
                        ->get('https://api.github.com/users/'.$username);

                    return $response->successful() ? $response->json() : null;
                } catch (\Throwable) {
                    return null;
                }
            });
        }

        return view('home', [
            'social' => $content->social(),
            'github' => $github,
        ]);
    }
}

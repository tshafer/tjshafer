<?php

namespace App\Http\Controllers;

use App\Services\SiteContent;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SitePageController extends Controller
{
    public function uses(): View
    {
        return view('pages.uses');
    }

    public function speaking(SiteContent $content): View
    {
        return view('pages.speaking', [
            'items' => $content->speaking(),
        ]);
    }

    public function colophon(): View
    {
        return view('pages.colophon');
    }

    public function resume(): View
    {
        $path = public_path('resume.json');
        $resume = (File::exists($path) && is_readable($path))
            ? json_decode(File::get($path), true)
            : null;

        return view('pages.resume', ['resume' => is_array($resume) ? $resume : null]);
    }

    public function now(SiteContent $content): View
    {
        return view('pages.now', $content->nowPage());
    }
}

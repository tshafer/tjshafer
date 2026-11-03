<?php

use App\Services\SiteContent;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/projects', fn (SiteContent $content) => view('pages.projects.index', [
    'projects' => $content->projects(),
]))->name('projects.index');

<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\FeedController;
use App\Services\SiteContent;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::get('/projects', fn (SiteContent $content) => view('pages.projects.index', [
    'projects' => $content->projects(),
]))->name('projects.index');

Route::get('/writing', [BlogController::class, 'index'])->name('writing.index');
Route::get('/writing/{slug}', [BlogController::class, 'show'])->name('writing.show');

Route::get('/feed.xml', FeedController::class)->name('feed');

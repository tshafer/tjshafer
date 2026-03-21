<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SitePageController;
use App\Http\Controllers\SpotifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/music', function () {
    return view('music');
})->name('music');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/writing', [BlogController::class, 'index'])->name('writing.index');
Route::get('/writing/{slug}', [BlogController::class, 'show'])->name('writing.show');

Route::get('/now', [SitePageController::class, 'now'])->name('now');
Route::get('/uses', [SitePageController::class, 'uses'])->name('uses');
// Route::get('/speaking', [SitePageController::class, 'speaking'])->name('speaking');
Route::get('/colophon', [SitePageController::class, 'colophon'])->name('colophon');
Route::get('/booking', [SitePageController::class, 'booking'])->name('booking');
Route::get('/resume', [SitePageController::class, 'resume'])->name('resume');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:8,1')
    ->name('contact.store');

Route::get('/feed.xml', FeedController::class)->name('feed');

Route::get('/spotify/auth', [SpotifyController::class, 'authorize'])->name('spotify.authorize');
Route::get('/spotify/callback', [SpotifyController::class, 'callback'])->name('spotify.callback');
Route::get('/api/spotify/now-playing', [SpotifyController::class, 'nowPlaying']);
Route::get('/api/spotify/top-artists', [SpotifyController::class, 'topArtists']);
Route::get('/api/spotify/top-tracks', [SpotifyController::class, 'topTracks']);
Route::get('/api/spotify/recently-played', [SpotifyController::class, 'recentlyPlayed']);
Route::get('/api/spotify/playlists', [SpotifyController::class, 'playlists']);
Route::get('/api/spotify/profile', [SpotifyController::class, 'profile']);
Route::get('/api/spotify/genres', [SpotifyController::class, 'genres']);
Route::get('/api/spotify/top-albums', [SpotifyController::class, 'topAlbums']);
Route::get('/api/spotify/stats', [SpotifyController::class, 'stats']);

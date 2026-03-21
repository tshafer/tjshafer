<?php

use App\Http\Controllers\AdminBookingAuthController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
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
// Speaking (disabled): restore route + nav/footer links when ready.
// Route::get('/speaking', [SitePageController::class, 'speaking'])->name('speaking');
Route::get('/colophon', [SitePageController::class, 'colophon'])->name('colophon');
Route::get('/booking', [BookingController::class, 'create'])->name('booking');
Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('booking.store');

Route::middleware('guest')->prefix('admin/booking')->group(function () {
    Route::get('login', [AdminBookingAuthController::class, 'showLogin'])->name('admin.bookings.login');
    Route::post('login', [AdminBookingAuthController::class, 'login'])
        ->middleware('throttle:10,1')
        ->name('admin.bookings.login.store');
});

Route::middleware(['auth', 'can:manage-bookings'])->prefix('admin/booking')->group(function () {
    Route::get('/', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
    Route::post('logout', [AdminBookingAuthController::class, 'logout'])->name('admin.bookings.logout');
    Route::post('{booking}/confirm', [AdminBookingController::class, 'confirm'])
        ->whereNumber('booking')
        ->name('admin.bookings.confirm');
    Route::post('{booking}/cancel', [AdminBookingController::class, 'cancel'])
        ->whereNumber('booking')
        ->name('admin.bookings.cancel');
});

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

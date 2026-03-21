<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminBookingAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (! User::query()->where('is_admin', true)->exists()) {
            abort(404);
        }

        if (Auth::check() && Auth::user()?->canManageBookings()) {
            return redirect()->route('admin.bookings.index');
        }

        return view('admin.bookings.login');
    }

    public function login(Request $request): RedirectResponse
    {
        if (! User::query()->where('is_admin', true)->exists()) {
            abort(404);
        }

        $credentials = $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:500'],
            'remember' => ['sometimes', 'boolean'],
        ]);

        if (! Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        if (! Auth::user()?->canManageBookings()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'You do not have access to booking admin.'])
                ->onlyInput('email');
        }

        return redirect()->intended(route('admin.bookings.index'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.bookings.login');
    }
}

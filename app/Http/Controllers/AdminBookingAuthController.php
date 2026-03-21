<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBookingAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        $password = config('booking.admin_password');
        if (! is_string($password) || $password === '') {
            abort(404);
        }

        if (request()->session()->get('booking_admin') === true) {
            return redirect()->route('admin.bookings.index');
        }

        return view('admin.bookings.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $password = config('booking.admin_password');
        if (! is_string($password) || $password === '') {
            abort(404);
        }

        $validated = $request->validate([
            'password' => ['required', 'string', 'max:500'],
        ]);

        if (! hash_equals($password, $validated['password'])) {
            return back()->withErrors(['password' => 'That password is incorrect.']);
        }

        $request->session()->regenerate();
        $request->session()->put('booking_admin', true);

        return redirect()->intended(route('admin.bookings.index'));
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('booking_admin');
        $request->session()->regenerate();

        return redirect()->route('admin.bookings.login');
    }
}

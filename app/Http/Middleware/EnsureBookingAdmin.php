<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBookingAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $password = config('booking.admin_password');

        if (! is_string($password) || $password === '') {
            abort(404);
        }

        if ($request->session()->get('booking_admin') !== true) {
            return redirect()
                ->guest(route('admin.bookings.login'));
        }

        return $next($request);
    }
}

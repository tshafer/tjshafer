@extends('layouts.site')

@section('title', 'Booking admin · Tom Shafer')

@section('meta_description', 'Sign in to manage booking requests.')

@section('content')
    <div class="max-w-md mx-auto px-5 sm:px-8 py-16 lg:py-20">
        <h1 class="font-display text-3xl text-warm tracking-tight mb-2">Booking admin</h1>
        <p class="font-mono text-xs uppercase tracking-[0.25em] text-copper mb-8">Sign in</p>

        @error('email')
            <div class="mb-6 rounded-sm border border-red-500/40 bg-red-500/10 px-4 py-3 text-sm text-red-200">
                {{ $message }}
            </div>
        @enderror

        <form method="post" action="{{ route('admin.bookings.login.store') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Email</label>
                <input id="email" name="email" type="email" required value="{{ old('email') }}" autocomplete="username"
                       class="w-full rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none">
            </div>
            <div>
                <label for="password" class="block text-xs font-mono uppercase tracking-wider text-muted mb-2">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="w-full rounded-sm border border-white/10 bg-ink px-4 py-3 text-warm text-sm focus:border-copper focus:outline-none">
            </div>
            <div class="flex items-center gap-2">
                <input id="remember" name="remember" type="checkbox" value="1" class="rounded border-white/20 bg-ink text-copper focus:ring-copper">
                <label for="remember" class="text-sm text-muted">Remember this device</label>
            </div>
            <button type="submit" class="rounded-sm bg-copper px-6 py-3 text-sm font-semibold text-ink hover:bg-copper-hover transition-colors">
                Sign in
            </button>
        </form>
    </div>
@endsection

<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('manage-bookings', function (User $user): bool {
            return $user->canManageBookings();
        });

        View::composer('*', function ($view): void {
            $view->with('theme', request()->cookie('theme') === 'desert' ? 'desert' : 'terminal');
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // Limits default indexed string columns to 191 characters to fit under MySQL's 1000-byte cap
        Schema::defaultStringLength(191);

        // Share notifications with all admin views
        // Directly query the Notification model to avoid trait/method conflicts
        // on the User model (Notifiable trait's morphMany vs custom hasMany).
        View::composer('layouts.simple.header', function ($view) {
            $user = Auth::user();
            if ($user) {
                $view->with([
                    'adminNotifications' => \App\Models\Notification::where('user_id', $user->id)
                        ->orderByDesc('created_at')
                        ->take(10)
                        ->get(),
                    'adminUnreadCount' => \App\Models\Notification::where('user_id', $user->id)
                        ->whereNull('read_at')
                        ->count(),
                ]);
            } else {
                $view->with([
                    'adminNotifications' => collect(),
                    'adminUnreadCount' => 0,
                ]);
            }
        });
    }
}
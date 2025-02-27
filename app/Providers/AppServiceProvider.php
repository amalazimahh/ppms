<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;

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
        // share unread notifications with the navbar partial
        view()->composer('layouts.navbars.navbar', function ($view){
            $notifications = Notification::where('read', false)->get();
            $view->with('notifications', $notifications);
        });
    }
}

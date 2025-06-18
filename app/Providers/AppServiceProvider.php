<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $user = Auth::user();
            $notifications = collect();
            if ($user) {
                $notifications = DB::table('notifications')
                    ->join('notification_recipients', 'notifications.id', '=', 'notification_recipients.notification_id')
                    ->where('notification_recipients.user_id', $user->id)
                    ->where('notifications.read', false)
                    ->orderBy('notifications.created_at', 'desc')
                    ->select('notifications.*')
                    ->take(8)
                    ->get();
            }
            $view->with('notifications', $notifications);
        });
    }
}

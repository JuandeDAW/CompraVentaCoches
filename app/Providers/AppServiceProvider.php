<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Message;
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
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $unreadMessagesCount = Message::where('receiver_id', Auth::id())
                                              ->where('read_at', null)
                                              ->count();
                $view->with('unreadMessagesCount', $unreadMessagesCount);
            }
        });
    }
}

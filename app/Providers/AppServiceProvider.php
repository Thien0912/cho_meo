<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\UserCoin;
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
    public function boot()
    {
        // Nếu user đã đăng nhập
        View::composer('*', function ($view) {
            $totalCoins = 0;

            if (Auth::check()) {
                $user = Auth::user();
                $totalCoins = UserCoin::where('user_id', $user->id)->sum('coins_change');
            }

            // Chia sẻ biến totalCoins cho tất cả các view
            $view->with('totalCoins', $totalCoins);
        });
    }
}

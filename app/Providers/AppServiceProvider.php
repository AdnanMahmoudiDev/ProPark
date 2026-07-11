<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

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
    // این کد باعث می‌شود متغیر $pendingCartCount در همه ویوهای داخل layouts در دسترس باشد
    View::composer('layouts.navigation', function ($view) {
        $count = 0;
        if (Auth::check()) {
            // چک می‌کنیم آیا کاربر سبد خرید فعال دارد یا خیر
            $count = Cart::where('user_id', Auth::id())
                ->where('status', Cart::STATUS_PENDING)
                ->exists() ? 1 : 0;
        }
        $view->with('pendingCartCount', $count);
    });
}
}

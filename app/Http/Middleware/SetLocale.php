<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // خواندن زبان ذخیره‌شده از سشن، در غیر این صورت زبان پیش‌فرض کانفیگ
        if (Session::has('locale')) {
            $locale = Session::get('locale');
            if (in_array($locale, ['fa', 'en'], true)) {
                App::setLocale($locale);
            }
        }

        return $next($request);
    }
}

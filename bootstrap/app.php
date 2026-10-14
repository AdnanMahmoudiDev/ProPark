<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\TrackPageVisits;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        $middleware->alias([
            'admin' => AdminMiddleware::class,
        ]);

        // استثنا کردن روت کال‌بک درگاه پرداخت از بررسی توکن CSRF (پشتیبانی از بازگشت POST شاپرک/سپ)
        $middleware->validateCsrfTokens(except: [
            'payment/callback/*',
        ]);

        // افزودن میدل‌ویر تغییر زبان به پایپ‌لاین وب
        $middleware->web(append: [
            SetLocale::class,
            TrackPageVisits::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

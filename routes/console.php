<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| زمان‌بندی تسک‌ها (Task Scheduling)
|--------------------------------------------------------------------------
| بررسی و منقضی کردن خودکار سفارش‌های رهاشده در انتظار پرداخت هر 10 دقیقه یک‌بار
| همراه با withoutOverlapping جهت جلوگیری از تداخل اجراها
*/
Schedule::command('orders:expire-pending')->everyTenMinutes()->withoutOverlapping();

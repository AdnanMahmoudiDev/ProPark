<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * تغییر زبان سیستم و ذخیره در سشن
     *
     * @param string $locale
     * @return RedirectResponse
     */
    public function switch(string $locale): RedirectResponse
    {
        // بررسی و اعتبارسنجی زبان‌های مجاز در سیستم
        $availableLocales = ['fa', 'en'];

        if (in_array($locale, $availableLocales, true)) {
            // تنظیم زبان در سشن کاربر
            Session::put('locale', $locale);
            
            // تنظیم موقت زبان برای درخواست جاری
            App::setLocale($locale);
        }

        // بازگشت به صفحه‌ای که کاربر در آن حضور داشته
        return redirect()->back();
    }
}

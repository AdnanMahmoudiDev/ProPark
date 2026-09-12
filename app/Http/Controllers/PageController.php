<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * نمایش صفحه درباره ما
     */
    public function about(): View
    {
        return view('pages.about');
    }
    /**
     * حریم خصوصی
     */
    public function privacy(): View
    {
        return view('pages.privacy');
    }
    /**
     * نمایش قوانین سایت
     */
    public function terms(): View
    {
        return view('pages.terms');
    }
    /**
     * نمایش صفحه پشتیبانی
     */
    public function support(): View
    {
        return view('pages.support');
    }
}

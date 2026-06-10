<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ProPark | سامانه هوشمند مدیریت پارکینگ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-950 text-gray-100">

    {{-- نوبار   --}}
    <nav class="bg-gray-950/80 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-1 flex items-center justify-between h-16">
            <div class="flex items-center gap-3">
                <x-application-logo class="block h-16 w-16 fill-current text-violet-500" />
                <span class="text-xl font-bold tracking-tight text-violet-400">ProPark</span>
            </div>
            <div class="flex gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-violet-400 font-medium transition">داشبورد</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-violet-400 font-medium transition">ورود</a>
                    <a href="{{ route('register') }}" class="bg-violet-600 text-white px-5 py-2 rounded-xl hover:bg-violet-500 transition shadow-md shadow-violet-900/50">ثبت‌نام</a>
                @endauth
            </div>
        </div>
    </nav>

    
    <main class="relative bg-gradient-to-br from-violet-950 via-gray-950 to-gray-950 py-24">
        <div class="max-w-7xl mx-auto px-6 text-center">

            <span class="inline-block py-1 px-3 rounded-full bg-violet-900/50 text-violet-300 text-sm font-semibold mb-6 border border-violet-800">نسخه 1.0.0 منتشر شد</span>
            <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-8 leading-tight">
                سامانه هوشمند مدیریت پارکینگ <br>
                <span class="text-violet-400">ProPark</span>
            </h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-12">
                راهکار جامع برای کنترل تردد، مدیریت اشتراک‌ها و صدور لایسنس‌های هوشمند. ساده، امن و سریع.
            </p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-violet-600 text-white px-8 py-4 rounded-2xl text-lg font-semibold hover:bg-violet-500 transition shadow-lg shadow-violet-900/50">شروع کار</a>
                <a href="{{ route('shop') }}" class="bg-gray-900 text-gray-300 px-8 py-4 rounded-2xl text-lg font-semibold border border-gray-800 hover:bg-gray-800 transition">فروشگاه</a>
            </div>
        </div>
    </main>

        {{-- قسمت فونر --}}
    <section class="max-w-7xl mx-auto px-6 py-20 grid md:grid-cols-3 gap-8">
        @php
            $features = [
                ['title' => 'مدیریت لایسنس', 'desc' => 'کنترل کامل بر اشتراک‌ها و لایسنس‌های نرم‌افزاری کاربران به صورت آنلاین.'],
                ['title' => 'داشبورد هوشمند', 'desc' => 'مشاهده آمار لحظه‌ای تردد و وضعیت پارکینگ‌ها از طریق پنل کاربری اختصاصی.'],
                ['title' => 'اتصال سریع API', 'desc' => 'اتصال بدون دردسر برنامه پایتون/ویندوز شما به هسته مرکزی سیستم.'],
            ];
        @endphp
        
        @foreach($features as $feature)
        <div class="bg-gray-900 p-8 rounded-3xl shadow-sm border border-gray-800 hover:border-violet-900/50 transition duration-300">
            <h3 class="text-xl font-bold mb-4 text-white">{{ $feature['title'] }}</h3>
            <p class="text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
        </div>
        @endforeach
    </section>


    <footer class="py-10 text-center text-gray-600 text-sm border-t border-gray-900">
        {{-- دربازه ما --}}
        
    <section class="max-w-7xl mx-auto px-6 py-20 border-t border-gray-800">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            {{-- متن دربارع ما --}}
            <div>
                <h2 class="text-3xl font-bold text-white mb-6">درباره ProPark</h2>
                <p class="text-gray-400 leading-relaxed mb-6">
                    پروپارک (ProPark) با هدف ارائه راهکارهای مدرن برای مدیریت هوشمند لایسنس و کنترل تردد توسعه یافته است. تمرکز اصلی ما بر ایجاد پلی میان نرم‌افزارهای دسکتاپ (مبتنی بر پایتون) و پنل‌های مدیریتی قدرتمند است تا مدیران بتوانند با امنیت بالا و در محیطی بهینه، بر سیستم‌های خود نظارت داشته باشند.
                </p>
                <div class="flex gap-4">
                    <div class="border-l-4 border-violet-500 pl-4">
                        <h4 class="text-white font-bold">هدف ما</h4>
                        <p class="text-gray-500 text-sm">ساده‌سازی مدیریت پیچیده سیستم‌ها</p>
                    </div>
                    <div class="border-l-4 border-violet-500 pl-4">
                        <h4 class="text-white font-bold">تکنولوژی</h4>
                        <p class="text-gray-500 text-sm">امنیت بالا و یکپارچگی سریع</p>
                    </div>
                </div>
            </div>
            {{-- قسمت کارت چرا پرو پارک --}}
            <div class="bg-gray-900 border border-gray-800 p-8 rounded-3xl relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-violet-600 rounded-full blur-3xl opacity-20"></div>
                <h3 class="text-xl font-bold text-white mb-6">چرا ProPark را انتخاب کنید؟</h3>
                <ul class="space-y-4">
                    <li class="flex items-center text-gray-300">
                        <span class="text-violet-500 ml-3">.</span> پایداری و امنیت در هسته سیستم
                    </li>
                    <li class="flex items-center text-gray-300">
                        <span class="text-violet-500 ml-3">.</span> گزارش‌گیری دقیق و لحظه‌ای
                    </li>
                    <li class="flex items-center text-gray-300">
                        <span class="text-violet-500 ml-3">.</span> توسعه یافته با استانداردهای مدرن
                    </li>
                </ul>
            </div>
        </div>
    </section>

        تمام حقوق برای ProPark محفوظ است &copy; {{ date('Y') }}
    </footer>

</body>
</html>

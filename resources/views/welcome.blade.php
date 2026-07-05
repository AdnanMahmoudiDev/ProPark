<x-app-layout>
    
    <main class="relative py-24">

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

        <section class="max-w-7xl mx-auto px-6 py-20 border-t border-gray-800">
            <div class="grid md:grid-cols-2 gap-12 items-center">

                <div>
                    <h2 class="text-3xl font-bold text-white mb-6">درباره ProPark</h2>
                    <p class="text-gray-400 leading-relaxed mb-6">
                        پروپارک (ProPark) با هدف ارائه راهکارهای مدرن برای مدیریت هوشمند لایسنس و کنترل تردد توسعه یافته است...
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

</x-app-layout>

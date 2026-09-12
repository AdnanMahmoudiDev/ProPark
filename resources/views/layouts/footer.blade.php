<footer class="mt-auto border-t border-white/10 bg-gradient-to-b from-black/20 via-black/40 to-black/60 backdrop-blur-md text-gray-400">
    <div class="max-w-7xl mx-auto px-5 sm:px-6 pt-12 pb-8">
        {{-- بخش اصلی فوتر (Grid چهار ستونه در دسکتاپ) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10 text-right">
            
            {{-- ستون ۱: برند و معرفی پلتفرم --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500 animate-pulse"></div>
                    <span class="text-white text-lg font-bold tracking-tight">AvaPark</span>
                </div>
                <p class="text-xs leading-relaxed text-gray-400 text-justify">
                    سامانه هوشمند مدیریت لایسنس، رهگیری فعال دستگاه‌ها و کنترل تردد خودکار. بهینه‌سازی شده برای کنترل پارکینگ‌ها و مدیریت آسان دسترسی‌ها.
                </p>
                <div class="flex items-center gap-2 pt-1 text-xs text-emerald-400 font-mono">
                    
                </div>
            </div>

            {{-- ستون ۲: دسترسی سریع و صفحات --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 border-b border-white/5 pb-2">دسترسی سریع</h4>
                <ul class="space-y-2.5 text-xs">
                    <li>
                        <a href="{{ Route::has('home') ? route('home') : '/' }}" class="hover:text-blue-400 transition-colors duration-200">صفحه اصلی</a>
                    </li>
                    @guest
                        <li>
                            <a href="{{ Route::has('login') ? route('login') : '/login' }}" class="hover:text-blue-400 transition-colors duration-200">ورود به پنل</a>
                        </li>
                        <li>
                            <a href="{{ Route::has('register') ? route('register') : '/register' }}" class="hover:text-blue-400 transition-colors duration-200">ثبت‌نام حساب جدید</a>
                        </li>
                    @else
                        <li>
                            <a href="{{ Route::has('dashboard') ? route('dashboard') : '/dashboard' }}" class="hover:text-blue-400 transition-colors duration-200">داشبورد کاربری</a>
                        </li>
                    @endguest
                    <li>
                        <a href="/shop" class="hover:text-blue-400 transition-colors duration-200">تعرفه‌ها و پلن‌ها</a>
                    </li>
                </ul>
            </div>

            {{-- ستون ۳: قوانین و ارتباط با پشتیبانی --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4 border-b border-white/5 pb-2">پشتیبانی و قوانین</h4>
                <ul class="space-y-2.5 text-xs">
                    <li>
                        <a href="/terms" class="hover:text-blue-400 transition-colors duration-200">شرایط و قوانین استفاده</a>
                    </li>
                    <li>
                        <a href="/privacy" class="hover:text-blue-400 transition-colors duration-200">حریم خصوصی کاربران</a>
                    </li>
                    <li class="pt-2">
                        <span class="block text-[11px] text-gray-500 mb-1">ارتباط مستقیم از طریق ایمیل:</span>
                        <a href="mailto:support@avapark.ir" class="flex items-center gap-1.5 text-gray-300 hover:text-blue-400 transition-colors duration-200 font-mono text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            support@avapark.ir
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ستون ۴: نماد اعتماد الکترونیکی (Enamad) --}}
            <div class="flex flex-col items-start md:items-end">
                <h4 class="text-white font-semibold text-sm mb-4 border-b border-white/5 pb-2 w-full text-right md:text-left">نماد اعتماد</h4>
                <div class="bg-white rounded-xl p-2.5 border border-white/10 shadow-lg hover:shadow-blue-500/10 transition-shadow">
                    <a referrerpolicy="origin" target="_blank"
                       href="https://trustseal.enamad.ir/?id=765670&Code=dLfUNy1H0QGcHNPTPZ5GyDCg9s8CWECD">
                        <img
                            referrerpolicy="origin"
                            src="https://trustseal.enamad.ir/logo.aspx?id=765670&Code=dLfUNy1H0QGcHNPTPZ5GyDCg9s8CWECD"
                            alt="نماد اعتماد الکترونیکی AvaPark"
                            style="cursor:pointer"
                            class="h-14 w-auto object-contain"
                            code="dLfUNy1H0QGcHNPTPZ5GyDCg9s8CWECD"
                        >
                    </a>
                </div>
            </div>

        </div>

        {{-- نوار کپی‌رایت پایین --}}
        <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500">
            <div>
                © {{ date('Y') }} <span class="text-gray-200 font-medium">AvaPark</span>. تمامی حقوق مادی و معنوی محفوظ است.
            </div>
            <div class="flex items-center gap-4 text-xs font-mono">
                <a href="mailto:info@avapark.ir" class="hover:text-gray-300 transition-colors duration-200">info@avapark.ir</a>
                <span class="text-white/20">|</span>
                <span class="text-gray-500">v1.0.0</span>
            </div>
        </div>
    </div>
</footer>

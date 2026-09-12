<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        
        {{-- هدر صفحه با قابلیت انیمیشن دسکتاپ --}}
        <div class="text-center mb-12" data-reveal>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>مستندات قانونی سامانه</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                شرایط و قوانین استفاده از AvaPark
            </h1>
            <p class="mt-3 text-sm sm:text-base text-gray-400 max-w-2xl mx-auto leading-relaxed">
                لطفاً قبل از استفاده از خدمات، پایش دستگاه‌ها و مدیریت پارکینگ، این قوانین را به دقت مطالعه فرمایید.
            </p>
            <div class="mt-4 text-xs text-gray-500">
                آخرین به‌روزرسانی: {{ date('Y/m/d') }}
            </div>
        </div>

        {{-- کانتینر کارت‌های قوانین --}}
        <div class="space-y-6">

            {{-- بخش ۱: تعاریف و کلیات --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">۱. تعاریف و کلیات سامانه</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify">
                    سامانه AvaPark یک پلتفرم یکپارچه مبتنی بر وب برای مدیریت هوشمند پارکینگ، کنترل تردد، پایش وضعیت دیوایس‌ها و تحلیل داده‌های ترافیکی است. استفاده از هر یک از خدمات به منزله پذیرش کامل کلیه شرایط و ضوابط مندرج در این صفحه می‌باشد.
                </p>
            </div>

            {{-- بخش ۲: امنیت و حساب کاربری --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">۲. حساب کاربری و مسئولیت‌های امنیتی</h2>
                </div>
                <ul class="text-sm text-gray-300 space-y-3 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-400 mt-1">•</span>
                        <span>کاربران موظف به حفظ محرمانگی نام کاربری، رمز عبور و نشست‌های فعال خود می‌باشند.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-400 mt-1">•</span>
                        <span>هرگونه فعالیت انجام‌شده تحت حساب کاربری بر عهده صاحب حساب است.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-400 mt-1">•</span>
                        <span>در صورت مشاهده تردد یا لاگین‌های مشکوک، باید فوراً مراتب به پشتیبانی فنی گزارش شود.</span>
                    </li>
                </ul>
            </div>

            {{-- بخش ۳: اتصال دستگاه‌ها و پایش لایسنس --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">۳. مدیریت دیوایس‌ها و محدودیت‌ها</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify mb-3">
                    تعداد دستگاه‌ها و گیت‌های قابل اتصال مطابق با پلن و لایسنس خریداری‌شده تعیین می‌گردد. در صورت تغییر پلن یا نیاز به اعمال محدودیت، حذف دستگاه‌ها بر اساس منطق سامانه به ترتیب آخرین دستگاه‌های متصل‌شده مدیریت خواهد شد.
                </p>
            </div>

            {{-- بخش ۴: حریم خصوصی و امنیت داده‌ها --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">۴. حریم خصوصی و نگهداری اطلاعات تردد</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify">
                    اطلاعات تردد، پلاک‌ها و گزارش‌های سیستم با بالاترین استانداردهای امنیتی رمزنگاری و نگهداری می‌شوند و تحت هیچ شرایطی در اختیار شخص یا نهاد ثالث قرار نخواهند گرفت مگر به حکم مراجع قانونی ذی‌صلاح.
                </p>
            </div>

        </div>

        {{-- فوتر صفحه با دکمه بازگشت --}}
        <div class="mt-10 text-center" data-reveal>
            <a href="{{ url()->previous() ?: route('login') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 text-sm font-medium border border-gray-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>بازگشت به صفحه قبل</span>
            </a>
        </div>

    </div>
</x-app-layout>

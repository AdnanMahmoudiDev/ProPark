<x-app-layout>
    <div class="min-h-screen bg-gray-950 text-gray-100 py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        {{-- جلوه‌های نورپردازی نئونی تلویند --}}
        <div class="absolute top-0 right-1/2 translate-x-1/2 w-[600px] h-[350px] bg-blue-600/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-1/3 left-0 w-80 h-80 bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-10 right-0 w-96 h-96 bg-blue-500/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-6xl mx-auto space-y-20 relative z-10">

            {{-- ۱. Hero Section --}}
            <div class="reveal-on-scroll text-center space-y-5 max-w-3xl mx-auto">
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    داستان تولد <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-blue-500">آواپارک</span>؛ <br>
                    از میدان تا مهندسی هوشمند
                </h1>
                <p class="text-sm sm:text-base text-gray-400 leading-relaxed">
                    ما معتقدیم آینده شهری از تحول در سنتی‌ترین لایه‌ها آغاز می‌شود؛ جایی که علم داده، الگوریتم‌های هوشمند و اشتیاق نسل جوان در کنار هم قرار می‌گیرند.
                </p>
            </div>

            {{-- ۲. داستان ما و مسیر پیدایش --}}
            <div class="reveal-on-scroll relative bg-gradient-to-br from-gray-900/90 via-gray-900/60 to-gray-950/90 border border-gray-800 rounded-3xl p-6 sm:p-10 lg:p-12 shadow-2xl backdrop-blur-xl overflow-hidden">
                <div class="absolute -top-24 -right-24 w-60 h-60 bg-blue-500/10 rounded-full blur-2xl"></div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    <div class="lg:col-span-7 space-y-5 text-justify">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h2 class="text-xl sm:text-2xl font-bold text-white">ما که هستیم و چرا شروع کردیم؟</h2>
                        </div>

                        <p class="text-sm text-gray-300 leading-loose">
                            ما جمعی از توسعه‌دهندگان، مهندسان نرم‌افزار و پژوهشگران دانشگاه آزاد اسلامی هستیم که زیر نظر <strong class="text-blue-400 font-semibold">باشگاه نخبگان دانشگاه آزاد اسلامی</strong> گرد هم آمدیم. دغدغه اصلی ما یک سوال بنیادین بود: <span class="text-gray-100 font-medium">«چگونه می‌توان با هوش مصنوعی و نرم‌افزار مدرن، بخش‌های فرسوده و سنتی شهر را متحول کرد؟»</span>
                        </p>

                        <p class="text-sm text-gray-300 leading-loose">
                            در میان تمام شریان‌های شهری، مدیریت پارکینگ‌ها هنوز با الگوهای دهه‌های گذشته اداره می‌شد: خطای انسانی در محاسبه زمان و تعرفه، کندی ثبت پلاک، صف‌های طولانی، عدم شفافیت مالی و ناامنی در رصد تردد خودروها.
                        </p>

                        <p class="text-sm text-gray-300 leading-loose">
                            ما برای حل سطحی مسئله به سراغ کدنویسی نرفتیم؛ بلکه <strong class="text-indigo-300">یک سال تمام به تحقیق میدانی عمیق</strong> در سطح پارکینگ‌های عمومی، طبقاتی، تجاری و سازمانی پرداختیم. مستقیماً با اپراتورها، مالکین و رانندگان گفتگو کردیم، گلوگاه‌های تاریک سیستم‌های سنتی را مستند ساختیم و تمام چالش‌هایی که فناوری توانایی باز کردن گره آن را داشت استخراج کردیم.
                        </p>

                        <div class="pt-2">
                            <div class="p-4 rounded-2xl bg-blue-950/40 border border-blue-500/20 text-blue-200 text-xs sm:text-sm leading-relaxed">
                                <span class="font-bold text-blue-400">حاصل این مسیر:</span> خلق <strong>آواپارک</strong>؛ سیستمی جامع، بی‌درنگ (Real-Time)، خودکار در پایش پلاک و امن در مدیریت لایسنس که کنترل کامل پارکینگ را با دقت میلی‌ثانیه‌ای در اختیار مالکان می‌گذارد.
                            </div>
                        </div>
                    </div>

                    {{-- ستون تایم‌لاین هماهنگ‌شده با داستان --}}
                    <div class="lg:col-span-5 bg-gray-950/70 border border-gray-800 rounded-2xl p-6 space-y-6">
                        <h3 class="text-sm font-bold text-gray-200 border-b border-gray-800 pb-3 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            مراحل شکل‌گیری و توسعه
                        </h3>

                        <div class="space-y-6">
                            {{-- فاز ۱ --}}
                            <div class="flex gap-4 items-start">
                                <div class="w-8 h-8 rounded-lg bg-blue-500/20 border border-blue-500/40 flex items-center justify-center text-blue-400 text-xs font-mono font-bold shrink-0">1</div>
                                <div>
                                    <h4 class="text-xs font-bold text-white">تشکیل تیم در باشگاه نخبگان</h4>
                                    <p class="text-[11px] text-gray-400 mt-1 leading-relaxed">
                                        گردهمایی برنامه‌نویسان و پژوهشگران دانشگاه با مأموریت هوشمندسازی ساختارهای سنتی شهر.
                                    </p>
                                </div>
                            </div>

                            {{-- فاز ۲ --}}
                            <div class="flex gap-4 items-start">
                                <div class="w-8 h-8 rounded-lg bg-indigo-500/20 border border-indigo-500/40 flex items-center justify-center text-indigo-400 text-xs font-mono font-bold shrink-0">2</div>
                                <div>
                                    <h4 class="text-xs font-bold text-white">۱ سال پژوهش و عارضه‌یابی میدانی</h4>
                                    <p class="text-[11px] text-gray-400 mt-1 leading-relaxed">
                                        بررسی حضوری پارکینگ‌های تجاری و سازمانی، گفت‌وگو با اپراتورها و ریشه‌یابی خطاهای انسانی و مالی.
                                    </p>
                                </div>
                            </div>

                            {{-- فاز ۳ --}}
                            <div class="flex gap-4 items-start">
                                <div class="w-8 h-8 rounded-lg bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 text-xs font-mono font-bold shrink-0">3</div>
                                <div>
                                    <h4 class="text-xs font-bold text-white">خلق و مهندسی سامانه آواپارک</h4>
                                    <p class="text-[11px] text-gray-400 mt-1 leading-relaxed">
                                        طراحی سیستم جامع پلاک‌خوان آنی با استقاده از هوش مصنوعی، مدیریت جایگاه ها،گزارش‌گیری یکپارچه مالی و سیستم مدیریت تعرفه های جایگاه های پارکینگ.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ۳. ارزش‌های محوری --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="reveal-on-scroll reveal-delay-1 bg-gray-900/40 border border-gray-800/80 hover:border-blue-500/40 rounded-2xl p-6 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">شفافیت و امنیت مطلق</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        حذف خطای انسانی، ثبت تمامی ورود و خروج‌ها با مستندات تصویری و کنترل سطوح دسترسی دستگاه‌ها به صورت لحظه‌ای.
                    </p>
                </div>

                <div class="reveal-on-scroll reveal-delay-2 bg-gray-900/40 border border-gray-800/80 hover:border-blue-500/40 rounded-2xl p-6 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">سرعت پردازش و هوشمندی</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        تشخیص پلاک در کسری از ثانیه، محاسبه خودکار تعرفه با تقویم هوشمند جلالی و اتصال به گیت‌های راه‌بند بدون معطلی.
                    </p>
                </div>

                <div class="reveal-on-scroll reveal-delay-3 bg-gray-900/40 border border-gray-800/80 hover:border-blue-500/40 rounded-2xl p-6 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-white mb-2">پشتیبانی و توسعه مداوم</h3>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        ارائه آپدیت‌های منظم، پاسخگویی ۲۴ ساعته و انعطاف‌پذیری بالا برای اتصال به انواع ساختارهای پارکینگ کوچک و بزرگ.
                    </p>
                </div>
            </div>

            {{-- ۴. باکس فراخوان --}}
            <div class="reveal-on-scroll rounded-3xl border border-gray-800 bg-gradient-to-b from-gray-900/80 to-gray-950/80 p-8 sm:p-10 text-center relative overflow-hidden">
                <div class="max-w-2xl mx-auto space-y-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-white">پارکینگ خود را به نسل جدید تجهیز کنید</h2>
                    <p class="text-xs sm:text-sm text-gray-400">
                        برای دریافت مشاوره تخصصی، بررسی فنی مجموعه و دموی رایگان سیستم با تیم ما در ارتباط باشید.
                    </p>
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                        <a href="{{ route('support') }}" class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition duration-200 shadow-lg shadow-blue-600/25">
                            درخواست مشاوره و پشتیبانی
                        </a>
                        <a href="{{ url('/shop') }}" class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-semibold transition duration-200 border border-gray-700">
                            مشاهده پلن‌ها و لایسنس‌ها
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

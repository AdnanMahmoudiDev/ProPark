<x-app-layout>

    @php
        $screens = [
            [
                'image' => asset('images/app-screenshots/slide1.png'),
                'title' => 'داشبورد اصلی نرم‌افزار ویندوزی',
                'desc' => 'مدیریت و نظارت یکپارچه بر پارکینگ، جایگاه های خالی و پر دوربین ها و ...',
            ],
            [
                'image' => asset('images/app-screenshots/slide2.png'),
                'title' => 'سیستم تعریف تعرفه و قیمت گذاری',
                'desc' => 'تنظیم کردن تعرفه های پلکانی، ویژه، نرخ پایه و سیستم وفاداری و مناسبتی',
            ],
            [
                'image' => asset('images/app-screenshots/slide3.png'),
                'title' => 'سیستم مدیریت کاربران برنامه',
                'desc' => 'سیستمی برای اضاقه یا حذف ادمین ها و یا کارکن جدید در پارکینگ',
            ],
            [
                'image' => asset('images/app-screenshots/slide4.png'),
                'title' => 'تنظیمات جایگاه ها',
                'desc' => 'سیستمی برای تغییرات در تعداد جایگاه های پارکینگ و ...',
            ],
            [
                'image' => asset('images/app-screenshots/slide5.png'),
                'title' => 'گزارش‌گیری و کنترل سامانه',
                'desc' => 'مشاهده گزارش‌های دقیق، کنترل وضعیت سیستم و دسترسی سریع به اطلاعات موردنیاز مدیریت پارکینگ',
            ],
        ];

        $features = [
            [
                'title' => 'مدیریت لایسنس',
                'desc' => 'کنترل کامل بر اشتراک‌ها و لایسنس‌های نرم‌افزاری کاربران به صورت آنلاین.',
                'icon' => 'key',
            ],
            [
                'title' => 'داشبورد هوشمند',
                'desc' => 'مشاهده آمار لحظه‌ای تردد و وضعیت پارکینگ‌ها از طریق پنل کاربری اختصاصی.',
                'icon' => 'layout',
            ],
            [
                'title' => 'اتصال سریع API',
                'desc' => 'اتصال بدون دردسر برنامه پایتون یا ویندوز شما به هسته مرکزی سیستم.',
                'icon' => 'bolt',
            ],
        ];
    @endphp

    <main
        class="relative overflow-hidden py-16 md:py-24"
        dir="rtl"
        x-data="{
            zoomModal: false,
            currentZoomImg: '',
            currentZoomAlt: '',
            openZoom(image, alt = '') {
                this.currentZoomImg = image;
                this.currentZoomAlt = alt;
                this.zoomModal = true;
                document.body.style.overflow = 'hidden';
            },
            closeZoom() {
                this.zoomModal = false;
                this.currentZoomImg = '';
                this.currentZoomAlt = '';
                document.body.style.overflow = '';
            }
        }"
    >
        {{-- هاله نوری پس‌زمینه (بهینه‌شده برای موبایل) --}}
        <div class="pointer-events-none absolute top-0 left-1/2 -translate-x-1/2 w-[520px] md:w-[900px] h-[220px] md:h-[320px] bg-blue-600/10 rounded-full blur-[70px] md:blur-[110px]"></div>

        {{-- Hero Section --}}
        <section class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-blue-900/25 text-blue-300 text-xs sm:text-sm font-semibold mb-5 border border-blue-800/40">
                نسخه 1.0.0 منتشر شد
            </span>

            <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold text-white mb-6 md:mb-8 leading-tight">
                سامانه هوشمند مدیریت پارکینگ
                <br>
                <span class="bg-gradient-to-r from-blue-400 to-sky-400 bg-clip-text text-transparent">
                    ProPark
                </span>
            </h1>

            <p class="text-base sm:text-lg md:text-xl text-gray-400 max-w-2xl mx-auto mb-10 md:mb-12 leading-8">
                راهکار جامع برای کنترل تردد، مدیریت اشتراک‌ها و صدور لایسنس‌های هوشمند.
                ساده، امن و سریع.
            </p>

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mb-16 md:mb-24">
                <a href="{{ route('register') }}"
                   class="bg-gradient-to-r from-blue-600 to-sky-500 text-white px-6 sm:px-8 py-3.5 md:py-4 rounded-2xl text-base md:text-lg font-semibold transition-all duration-300 hover:-translate-y-0.5 shadow-lg shadow-blue-900/20">
                    شروع کار
                </a>

                <a href="{{ route('shop') }}"
                   class="bg-white/5 text-gray-300 px-6 sm:px-8 py-3.5 md:py-4 rounded-2xl text-base md:text-lg font-semibold border border-white/10 hover:bg-white/10 hover:text-white transition duration-300">
                    فروشگاه
                </a>
            </div>
        </section>

        {{-- App Screenshots Section --}}
        <section class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 py-8 md:py-12 space-y-20 md:space-y-28">
            @foreach ($screens as $index => $screen)
                <article class="grid items-center gap-8 md:gap-10 lg:grid-cols-12 lg:gap-14">
                    {{-- تصویر محصول --}}
                    <div class="lg:col-span-8 {{ $index % 2 === 0 ? 'lg:order-1' : 'lg:order-2' }}">
                        <button
                            type="button"
                            class="group relative block w-full text-right cursor-zoom-in focus:outline-none"
                            @click="openZoom(@js($screen['image']), @js($screen['title']))"
                            aria-label="بزرگ‌نمایی تصویر {{ $screen['title'] }}"
                        >
                            <div class="relative overflow-hidden rounded-[1.5rem] md:rounded-[2rem] border border-white/10 bg-white/[0.03] p-2 md:p-2.5 shadow-lg transition duration-300 hover:border-blue-500/30">
                                {{-- سربرگ پنجره فرمالیته --}}
                                <div class="flex items-center justify-between px-3 md:px-4 py-2.5 md:py-3 border-b border-white/5 mb-2">
                                    <div class="flex gap-2">
                                        <span class="w-2 h-2 rounded-full bg-red-500/40"></span>
                                        <span class="w-2 h-2 rounded-full bg-yellow-500/40"></span>
                                        <span class="w-2 h-2 rounded-full bg-green-500/40"></span>
                                    </div>
                                    <span class="text-[8px] sm:text-[9px] text-gray-500 font-medium uppercase tracking-[0.12em] select-none">ProPark Interface</span>
                                    <div class="w-8 md:w-10"></div>
                                </div>

                                <div class="overflow-hidden rounded-[1.2rem] md:rounded-2xl border border-white/5 bg-black/10">
                                    <img
                                        src="{{ $screen['image'] }}"
                                        alt="{{ $screen['title'] }}"
                                        class="block w-full h-auto object-contain transition duration-300 group-hover:scale-[1.01]"
                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                        decoding="async"
                                        @if ($index === 0) fetchpriority="high" @endif
                                    >
                                </div>
                            </div>
                        </button>
                    </div>

                    {{-- متن توضیحات --}}
                    <div class="lg:col-span-4 text-right {{ $index % 2 === 0 ? 'lg:order-2' : 'lg:order-1' }}">
                        

                        <h2 class="text-xl sm:text-2xl md:text-3xl font-bold leading-relaxed text-white mb-4">
                            {{ $screen['title'] }}
                        </h2>

                        <p class="text-sm sm:text-base leading-7 sm:leading-8 text-gray-400">
                            {{ $screen['desc'] }}
                        </p>

                        <div class="mt-6 flex items-center gap-3 text-xs sm:text-sm text-gray-500">
                            <span class="w-8 h-px bg-gradient-to-l from-blue-400 to-transparent"></span>
                            <span>برای بزرگ‌نمایی کلیک کنید</span>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

        {{-- Features Grid (3 Cards with Custom SVGs) --}}
        <section class="relative z-10 max-w-7xl mx-auto px-5 sm:px-6 py-20 md:py-24 grid md:grid-cols-3 gap-5 md:gap-8">
            @foreach ($features as $feature)
                <div class="group bg-white/[0.04] p-6 md:p-8 rounded-[2rem] border border-white/5 hover:border-blue-500/30 transition-all duration-300">
                    {{-- SVG Icon Container --}}
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center mb-6 text-blue-400 transition-transform duration-300 group-hover:scale-110 group-hover:bg-blue-500/20">
                        @if ($feature['icon'] === 'key')
                            {{-- SVG کلید برای مدیریت لایسنس --}}
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        @elseif ($feature['icon'] === 'layout')
                            {{-- SVG داشبورد (Grid Layout) برای داشبورد هوشمند --}}
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z" />
                            </svg>
                        @else
                            {{-- SVG صاعقه (Bolt) برای اتصال سریع API --}}
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        @endif
                    </div>

                    <h3 class="text-lg md:text-xl font-bold mb-3 text-white">
                        {{ $feature['title'] }}
                    </h3>

                    <p class="text-gray-400 leading-7 text-sm">
                        {{ $feature['desc'] }}
                    </p>
                </div>
            @endforeach
        </section>

        {{-- Footer --}}
        <footer class="py-10 text-center text-gray-500 text-sm border-t border-white/5">
            <section class="max-w-7xl mx-auto px-5 sm:px-6 py-16 md:py-20">
                <div class="grid md:grid-cols-2 gap-12 md:gap-16 text-right">
                    {{-- توضیحات درباره ما --}}
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-6">درباره ProPark</h2>
                        <p class="text-gray-400 leading-8 mb-8 text-sm sm:text-base">
                            پروپارک (ProPark) با هدف ارائه راهکارهای مدرن برای مدیریت هوشمند لایسنس و کنترل تردد توسعه یافته است. این سامانه با برقراری ارتباط مداوم میان کلاینت‌های لوکال پایتون و سرور، بستری امن را فراهم می‌کند.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-6 sm:gap-8">
                            <div class="border-r-2 border-blue-500/50 pr-5">
                                <h4 class="text-white font-bold">هدف ما</h4>
                                <p class="text-gray-500 text-xs mt-1 leading-6">ساده‌سازی مدیریت پیچیده سیستم‌ها</p>
                            </div>
                            <div class="border-r-2 border-blue-500/50 pr-5">
                                <h4 class="text-white font-bold">تکنولوژی</h4>
                                <p class="text-gray-500 text-xs mt-1 leading-6">امنیت بالا و یکپارچگی سریع</p>
                            </div>
                        </div>
                    </div>

                    {{-- کارت چرا ما --}}
                    <div class="bg-white/[0.04] border border-white/10 p-7 md:p-10 rounded-[2rem] md:rounded-[3rem] relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-32 h-32 md:w-40 md:h-40 bg-blue-600 rounded-full blur-3xl opacity-10"></div>
                        <h3 class="text-lg md:text-xl font-bold text-white mb-7 relative">چرا ProPark را انتخاب کنید؟</h3>
                        <ul class="space-y-5 relative">
                            <li class="flex items-center text-gray-300 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 ml-4"></span> پایداری و امنیت در هسته سیستم
                            </li>
                            <li class="flex items-center text-gray-300 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 ml-4"></span> گزارش‌گیری دقیق و لحظه‌ای
                            </li>
                            <li class="flex items-center text-gray-300 group">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 ml-4"></span> توسعه یافته با استانداردهای مدرن
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <div class="pt-8 border-t border-white/5 text-gray-600">
                تمام حقوق برای ProPark محفوظ است &copy; {{ date('Y') }}
            </div>
        </footer>

        {{-- Lightbox Modal --}}
        <div
            x-show="zoomModal"
            x-cloak
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/85 p-4"
            @click="closeZoom()"
            @keydown.escape.window="closeZoom()"
        >
            <button
                type="button"
                class="absolute right-5 top-5 z-10 rounded-full border border-white/10 bg-black/40 p-2 text-white/70 transition hover:text-white"
                @click="closeZoom()"
            >
                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img :src="currentZoomImg" :alt="currentZoomAlt" @click.stop class="max-w-full max-h-[90vh] rounded-2xl border border-white/10 object-contain shadow-xl">
        </div>
    </main>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</x-app-layout>

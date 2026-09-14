<x-app-layout>

    @php
        $screens = [
            [
                'image' => asset('images/app-screenshots/slide1.png'),
                'title' => 'داشبورد اصلی نرم‌افزار ویندوزی',
                'desc' => 'مدیریت و نظارت یکپارچه بر پارکینگ، جایگاه‌های خالی و پر، وضعیت دوربین‌ها و رویدادهای زنده سیستم.',
                'badge' => 'کنترل مرکزی',
            ],
            [
                'image' => asset('images/app-screenshots/slide2.png'),
                'title' => 'سیستم تعریف تعرفه و قیمت‌گذاری',
                'desc' => 'تنظیم دقیق تعرفه‌های پلکانی، نرخ پایه روزانه/شبانه، پارکینگ ویژه و تخفیف‌های وفاداری و مناسبتی.',
                'badge' => 'مالی و تعرفه',
            ],
            [
                'image' => asset('images/app-screenshots/slide3.png'),
                'title' => 'سیستم مدیریت کاربران برنامه',
                'desc' => 'سطوح دسترسی تفکیک‌شده برای ادمین‌ها، اپراتورها و پرسنل شیفت با امنیت بالا.',
                'badge' => 'امنیت و دسترسی',
            ],
            [
                'image' => asset('images/app-screenshots/slide4.png'),
                'title' => 'تنظیمات جایگاه‌ها و ظرفیت',
                'desc' => 'پیکربندی داینامیک بلوک‌ها، ظرفیت طبقات و تخصیص هوشمند فضاهای پارک به خودروها.',
                'badge' => 'مدیریت فضا',
            ],
            [
                'image' => asset('images/app-screenshots/slide5.png'),
                'title' => 'گزارش‌گیری جامع و کنترل سامانه',
                'desc' => 'خروجی‌های آماری دقیق، نمودارهای درآمدی و تحلیل ترافیک روزانه برای مدیران پارکینگ.',
                'badge' => 'آنالیز داده',
            ],
        ];

        $features = [
            [
                'title' => 'مدیریت آنلاین لایسنس',
                'desc' => 'اعتبارسنجی آنی، کنترل دستگاه‌های فعال و تمدید خودکار اشتراک‌ها بدون وقفه در عملکرد سامانه.',
                'icon' => 'key',
                'tag' => 'Smart License',
            ],
            [
                'title' => 'داشبورد ابری هوشمند',
                'desc' => 'دسترسی در هر لحظه و از هر مکان به آمار زنده تردد، گزارش‌های مالی و وضعیت کلی گیت‌ها.',
                'icon' => 'layout',
                'tag' => 'Live Analytics',
            ],
            [
                'title' => 'اتصال امن و پرسرعت API',
                'desc' => 'پروتکل ارتباطی سبک و رمزنگاری‌شده میان کلاینت محلی (ویندوز/پایتون) و سرور ابری لاراولی.',
                'icon' => 'bolt',
                'tag' => 'Fast Sync',
            ],
        ];
    @endphp

    <main
        dir="rtl"
        class="relative isolate overflow-hidden py-12 md:py-20"
        x-data="{
            zoomModal: false,
            currentZoomImg: '',
            currentZoomAlt: '',

            openZoom(image, alt = '') {
                this.currentZoomImg = image;
                this.currentZoomAlt = alt;
                this.zoomModal = true;
                document.body.classList.add('overflow-hidden');
            },

            closeZoom() {
                this.zoomModal = false;
                this.currentZoomImg = '';
                this.currentZoomAlt = '';
                document.body.classList.remove('overflow-hidden');
            }
        }"
        @keydown.escape.window="closeZoom()"
    >

        {{-- Background --}}
        <div
            aria-hidden="true"
            class="pointer-events-none absolute inset-0 opacity-30 [background-size:28px_28px] bg-[radial-gradient(#1e293b_1px,transparent_1px)]"
        ></div>

        <div
            aria-hidden="true"
            class="pointer-events-none absolute left-1/2 top-0 h-[300px] w-[600px] -translate-x-1/2 rounded-full bg-blue-600/15 blur-[70px] md:h-[450px] md:w-[1100px] md:blur-[120px]"
        ></div>

        <div
            aria-hidden="true"
            class="pointer-events-none absolute -right-40 top-1/3 h-[350px] w-[350px] rounded-full bg-indigo-600/10 blur-[90px] md:blur-[120px]"
        ></div>

        <div
            aria-hidden="true"
            class="pointer-events-none absolute -left-40 bottom-1/4 h-[400px] w-[400px] rounded-full bg-sky-600/10 blur-[100px] md:blur-[130px]"
        ></div>


        {{-- Hero Section --}}
        <section
            aria-labelledby="hero-title"
            class="relative z-10 mx-auto max-w-7xl px-5 pb-5 pt-4 text-center sm:px-6 md:pb-24 md:pt-8"
        >

            <h1
                id="hero-title"
                data-reveal
                data-reveal-delay="120"
                class="mb-6 mt-6 text-3xl font-black leading-[1.2] tracking-tight text-white sm:text-5xl sm:leading-[1.25] md:mb-8 md:text-6xl lg:text-7xl"
            >
                سامانه هوشمند و یکپارچه
                <br><br>

                <span class="bg-gradient-to-r from-blue-400 via-sky-300 to-indigo-400 bg-clip-text text-transparent">
                    مدیریت پارکینگ AvaPark
                </span>
            </h1>

            <p
                data-reveal
                data-reveal-delay="240"
                class="mx-auto mb-10 max-w-2xl text-base leading-relaxed text-gray-300 sm:text-lg md:mb-12 md:text-xl"
            >
                پلتفرم جامع کنترل تردد، پایش لحظه‌ای جایگاه‌ها و صدور لایسنس نرم‌افزاری بر بستر وب و کلاینت ویندوز.
            </p>

            {{-- CTA --}}
            <div
                data-reveal
                data-reveal-delay="360"
                class="flex flex-col items-center justify-center gap-4 sm:flex-row"
            >

                <a
                    href="{{ route('register') }}"
                    class="group relative w-full overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-4 text-center text-base font-bold text-white shadow-xl shadow-blue-600/25 transition-shadow duration-300 hover:shadow-blue-500/40 active:scale-[0.98] sm:w-auto"
                    aria-label="شروع کار و ثبت‌نام در AvaPark"
                >
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        شروع کار و ثبت‌نام

                        <svg
                            aria-hidden="true"
                            class="h-5 w-5 transition-transform duration-200 group-hover:-translate-x-1"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 5l7 7m0 0l-7 7m7-7H4"
                            />
                        </svg>
                    </span>

                    <span
                        aria-hidden="true"
                        class="absolute inset-0 hidden -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-700 group-hover:translate-x-full sm:block"
                    ></span>
                </a>

                <a
                    href="{{ route('shop') }}"
                    class="group inline-flex w-full items-center justify-center gap-2.5 rounded-2xl border border-gray-700/80 bg-gray-900/70 px-8 py-4 text-base font-semibold text-gray-200 shadow-lg shadow-black/10 transition-colors duration-300 hover:border-blue-500/40 hover:bg-gray-800/90 hover:text-white active:scale-[0.98] sm:w-auto"
                    aria-label="مشاهده تعرفه‌ها و فروشگاه AvaPark"
                >
                    <svg
                        aria-hidden="true"
                        class="h-5 w-5 text-blue-400 transition-transform duration-200 group-hover:scale-110"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.2 6.4a1 1 0 001 .6h12.4M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"
                        />
                    </svg>

                    مشاهده تعرفه‌ها و فروشگاه
                </a>

            </div>
        </section>


        {{-- Application Screenshots --}}
        <section
            id="features"
            aria-labelledby="screenshots-title"
            class="relative z-10 mx-auto max-w-7xl scroll-mt-24 space-y-24 px-5 py-8 sm:px-6 md:space-y-36 md:py-16"
        >

            <h2 id="screenshots-title" class="sr-only">
                امکانات و بخش‌های مختلف نرم‌افزار AvaPark
            </h2>

            @foreach ($screens as $index => $screen)

                <article
                    class="grid items-center gap-8 md:gap-12 lg:grid-cols-12 lg:gap-16"
                >

                    {{-- Screenshot --}}
                    <div
                        data-reveal
                        data-reveal-delay="{{ $index * 80 }}"
                        class="lg:col-span-7 {{ $index % 2 === 0 ? 'lg:order-1' : 'lg:order-2' }}"
                    >

                        <button
                            type="button"
                            class="group relative block w-full cursor-zoom-in text-right focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-4 focus-visible:ring-offset-gray-950"
                            @click="openZoom(@js($screen['image']), @js($screen['title']))"
                            aria-label="بزرگ‌نمایی تصویر {{ $screen['title'] }}"
                        >

                            <div
                                aria-hidden="true"
                                class="absolute -inset-1 hidden rounded-[2rem] bg-gradient-to-r from-blue-600/20 to-sky-500/20 blur-lg transition-opacity duration-500 group-hover:opacity-100 md:block"
                            ></div>

                            <div class="relative overflow-hidden rounded-[1.8rem] border border-gray-800 bg-gray-950/70 p-2.5 shadow-2xl md:rounded-[2.2rem] md:p-3">

                                <div class="mb-2.5 flex items-center justify-between rounded-t-[1.4rem] border-b border-gray-800/80 bg-gray-900/40 px-3 py-2.5 md:px-4">

                                    <div class="flex gap-2" aria-hidden="true">
                                        <span class="h-2.5 w-2.5 rounded-full bg-red-500/60"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-yellow-500/60"></span>
                                        <span class="h-2.5 w-2.5 rounded-full bg-green-500/60"></span>
                                    </div>

                                    <span class="select-none font-mono text-[9px] uppercase tracking-widest text-gray-400 sm:text-[10px]">
                                        AvaPark • System UI
                                    </span>

                                    <span class="font-mono text-[10px] text-gray-500">
                                        v1.0
                                    </span>

                                </div>

                                <div class="overflow-hidden rounded-[1.2rem] border border-gray-800/80 bg-black/40 md:rounded-2xl">

                                    <img
                                        src="{{ $screen['image'] }}"
                                        alt="{{ $screen['title'] }} - سامانه مدیریت پارکینگ AvaPark"
                                        class="block h-auto w-full object-contain"
                                        width="1280"
                                        height="720"
                                        loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                        decoding="async"
                                        @if ($index === 0)
                                            fetchpriority="high"
                                        @endif
                                    >

                                </div>
                            </div>

                        </button>
                    </div>


                    {{-- Screenshot Description --}}
                    <div
                        data-reveal
                        data-reveal-delay="{{ $index * 80 + 160 }}"
                        class="text-right lg:col-span-5 {{ $index % 2 === 0 ? 'lg:order-2' : 'lg:order-1' }}"
                    >

                        <div class="mb-4 flex items-center gap-3">

                            <span class="rounded-lg border border-blue-500/20 bg-blue-500/10 px-3 py-1 text-xs font-bold text-blue-400">
                                {{ $screen['badge'] }}
                            </span>

                            <span class="font-mono text-xs font-bold tracking-wider text-gray-600">
                                {{ sprintf('۰%d', $index + 1) }}
                            </span>

                        </div>

                        <h3 class="mb-4 text-2xl font-extrabold leading-tight text-white sm:text-3xl">
                            {{ $screen['title'] }}
                        </h3>

                        <p class="mb-6 text-sm leading-relaxed text-gray-400 sm:text-base">
                            {{ $screen['desc'] }}
                        </p>

                        <div class="inline-flex items-center gap-2.5 rounded-xl border border-blue-500/10 bg-blue-500/5 px-3 py-1.5 text-xs font-medium text-blue-400 sm:text-sm">

                            <svg
                                aria-hidden="true"
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"
                                />
                            </svg>

                            <span>جهت مشاهده ابعاد کامل تصویر کلیک کنید</span>

                        </div>

                    </div>

                </article>

            @endforeach

        </section>


        {{-- Features Grid --}}
        <section
            aria-labelledby="core-features-title"
            class="relative z-10 mx-auto max-w-7xl px-5 py-20 sm:px-6 md:py-28"
        >

            <div
                data-reveal
                class="mx-auto mb-16 max-w-2xl text-center"
            >

                <span class="text-xs font-bold uppercase tracking-wider text-blue-400 sm:text-sm">
                    ویژگی‌های هسته مرکزی
                </span>

                <h2
                    id="core-features-title"
                    class="mb-4 mt-2 text-2xl font-extrabold text-white sm:text-4xl"
                >
                    چرا سیستم نرم‌افزاری AvaPark؟
                </h2>

                <p class="text-sm text-gray-400 sm:text-base">
                    معماری مقیاس‌پذیر، تعامل بلادرنگ با سخت‌افزار و بالاترین ضریب اطمینان در ذخیره‌سازی اطلاعات.
                </p>

            </div>


            <div class="grid gap-6 md:grid-cols-3 md:gap-8">

                @foreach ($features as $feature)

                    <article
                        data-reveal
                        data-reveal-delay="{{ $loop->index * 100 }}"
                        class="group relative rounded-3xl border border-gray-800/90 bg-gradient-to-b from-gray-900/60 to-gray-950/60 p-7 transition-colors duration-300 hover:border-blue-500/40 md:p-8"
                    >

                        <div class="mb-6 flex items-center justify-between">

                            <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-blue-500/20 bg-blue-600/10 text-blue-400 transition-colors duration-300 group-hover:bg-blue-600 group-hover:text-white">

                                @if ($feature['icon'] === 'key')

                                    <svg
                                        aria-hidden="true"
                                        class="h-7 w-7"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"
                                        />
                                    </svg>

                                @elseif ($feature['icon'] === 'layout')

                                    <svg
                                        aria-hidden="true"
                                        class="h-7 w-7"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 12a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"
                                        />
                                    </svg>

                                @else

                                    <svg
                                        aria-hidden="true"
                                        class="h-7 w-7"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"
                                        />
                                    </svg>

                                @endif

                            </div>

                            <span class="rounded-lg border border-gray-800 bg-gray-900/80 px-2.5 py-1 font-mono text-[11px] font-semibold uppercase text-gray-500">
                                {{ $feature['tag'] }}
                            </span>

                        </div>

                        <h3 class="mb-3 text-xl font-bold text-white">
                            {{ $feature['title'] }}
                        </h3>

                        <p class="text-sm leading-relaxed text-gray-400">
                            {{ $feature['desc'] }}
                        </p>

                    </article>

                @endforeach

            </div>

        </section>


        {{-- Footer --}}
        <footer
            class="relative z-10 border-t border-gray-800/80 bg-gray-950/60 text-right"
        >

            <section class="mx-auto max-w-7xl px-5 py-16 sm:px-6 md:py-20">

                <div class="grid items-start gap-12 md:grid-cols-2 md:gap-16">

                    <div data-reveal>

                        <div class="mb-6 flex items-center gap-3">

                            <x-application-logo
                                class="h-9 w-9 text-blue-500"
                            />

                            <h2 class="text-2xl font-black text-white">
                                درباره AvaPark
                            </h2>

                        </div>

                        <p class="mb-8 text-sm leading-relaxed text-gray-400 sm:text-base">
                            سامانه آواپارک (AvaPark) با هدف ارائه راهکارهای مدرن برای مدیریت هوشمند لایسنس و کنترل تردد پارکینگ‌های تجاری و مسکونی توسعه یافته است. این سیستم با ارتباط مداوم و امن کلاینت‌های لوکال و سرور مرکزی، پایداری ۱۰۰ درصدی عملکرد را تضمین می‌کند.
                        </p>

                        <div class="grid grid-cols-2 gap-4">

                            <div class="rounded-l-xl border-r-2 border-blue-500/40 bg-blue-500/5 p-3">
                                <h3 class="text-sm font-bold text-white">
                                    پایداری بالا
                                </h3>

                                <p class="mt-1 text-xs text-gray-400">
                                    عملکرد بدون وقفه آفلاین/آنلاین
                                </p>
                            </div>

                            <div class="rounded-l-xl border-r-2 border-indigo-500/40 bg-indigo-500/5 p-3">
                                <h3 class="text-sm font-bold text-white">
                                    توسعه ماژولار
                                </h3>

                                <p class="mt-1 text-xs text-gray-400">
                                    امکان اتصال به انواع دوربین پلاک‌خوان
                                </p>
                            </div>

                        </div>

                    </div>


                    <div
                        data-reveal
                        data-reveal-delay="150"
                        class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gradient-to-b from-gray-900/80 to-gray-950/90 p-8 shadow-xl"
                    >

                        <div
                            aria-hidden="true"
                            class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-600/15 blur-3xl"
                        ></div>

                        <h3 class="relative mb-6 flex items-center gap-2 text-lg font-bold text-white">

                            <span
                                aria-hidden="true"
                                class="h-2 w-2 rounded-full bg-blue-500"
                            ></span>

                            مزیت‌های رقابتی AvaPark

                        </h3>

                        <ul class="relative space-y-4 text-sm">

                            <li class="flex items-center text-gray-300">
                                <svg
                                    aria-hidden="true"
                                    class="ml-3 h-4 w-4 shrink-0 text-blue-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                اعتبارسنجی بلادرنگ لایسنس و جلوگیری از سوءاستفاده
                            </li>

                            <li class="flex items-center text-gray-300">
                                <svg
                                    aria-hidden="true"
                                    class="ml-3 h-4 w-4 shrink-0 text-blue-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                گزارش‌گیری آنی مالی، خروجی اکسل و داشبورد تفکیکی
                            </li>

                            <li class="flex items-center text-gray-300">
                                <svg
                                    aria-hidden="true"
                                    class="ml-3 h-4 w-4 shrink-0 text-blue-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2.5"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                رابط کاربری مدرن، سبک و بهینه‌شده برای صفحات لمسی
                            </li>

                        </ul>

                    </div>

                </div>

            </section>

        </footer>


        {{-- Lightbox Modal --}}
        <div
            x-show="zoomModal"
            x-cloak
            x-transition:enter="transition-opacity ease-out duration-150"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-4 sm:p-6"
            role="dialog"
            aria-modal="true"
            aria-label="نمایش بزرگ تصویر"
            @click="closeZoom()"
        >

            <div
                class="relative flex w-full max-w-5xl flex-col items-center"
                @click.stop
            >

                <div class="flex w-full items-center justify-between pb-3 text-white">

                    <span
                        class="text-sm font-semibold text-gray-200"
                        x-text="currentZoomAlt"
                    ></span>

                    <button
                        type="button"
                        class="cursor-pointer rounded-full border border-gray-700 bg-gray-900/80 p-2 text-gray-400 transition hover:bg-gray-800 hover:text-white"
                        @click="closeZoom()"
                        aria-label="بستن تصویر بزرگ"
                    >

                        <svg
                            aria-hidden="true"
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>

                    </button>

                </div>

                <img
                    :src="currentZoomImg"
                    :alt="currentZoomAlt"
                    class="max-h-[82vh] max-w-full rounded-2xl border border-gray-800 bg-gray-950 object-contain shadow-2xl"
                    @click.stop
                >

            </div>

        </div>

    </main>

</x-app-layout>
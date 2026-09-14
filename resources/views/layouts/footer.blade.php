<footer
    role="contentinfo"
    aria-label="فوتر و دسترسی‌های سریع AvaPark"
    class="mt-auto border-t border-white/10 bg-gray-950 text-gray-400 sm:bg-gradient-to-b sm:from-black/20 sm:via-black/40 sm:to-black/60 sm:backdrop-blur-md"
>
    <div class="mx-auto max-w-7xl px-5 pt-10 pb-7 sm:px-6 sm:pt-12 sm:pb-8">

        {{-- بخش اصلی فوتر --}}
        <div class="mb-8 grid grid-cols-1 gap-8 text-right md:mb-10 md:grid-cols-2 lg:grid-cols-4">

            {{-- ستون ۱: برند و معرفی پلتفرم --}}
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span
                        class="h-2.5 w-2.5 rounded-full bg-blue-500 motion-safe:animate-pulse"
                        aria-hidden="true"
                    ></span>

                    <span class="text-lg font-bold tracking-tight text-white">
                        AvaPark
                    </span>
                </div>

                <p class="text-justify text-xs leading-6 text-gray-400">
                    سامانه هوشمند مدیریت لایسنس، رهگیری فعال دستگاه‌ها و کنترل تردد خودکار.
                    بهینه‌سازی شده برای کنترل پارکینگ‌ها و مدیریت آسان دسترسی‌ها.
                </p>
            </div>

            {{-- ستون ۲: دسترسی سریع و صفحات --}}
            <nav aria-label="لینک‌های دسترسی سریع">
                <h2 class="mb-4 border-b border-white/5 pb-2 text-sm font-semibold text-white">
                    دسترسی سریع
                </h2>

                <ul class="space-y-2.5 text-xs leading-5">
                    <li>
                        <a
                            href="{{ Route::has('home') ? route('home') : url('/') }}"
                            title="بازگشت به صفحه اصلی AvaPark"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            صفحه اصلی
                        </a>
                    </li>

                    @guest
                        <li>
                            <a
                                href="{{ Route::has('login') ? route('login') : url('/login') }}"
                                title="ورود به پنل کاربری"
                                class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                ورود به پنل
                            </a>
                        </li>

                        <li>
                            <a
                                href="{{ Route::has('register') ? route('register') : url('/register') }}"
                                title="ساخت حساب کاربری جدید"
                                class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                ثبت‌نام حساب جدید
                            </a>
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ Route::has('dashboard') ? route('dashboard') : url('/dashboard') }}"
                                title="ورود به داشبورد کاربری"
                                class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                داشبورد کاربری
                            </a>
                        </li>
                    @endguest

                    <li>
                        <a
                            href="{{ url('/shop') }}"
                            title="مشاهده تعرفه‌ها و پلن‌های AvaPark"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            تعرفه‌ها و پلن‌ها
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- ستون ۳: قوانین و پشتیبانی --}}
            <nav aria-label="پشتیبانی و قوانین">
                <h2 class="mb-4 border-b border-white/5 pb-2 text-sm font-semibold text-white">
                    پشتیبانی و قوانین
                </h2>

                <ul class="space-y-2.5 text-xs leading-5">
                    <li>
                        <a
                            href="{{ url('/terms') }}"
                            title="مطالعه شرایط و قوانین استفاده"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            شرایط و قوانین استفاده
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ url('/privacy') }}"
                            title="مطالعه سیاست حریم خصوصی کاربران"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            حریم خصوصی کاربران
                        </a>
                    </li>

                    <li class="pt-2">
                        <span class="mb-1 block text-[11px] text-gray-500">
                            ارتباط مستقیم از طریق ایمیل:
                        </span>

                        <a
                            href="mailto:support@avapark.ir"
                            dir="ltr"
                            title="ارسال ایمیل به پشتیبانی AvaPark"
                            class="flex max-w-full items-center gap-1.5 break-all font-mono text-xs text-gray-300 transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <svg
                                class="h-3.5 w-3.5 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                />
                            </svg>

                            <span>support@avapark.ir</span>
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- ستون ۴: نماد اعتماد الکترونیکی --}}
            <div>
                <h2 class="mb-4 border-b border-white/5 pb-2 text-right text-sm font-semibold text-white md:text-left">
                    نماد اعتماد
                </h2>

                <div class="inline-block rounded-xl border border-white/10 bg-white p-2.5 shadow-lg transition-shadow duration-200 hover:shadow-blue-500/10">
                    <a
                        href="https://trustseal.enamad.ir/?id=765670&Code=dLfUNy1H0QGcHNPTPZ5GyDCg9s8CWECD"
                        target="_blank"
                        rel="noopener noreferrer"
                        referrerpolicy="origin"
                        aria-label="مشاهده مجوز نماد اعتماد الکترونیکی AvaPark"
                        title="مشاهده نماد اعتماد الکترونیکی"
                    >
                        <img
                            src="https://trustseal.enamad.ir/logo.aspx?id=765670&Code=dLfUNy1H0QGcHNPTPZ5GyDCg9s8CWECD"
                            alt="نماد اعتماد الکترونیکی AvaPark"
                            width="56"
                            height="56"
                            loading="lazy"
                            decoding="async"
                            referrerpolicy="origin"
                            class="h-14 w-14 object-contain"
                            code="dLfUNy1H0QGcHNPTPZ5GyDCg9s8CWECD"
                        >
                    </a>
                </div>
            </div>
        </div>

        {{-- نوار کپی‌رایت و اطلاعات نسخه --}}
        <div class="flex flex-col items-center gap-4 border-t border-white/10 pt-6 text-center text-xs text-gray-500 sm:flex-row sm:justify-between sm:text-right">

            <div class="w-full leading-6 sm:w-auto">
                © {{ now()->year }}
                <span class="font-medium text-gray-200">AvaPark</span>.
                تمامی حقوق مادی و معنوی محفوظ است.
            </div>

            <div
                dir="ltr"
                class="flex w-full flex-wrap items-center justify-center gap-x-3 gap-y-2 font-mono text-xs sm:w-auto sm:justify-end"
            >
                <a
                    href="mailto:info@avapark.ir"
                    title="ارسال ایمیل به AvaPark"
                    class="max-w-full break-all transition-colors duration-200 hover:text-gray-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                >
                    info@avapark.ir
                </a>

                <span
                    class="text-white/20"
                    aria-hidden="true"
                >
                    |
                </span>

                <span class="whitespace-nowrap text-gray-500">
                    v1.0.0
                </span>
            </div>
        </div>
    </div>
</footer>
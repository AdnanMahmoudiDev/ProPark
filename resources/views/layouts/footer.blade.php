<footer
    role="contentinfo"
    aria-label="{{ __('AvaPark footer and quick access') }}"
    class="mt-auto border-t border-white/10 bg-gray-950 text-gray-400 sm:bg-gradient-to-b sm:from-black/20 sm:via-black/40 sm:to-black/60 sm:backdrop-blur-md"
>
    <div class="mx-auto max-w-7xl px-5 pt-10 pb-7 sm:px-6 sm:pt-12 sm:pb-8">

        {{-- بخش اصلی فوتر --}}
        <div class="mb-8 grid grid-cols-1 gap-8 text-start md:mb-10 md:grid-cols-2 lg:grid-cols-4">

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
                    {{ __('AvaPark platform description') }}
                </p>
            </div>

            {{-- ستون ۲: دسترسی سریع و صفحات --}}
            <nav aria-label="{{ __('Quick access links') }}">
                <h2 class="mb-4 border-b border-white/5 pb-2 text-sm font-semibold text-white">
                    {{ __('Quick Access') }}
                </h2>

                <ul class="space-y-2.5 text-xs leading-5">
                    <li>
                        <a
                            href="{{ Route::has('home') ? route('home') : url('/') }}"
                            title="{{ __('Back to AvaPark home page') }}"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            {{ __('Home') }}
                        </a>
                    </li>

                    @guest
                        <li>
                            <a
                                href="{{ Route::has('login') ? route('login') : url('/login') }}"
                                title="{{ __('Login to user panel') }}"
                                class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                {{ __('Login') }}
                            </a>
                        </li>

                        <li>
                            <a
                                href="{{ Route::has('register') ? route('register') : url('/register') }}"
                                title="{{ __('Create a new account') }}"
                                class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                {{ __('Register') }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a
                                href="{{ Route::has('dashboard') ? route('dashboard') : url('/dashboard') }}"
                                title="{{ __('Go to user dashboard') }}"
                                class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            >
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                    @endguest

                    <li>
                        <a
                            href="{{ url('/shop') }}"
                            title="{{ __('View AvaPark pricing and plans') }}"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            {{ __('Pricing & Plans') }}
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- ستون ۳: قوانین و پشتیبانی --}}
            <nav aria-label="{{ __('Support and Rules') }}">
                <h2 class="mb-4 border-b border-white/5 pb-2 text-sm font-semibold text-white">
                    {{ __('Support and Rules') }}
                </h2>

                <ul class="space-y-2.5 text-xs leading-5">
                    <li>
                        <a
                            href="{{ url('/terms') }}"
                            title="{{ __('Read terms and conditions') }}"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            {{ __('Terms and Conditions') }}
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ url('/privacy') }}"
                            title="{{ __('Read user privacy policy') }}"
                            class="inline-block transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            {{ __('Privacy Policy') }}
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- ستون ۴: نماد اعتماد الکترونیکی --}}
            <div>
                <h2 class="mb-4 border-b border-white/5 pb-2 text-start text-sm font-semibold text-white">
                    {{ __('Trust Seal') }}
                </h2>

                <div class="inline-block rounded-xl border border-white/10 bg-white p-2.5 shadow-lg transition-shadow duration-200 hover:shadow-blue-500/10">
                    <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=765670&Code=GAPGPTMASKTOKEN9pk7mbmshq5X0X'>
                        <img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=765670&Code=GAPGPTMASKTOKEN9pk7mbmshq5X1X' alt='{{ __('AvaPark electronic trust symbol') }}' style='cursor:pointer' code='GAPGPTMASKTOKEN9pk7mbmshq5X2X' class="h-14 w-14 object-contain">
                    </a>
                </div>
            </div>
        </div>

        {{-- نوار کپی‌رایت و اطلاعات نسخه --}}
        <div class="flex flex-col items-center gap-4 border-t border-white/10 pt-6 text-center text-xs text-gray-500 sm:flex-row sm:justify-between sm:text-start">

            <div class="w-full leading-6 sm:w-auto">
                © {{ now()->year }}
                <span class="font-medium text-gray-200">AvaPark</span>.
                {{ __('All rights reserved.') }}
            </div>

            <div class="flex w-full flex-col items-center gap-1 text-xs sm:w-auto sm:items-end">
                <span class="text-[11px] text-gray-500">
                    {{ __('Direct contact via email:') }}
                </span>

                <a
                    href="mailto:support@avapark.ir"
                    dir="ltr"
                    title="{{ __('Send email to AvaPark support') }}"
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
            </div>
        </div>
    </div>
</footer>

<nav
    role="navigation"
    aria-label="{{ __('AvaPark main navigation') }}"
    x-data="{
        open: false,
        profileDropdown: false,
        langDropdown: false,

        scrollToFeatures() {
            this.open = false;
            this.profileDropdown = false;
            this.langDropdown = false;

            const target = document.getElementById('features');

            if (target) {
                const headerOffset = 70;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            } else {
                window.location.href = '{{ url('/') }}#features';
            }
        }
    }"
    @keydown.escape.window="open = false; langDropdown = false; profileDropdown = false"
    class="sticky top-0 z-50 border-b border-gray-800/80 bg-gray-950/95 backdrop-blur-xl"
>

    {{-- نوار نئونی آبی بالای هدر --}}
    <div class="h-[2px] w-full bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-90"></div>

    {{-- کانتینر اصلی هدر دسکتاپ و موبایل --}}
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-3 sm:px-6 lg:px-8">

        {{-- بخش راست: لوگو و لینک‌های دسکتاپ --}}
        <div class="flex items-center gap-4 lg:gap-8">

            {{-- لوگوی سیستم --}}
            <a
                href="{{ auth()->check() ? (Route::has('dashboard') ? route('dashboard') : url('/')) : url('/') }}"
                class="group flex shrink-0 items-center gap-2.5 sm:gap-3 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-950"
                aria-label="{{ __('AvaPark home page') }}"
            >
                <div class="relative flex items-center justify-center">
                    <div class="absolute -inset-1 hidden rounded-xl bg-blue-500/20 blur-sm transition duration-300 group-hover:bg-blue-500/40 sm:block"></div>

                    <x-application-logo
                        class="relative block h-9 w-9 sm:h-10 sm:w-10 fill-current text-blue-500 transition-transform duration-200 group-hover:scale-105"
                    />
                </div>

                <div class="flex flex-col">
                    <span class="text-sm sm:text-base font-black tracking-tight text-white transition-colors duration-200 group-hover:text-blue-400">
                        AvaPark
                    </span>

                    <span class="-mt-1 hidden font-mono text-[11px] text-gray-400 sm:inline-block">
                        {{ __('Intelligent Parking Management System') }}
                    </span>
                </div>
            </a>

            {{-- لینک‌های ناوبری دسکتاپ --}}
            <div class="hidden items-center gap-5 md:flex lg:gap-6">

                <a
                    href="{{ url('/') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('/') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('/')) aria-current="page" @endif
                >
                    {{ __('Home') }}
                </a>

                <a
                    href="{{ url('/shop') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('shop*') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('shop*')) aria-current="page" @endif
                >
                    {{ __('Pricing') }}
                </a>

                <button
                    type="button"
                    @click="scrollToFeatures()"
                    class="cursor-pointer rounded-md text-xs font-semibold text-gray-400 transition-colors duration-200 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                >
                    {{ __('System Features') }}
                </button>

                <a
                    href="{{ Route::has('blog.index') ? route('blog.index') : url('/blog') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('blog*') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('blog*')) aria-current="page" @endif
                >
                    {{ __('Blog') }}
                </a>

                <a
                    href="{{ url('/about') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('about*') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('about*')) aria-current="page" @endif
                >
                    {{ __('About Us') }}
                </a>

                <a
                    href="{{ url('/terms') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('terms*') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('terms*')) aria-current="page" @endif
                >
                    {{ __('Rules') }}
                </a>

                <a
                    href="{{ url('/privacy') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('privacy*') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('privacy') }}
                </a>

                <a
                    href="{{ url('/support') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('support*') ? 'text-blue-400 font-bold' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('support*')) aria-current="page" @endif
                >
                    {{ __('Support') }}
                </a>
            </div>

        </div>

        {{-- بخش چپ: زبان دسکتاپ، سبد خرید، لاگین/شروع و منوی موبایل --}}
        <div class="flex items-center gap-2 sm:gap-3">

            {{-- انتخاب زبان دسکتاپ --}}
            @php
                $currentLocale = app()->getLocale();
            @endphp

            @if(Route::has('locale.switch'))
                <div class="relative hidden md:block" @click.outside="langDropdown = false">
                    <button
                        type="button"
                        @click="langDropdown = !langDropdown"
                        :aria-expanded="langDropdown"
                        aria-haspopup="true"
                        class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-gray-800 bg-gray-900/80 px-3 py-1.5 text-xs font-semibold text-gray-300 shadow-sm transition duration-200 hover:border-blue-500/40 hover:bg-gray-900 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        title="{{ __('Select Language') }}"
                    >
                        <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.6 9h16.8M3.6 15h16.8" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.5 3a17 17 0 000 18M12.5 3a17 17 0 010 18" />
                        </svg>

                        <span class="font-bold uppercase tracking-wider">
                            {{ $currentLocale === 'fa' ? 'فارسی' : 'EN' }}
                        </span>

                        <svg
                            class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200"
                            :class="{ 'rotate-180': langDropdown }"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div
                        x-cloak
                        x-show="langDropdown"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute left-0 z-50 mt-2 w-44 origin-top-left overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/95 p-1.5 shadow-2xl shadow-black/80 backdrop-blur-md"
                    >
                        <a
                            href="{{ route('locale.switch', 'fa') }}"
                            class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-semibold transition duration-150 {{ $currentLocale === 'fa' ? 'bg-blue-600/15 font-bold text-blue-400' : 'text-gray-300 hover:bg-gray-800/80 hover:text-white' }}"
                        >
                            <div class="flex items-center gap-2">
                                <span class="text-sm">FA</span>
                                <span>فارسی</span>
                            </div>
                            @if($currentLocale === 'fa')
                                <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </a>

                        <a
                            href="{{ route('locale.switch', 'en') }}"
                            class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-semibold transition duration-150 {{ $currentLocale === 'en' ? 'bg-blue-600/15 font-bold text-blue-400' : 'text-gray-300 hover:bg-gray-800/80 hover:text-white' }}"
                        >
                            <div class="flex items-center gap-2">
                                <span class="text-sm">EN</span>
                                <span>English</span>
                            </div>
                            @if($currentLocale === 'en')
                                <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>
            @endif

            {{-- سبد خرید --}}
            @if(Route::has('user.cart.index'))
                @auth
                    <a
                        href="{{ route('user.cart.index') }}"
                        class="relative flex h-9 w-9 sm:h-10 sm:w-10 items-center justify-center rounded-xl border border-gray-800 bg-gray-900/80 text-gray-300 transition duration-200 hover:border-blue-500/40 hover:text-blue-400"
                        title="{{ __('Cart') }}"
                        aria-label="{{ __('View shopping cart') }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        @if(isset($pendingCartCount) && $pendingCartCount > 0)
                            <span class="absolute -right-1 -top-1 flex h-4 w-4 items-center justify-center rounded-full bg-blue-600 text-[9px] font-black text-white shadow-sm shadow-blue-500/50">
                                {{ $pendingCartCount }}
                            </span>
                        @endif
                    </a>
                @endauth
            @endif

            {{-- دکمه‌های ورود و شروع (آبی یکدست) --}}
            @guest
                <div class="flex items-center gap-1.5 sm:gap-2">
                    @if(Route::has('login'))
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-gray-800 bg-gray-900/80 px-2.5 py-1.5 sm:px-3.5 sm:py-2 text-[11px] sm:text-xs font-semibold text-gray-300 transition duration-200 hover:border-gray-700 hover:bg-gray-800 hover:text-white"
                        >
                            <span>{{ __('Login') }}</span>
                        </a>
                    @endif

                    @if(Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-blue-400/30 bg-blue-600 hover:bg-blue-500 px-3 py-1.5 sm:px-4 sm:py-2 text-[11px] sm:text-xs font-bold text-white shadow-lg shadow-blue-600/25 transition-all duration-200"
                        >
                            <span>{{ __('Start Free') }}</span>
                        </a>
                    @endif
                </div>
            @endguest

            {{-- حساب کاربری لاگین شده --}}
            @auth
                {{-- پروفایل دسکتاپ --}}
                <div class="relative hidden sm:block" @click.outside="profileDropdown = false">
                    <button
                        type="button"
                        @click="profileDropdown = !profileDropdown"
                        :aria-expanded="profileDropdown"
                        class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-800 bg-gray-900/80 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-200 shadow-sm transition duration-200 hover:border-blue-500/40 hover:bg-gray-900"
                    >
                        <div class="relative flex h-7 w-7 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold uppercase text-white shadow-sm">
                            {{ mb_substr(Auth::user()?->name ?? 'U', 0, 1) }}
                            <span class="absolute -bottom-0.5 -right-0.5 h-2 w-2 rounded-full border border-gray-950 bg-emerald-500"></span>
                        </div>

                        <span class="max-w-[110px] truncate text-xs font-semibold">
                            {{ Auth::user()?->name }}
                        </span>

                        <svg class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': profileDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div
                        x-cloak
                        x-show="profileDropdown"
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute left-0 z-50 mt-2 w-64 origin-top-left overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/95 shadow-2xl shadow-black/70"
                    >
                        <div class="border-b border-gray-800 bg-gray-950/70 px-4 py-3">
                            <div class="flex items-center justify-between gap-2">
                                <span class="truncate text-xs font-bold text-white">
                                    {{ Auth::user()?->name }}
                                </span>
                                <span class="rounded border border-blue-500/20 bg-blue-500/10 px-1.5 py-0.5 font-mono text-[10px] text-blue-400">
                                    {{ __('User') }}
                                </span>
                            </div>
                            <div class="mt-0.5 truncate font-mono text-[11px] text-gray-400">
                                {{ Auth::user()?->email }}
                            </div>
                        </div>

                        <div class="space-y-1 p-1.5">
                            @if(Route::has('dashboard'))
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-600/10 hover:text-blue-400">
                                    <span>{{ __('Admin Panel') }}</span>
                                </a>
                            @endif

                            @if(Route::has('profile.edit'))
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-600/10 hover:text-blue-400">
                                    <span>{{ __('Account Settings') }}</span>
                                </a>
                            @endif

                            <div class="my-1 border-t border-gray-800"></div>

                            @if(Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="flex w-full cursor-pointer items-center gap-2.5 rounded-xl px-3 py-2 text-right text-xs font-semibold text-rose-400 transition duration-150 hover:bg-rose-500/10 hover:text-rose-300">
                                        <span>{{ __('Logout') }}</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- موبایل: دکمه دسترسی سریع پنل با رنگ آبی --}}
                @if(Route::has('dashboard'))
                    <a
                        href="{{ route('dashboard') }}"
                        class="inline-flex sm:hidden items-center justify-center gap-1 rounded-xl border border-blue-500/30 bg-blue-950/40 px-2.5 py-1.5 text-[11px] font-bold text-blue-400 shadow-sm transition hover:bg-blue-900/60"
                        title="{{ __('Admin Panel') }}"
                    >
                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>{{ __('پنل') }}</span>
                    </a>
                @endif
            @endauth

            {{-- دکمه منوی همبرگری موبایل --}}
            <div class="flex items-center md:hidden">
                <button
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open"
                    aria-label="{{ __('Toggle navigation menu') }}"
                    class="flex h-9 w-9 items-center justify-center rounded-xl border border-gray-800 bg-gray-900/90 text-gray-300 transition duration-200 hover:border-blue-500/40 hover:bg-gray-800 hover:text-white focus:outline-none"
                >
                    <svg x-show="!open" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg x-cloak x-show="open" class="h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- منوی همبرگری موبایل: متناسب با اندازه محتوا بدون اسکرول داخلی (Blue Theme) --}}
    <div
        x-cloak
        x-show="open"
        x-collapse
        @click.outside="open = false"
        class="border-t border-gray-800/80 bg-gray-950/98 px-4 py-4 md:hidden shadow-2xl backdrop-blur-2xl"
    >
        <div class="mx-auto max-w-lg space-y-3.5">

            {{-- انتخاب سریع زبان در موبایل --}}
            @if(Route::has('locale.switch'))
                <div class="flex items-center justify-between rounded-xl border border-gray-800/70 bg-gray-900/40 p-2">
                    <span class="px-2 text-[11px] font-bold text-gray-400">
                        {{ __('System Language') }}
                    </span>
                    <div class="flex gap-1.5">
                        <a
                            href="{{ route('locale.switch', 'fa') }}"
                            class="rounded-lg px-2.5 py-1 text-xs font-semibold transition {{ $currentLocale === 'fa' ? 'bg-blue-600/20 text-blue-300 border border-blue-500/40' : 'bg-gray-950 text-gray-400 hover:text-white' }}"
                        >
                            فارسی
                        </a>
                        <a
                            href="{{ route('locale.switch', 'en') }}"
                            class="rounded-lg px-2.5 py-1 text-xs font-semibold transition {{ $currentLocale === 'en' ? 'bg-blue-600/20 text-blue-300 border border-blue-500/40' : 'bg-gray-950 text-gray-400 hover:text-white' }}"
                        >
                            English
                        </a>
                    </div>
                </div>
            @endif

            {{-- مشخصات کاربر و خروج در موبایل --}}
            @auth
                <div class="rounded-xl border border-blue-500/20 bg-gray-900/40 p-2.5">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 truncate">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-xs font-bold text-white">
                                {{ mb_substr(Auth::user()?->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="truncate text-xs font-bold text-white">{{ Auth::user()?->name }}</span>
                        </div>

                        <div class="flex items-center gap-1.5 shrink-0">
                            @if(Route::has('profile.edit'))
                                <a href="{{ route('profile.edit') }}" @click="open = false" class="rounded-lg border border-gray-800 bg-gray-900 px-2 py-1 text-[11px] text-gray-300 hover:text-blue-400">
                                    {{ __('Account Settings') }}
                                </a>
                            @endif

                            @if(Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit" class="rounded-lg border border-rose-500/20 bg-rose-500/10 px-2 py-1 text-[11px] font-semibold text-rose-400 hover:bg-rose-500 hover:text-white">
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endauth

            {{-- آیتم‌های اصلی منوی همبرگری (رنگ آبی خالص) --}}
            <div class="grid grid-cols-2 gap-2 text-xs font-semibold">
                {{-- خانه --}}
                <a
                    href="{{ url('/') }}"
                    @click="open = false"
                    class="flex items-center gap-2 rounded-xl border px-3 py-2.5 transition {{ request()->is('/') ? 'border-blue-500/40 bg-blue-600/15 text-blue-300 font-bold' : 'border-gray-800/80 bg-gray-900/40 text-gray-300 hover:bg-gray-900 hover:text-white' }}"
                >
                    <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>{{ __('Home') }}</span>
                </a>

                {{-- تعرفه‌ها --}}
                <a
                    href="{{ url('/shop') }}"
                    @click="open = false"
                    class="flex items-center gap-2 rounded-xl border px-3 py-2.5 transition {{ request()->is('shop*') ? 'border-blue-500/40 bg-blue-600/15 text-blue-300 font-bold' : 'border-gray-800/80 bg-gray-900/40 text-gray-300 hover:bg-gray-900 hover:text-white' }}"
                >
                    <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ __('Pricing') }}</span>
                </a>

                {{-- ویژگی‌های سیستم --}}
                <button
                    type="button"
                    @click="scrollToFeatures()"
                    class="flex items-center gap-2 rounded-xl border border-gray-800/80 bg-gray-900/40 px-3 py-2.5 text-right text-gray-300 hover:bg-gray-900 hover:text-white transition"
                >
                    <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    <span>{{ __('System Features') }}</span>
                </button>

                {{-- وبلاگ --}}
                <a
                    href="{{ Route::has('blog.index') ? route('blog.index') : url('/blog') }}"
                    @click="open = false"
                    class="flex items-center gap-2 rounded-xl border px-3 py-2.5 transition {{ request()->is('blog*') ? 'border-blue-500/40 bg-blue-600/15 text-blue-300 font-bold' : 'border-gray-800/80 bg-gray-900/40 text-gray-300 hover:bg-gray-900 hover:text-white' }}"
                >
                    <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <span>{{ __('Blog') }}</span>
                </a>

                {{-- پشتیبانی --}}
                <a
                    href="{{ url('/support') }}"
                    @click="open = false"
                    class="flex items-center gap-2 rounded-xl border px-3 py-2.5 transition {{ request()->is('support*') ? 'border-blue-500/40 bg-blue-600/15 text-blue-300 font-bold' : 'border-gray-800/80 bg-gray-900/40 text-gray-300 hover:bg-gray-900 hover:text-white' }}"
                >
                    <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 18v-6a9 9 0 0118 0v6M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3zM19 19a3 3 0 01-3 3h-3" />
                    </svg>
                    <span>{{ __('Support') }}</span>
                </a>

                {{-- درباره ما --}}
                <a
                    href="{{ url('/about') }}"
                    @click="open = false"
                    class="flex items-center gap-2 rounded-xl border px-3 py-2.5 transition {{ request()->is('about*') ? 'border-blue-500/40 bg-blue-600/15 text-blue-300 font-bold' : 'border-gray-800/80 bg-gray-900/40 text-gray-300 hover:bg-gray-900 hover:text-white' }}"
                >
                    <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ __('About Us') }}</span>
                </a>
            </div>

            {{-- فوتر قوانین و حریم خصوصی منوی موبایل --}}
            <div class="flex items-center justify-center gap-4 border-t border-gray-800/70 pt-2.5 text-[11px] text-gray-400">
                <a href="{{ url('/terms') }}" @click="open = false" class="hover:text-blue-300 transition">{{ __('Rules') }}</a>
                <span class="text-gray-700">•</span>
                <a href="{{ url('/privacy') }}" @click="open = false" class="hover:text-blue-300 transition">{{ __('privacy') }}</a>
            </div>

        </div>
    </div>

</nav>

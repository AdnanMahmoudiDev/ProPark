<nav x-data="{ 
    open: false, 
    profileDropdown: false,
    scrollToFeatures() {
        this.open = false;
        const target = document.getElementById('features');
        if (target) {
            const headerOffset = 80;
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
}" class="sticky top-0 z-50 border-b border-gray-800/80 bg-gray-950/80 backdrop-blur-xl transition-all duration-300">
    {{-- نوار نئونی باریک بالای هدر --}}
    <div class="h-[5px] w-full bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>

    {{-- کانتینر اصلی --}}
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- سمت راست: لوگو و لینک‌های دسکتاپ --}}
        <div class="flex items-center gap-6 lg:gap-8">
            <a href="{{ auth()->check() ? (Route::has('dashboard') ? route('dashboard') : url('/')) : url('/') }}" class="flex items-center gap-3 shrink-0 group">
                <div class="relative flex items-center justify-center">
                    <div class="absolute -inset-1 rounded-xl bg-blue-500/20 blur-sm group-hover:bg-blue-500/40 transition duration-300"></div>
                    <x-application-logo class="relative block h-10 w-10 fill-current text-blue-500 transition-transform duration-300 group-hover:scale-105" />
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-black tracking-tight text-white group-hover:text-blue-400 transition duration-200">AvaPark</span>
                    <span class="text-[13px] text-gray-200 font-mono -mt-1 hidden sm:inline-block">سیستم پارکینگ هوشمند</span>
                </div>
            </a>

            {{-- ناوبری دسکتاپ --}}
            <div class="hidden md:flex items-center gap-2">
                {{-- صفحه اصلی --}}
                <a 
                    href="{{ url('/') }}" 
                    class="relative group px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 flex items-center gap-2 border {{ request()->is('/') ? 'bg-gradient-to-r from-blue-600/15 via-blue-500/10 to-indigo-600/15 text-blue-400 border-blue-500/30 shadow-sm shadow-blue-950/40' : 'bg-gray-900/50 border-gray-800/80 text-gray-300 hover:text-white hover:border-gray-700 hover:bg-gray-900/90' }}"
                >
                    <svg class="w-4 h-4 transition-colors {{ request()->is('/') ? 'text-blue-400' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>صفحه اصلی</span>
                    @if(request()->is('/'))
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    @endif
                </a>

                {{-- تعرفه‌ها --}}
                <a 
                    href="{{ url('/shop') }}" 
                    class="relative group px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 flex items-center gap-2 border {{ request()->is('shop*') ? 'bg-gradient-to-r from-blue-600/15 via-blue-500/10 to-indigo-600/15 text-blue-400 border-blue-500/30 shadow-sm shadow-blue-950/40' : 'bg-gray-900/50 border-gray-800/80 text-gray-300 hover:text-white hover:border-gray-700 hover:bg-gray-900/90' }}"
                >
                    <svg class="w-4 h-4 transition-colors {{ request()->is('shop*') ? 'text-blue-400' : 'text-gray-400 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>تعرفه‌ها</span>
                    @if(request()->is('shop*'))
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    @endif
                </a>

                {{-- دکمه امکانات --}}
                <button 
                    type="button" 
                    @click="scrollToFeatures()" 
                    class="relative group px-4 py-2 rounded-xl text-sm font-medium bg-gray-900/50 border border-gray-800/80 text-gray-300 hover:text-white hover:border-gray-700 hover:bg-gray-900/90 transition-all duration-200 flex items-center gap-2 cursor-pointer"
                >
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-400 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>امکانات</span>
                </button>
            </div>
        </div>

        {{-- سمت چپ: ورود / ثبت‌نام / پروفایل --}}
        <div class="flex items-center gap-3">
            @guest
                <div class="hidden sm:flex items-center gap-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold text-gray-300 hover:text-white hover:bg-gray-900/80 rounded-xl transition duration-200">
                            ورود
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="relative inline-flex items-center justify-center px-4 py-2 text-xs font-semibold text-white transition-all duration-200 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 hover:from-blue-500 hover:to-indigo-500 overflow-hidden group">
                            <span class="relative z-10">ثبت‌نام</span>
                        </a>
                    @endif
                </div>
            @endguest

            @auth
                <div class="hidden sm:flex sm:items-center gap-3">
                    {{-- سبد خرید --}}
                    @if(Route::has('user.cart.index'))
                        <a
                            href="{{ route('user.cart.index') }}"
                            class="relative flex items-center justify-center w-10 h-10 rounded-xl border border-gray-800 bg-gray-900/60 text-gray-300 transition duration-200 hover:border-blue-500/40 hover:bg-blue-500/10 hover:text-blue-400"
                            title="سبد خرید"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            @if(isset($pendingCartCount) && $pendingCartCount > 0)
                                <span class="absolute -top-1 -right-1 flex h-5 w-5">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-5 w-5 bg-blue-600 text-[10px] font-bold text-white items-center justify-center shadow-md">
                                        {{ $pendingCartCount }}
                                    </span>
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- منوی کاربری --}}
                    <div class="relative" @click.outside="profileDropdown = false">
                        <button
                            type="button"
                            @click="profileDropdown = !profileDropdown"
                            class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/70 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-200 transition duration-200 hover:border-blue-500/40 hover:bg-gray-900 cursor-pointer"
                        >
                            <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 text-xs font-bold text-white uppercase shadow-sm">
                                {{ mb_substr(Auth::user()?->name ?? 'U', 0, 1) }}
                            </div>
                            <span class="max-w-[120px] truncate text-xs font-semibold">{{ Auth::user()?->name }}</span>
                            <svg class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': profileDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            x-cloak
                            x-show="profileDropdown"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute left-0 mt-2 w-64 origin-top-left rounded-2xl border border-gray-800 bg-gray-900/95 backdrop-blur-xl shadow-2xl shadow-black/80 z-50 overflow-hidden"
                        >
                            <div class="border-b border-gray-800 bg-gray-950/60 px-4 py-3">
                                <div class="text-sm font-semibold text-white">{{ Auth::user()?->name }}</div>
                                <div class="mt-0.5 text-xs text-gray-400 truncate font-mono">{{ Auth::user()?->email }}</div>
                            </div>

                            <div class="p-1.5 space-y-1">
                                @if(Route::has('user.cart.index'))
                                    <a
                                        href="{{ route('user.cart.index') }}"
                                        class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400"
                                    >
                                        <div class="flex items-center gap-2.5">
                                            <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <span>سبد خرید من</span>
                                        </div>
                                        @if(isset($pendingCartCount) && $pendingCartCount > 0)
                                            <span class="rounded-full bg-blue-600/30 border border-blue-500/40 px-2 py-0.5 text-[10px] font-bold text-blue-300">
                                                {{ $pendingCartCount }}
                                            </span>
                                        @endif
                                    </a>
                                @endif

                                @if(Route::has('dashboard'))
                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400"
                                    >
                                        <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                        <span>داشبورد کاربری</span>
                                    </a>
                                @endif

                                @if(Route::has('profile.edit'))
                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400"
                                    >
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>تنظیمات حساب</span>
                                    </a>
                                @endif

                                <div class="my-1 border-t border-gray-800"></div>

                                @if(Route::has('logout'))
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-full text-right flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-red-400 transition duration-150 hover:bg-red-500/10 hover:text-red-300 cursor-pointer"
                                        >
                                            <svg class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            <span>خروج از حساب</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            {{-- دکمه همبرگری موبایل --}}
            <div class="flex items-center sm:hidden">
                <button
                    type="button"
                    @click="open = !open"
                    class="inline-flex items-center justify-center w-10 h-10 rounded-xl border border-gray-800 bg-gray-900/80 text-gray-300 transition duration-150 hover:border-blue-500/30 hover:bg-gray-800 hover:text-white focus:outline-none cursor-pointer"
                >
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- منوی واکنش‌گرا (موبایل) --}}
    <div x-cloak x-show="open" class="border-t border-gray-800/80 bg-gray-950/95 backdrop-blur-xl sm:hidden">
        <div class="px-4 py-4 space-y-4">
            @auth
                <div class="flex items-center gap-3 rounded-2xl border border-gray-800 bg-gray-900/60 p-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-sm font-bold text-white uppercase">
                        {{ mb_substr(Auth::user()?->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="text-sm font-semibold text-white truncate">{{ Auth::user()?->name }}</div>
                        <div class="text-xs text-gray-400 truncate font-mono">{{ Auth::user()?->email }}</div>
                    </div>
                </div>

                <div class="space-y-1.5 pt-1">
                    @if(Route::has('user.cart.index'))
                        <a
                            href="{{ route('user.cart.index') }}"
                            class="flex items-center justify-between rounded-xl border border-blue-500/20 bg-blue-600/10 px-4 py-2.5 text-xs font-medium text-blue-300 transition duration-200"
                        >
                            <div class="flex items-center gap-2.5">
                                <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span>سبد خرید من</span>
                            </div>
                            @if(isset($pendingCartCount) && $pendingCartCount > 0)
                                <span class="rounded-full bg-blue-600 px-2 py-0.5 text-[10px] font-bold text-white">
                                    {{ $pendingCartCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    @if(Route::has('dashboard'))
                        <a
                            href="{{ route('dashboard') }}"
                            class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/40 px-4 py-2.5 text-xs font-medium text-gray-200 hover:border-blue-500/30"
                        >
                            <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                            <span>داشبورد کاربری</span>
                        </a>
                    @endif

                    @if(Route::has('profile.edit'))
                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/40 px-4 py-2.5 text-xs font-medium text-gray-200 hover:border-blue-500/30"
                        >
                            <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>تنظیمات حساب</span>
                        </a>
                    @endif

                    @if(Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}" class="pt-2">
                            @csrf
                            <button
                                type="submit"
                                class="w-full text-right flex items-center gap-2.5 rounded-xl border border-red-500/20 bg-red-500/5 px-4 py-2.5 text-xs font-medium text-red-400 hover:bg-red-500/10 cursor-pointer"
                            >
                                <svg class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>خروج از حساب</span>
                            </button>
                        </form>
                    @endif
                </div>
            @endauth

            @guest
                <div class="grid grid-cols-2 gap-2 pt-2 border-b border-gray-800/80 pb-3">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="flex items-center justify-center py-2.5 text-xs font-semibold text-gray-300 bg-gray-900 border border-gray-800 rounded-xl hover:text-white">
                            ورود
                        </a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="flex items-center justify-center py-2.5 text-xs font-semibold text-white bg-blue-600 rounded-xl shadow-lg shadow-blue-500/20 hover:bg-blue-500">
                            ثبت‌نام
                        </a>
                    @endif
                </div>
            @endguest

            {{-- لینک‌های ناوبری موبایل --}}
            <div class="space-y-1">
                <a href="{{ url('/') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium {{ request()->is('/') ? 'text-blue-400 bg-blue-500/10' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ request()->is('/') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>صفحه اصلی</span>
                    </div>
                    @if(request()->is('/'))
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    @endif
                </a>

                <a href="{{ url('/shop') }}" class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-medium {{ request()->is('shop*') ? 'text-blue-400 bg-blue-500/10' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 {{ request()->is('shop*') ? 'text-blue-400' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>تعرفه‌ها و پلن‌ها</span>
                    </div>
                    @if(request()->is('shop*'))
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    @endif
                </a>

                <button type="button" @click="scrollToFeatures()" class="w-full text-right flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-medium text-gray-300 hover:bg-white/5 hover:text-white cursor-pointer">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>امکانات سیستم</span>
                </button>
            </div>
        </div>
    </div>
</nav>

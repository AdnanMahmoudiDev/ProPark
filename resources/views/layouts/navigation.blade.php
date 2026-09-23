<nav
    role="navigation"
    aria-label="{{ __('AvaPark main navigation') }}"
    x-data="{
        open: false,
        profileDropdown: false,
        langDropdown: false,
        mobileLangDropdown: false,

        scrollToFeatures() {
            this.open = false;
            this.profileDropdown = false;
            this.langDropdown = false;
            this.mobileLangDropdown = false;

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
    }"
    class="sticky top-0 z-50 border-b border-gray-800/80 bg-gray-950"
>

    {{-- نوار نئونی گرادینت بالای هدر --}}
    <div class="h-[2px] w-full bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-75"></div>

    {{-- کانتینر اصلی هدر --}}
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

        {{-- بخش سمت راست: لوگو و پیوندهای منوی دسکتاپ --}}
        <div class="flex items-center gap-6 lg:gap-8">

            {{-- لوگوی سیستم --}}
            <a
                href="{{ auth()->check() ? (Route::has('dashboard') ? route('dashboard') : url('/')) : url('/') }}"
                class="group flex shrink-0 items-center gap-3 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-950"
                aria-label="{{ __('AvaPark home page') }}"
            >
                <div class="relative flex items-center justify-center">
                    <div class="absolute -inset-1 hidden rounded-xl bg-blue-500/20 blur-sm transition duration-300 group-hover:bg-blue-500/40 sm:block"></div>

                    <x-application-logo
                        class="relative block h-10 w-10 fill-current text-blue-500 transition-transform duration-200 group-hover:scale-105"
                    />
                </div>

                <div class="flex flex-col">
                    <span class="text-base font-black tracking-tight text-white transition-colors duration-200 group-hover:text-blue-400">
                        AvaPark
                    </span>

                    <span class="-mt-1 hidden font-mono text-[11px] text-gray-400 sm:inline-block">
                        {{ __('Intelligent Parking Management System') }}
                    </span>
                </div>
            </a>

            {{-- لینک‌های ناوبری در دسکتاپ --}}
            <div class="hidden items-center gap-5 md:flex lg:gap-6">

                <a
                    href="{{ url('/') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('/') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('/')) aria-current="page" @endif
                >
                    {{ __('Home') }}
                </a>

                <a
                    href="{{ url('/shop') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('shop*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
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
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('blog*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('blog*')) aria-current="page" @endif
                >
                    {{ __('Blog') }}
                </a>

                <a
                    href="{{ url('/about') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('about*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('about*')) aria-current="page" @endif
                >
                    {{ __('About Us') }}
                </a>

                <a
                    href="{{ url('/terms') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('terms*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('terms*')) aria-current="page" @endif
                >
                    {{ __('Rules') }}
                </a>
                <a
                    href="{{ url('/privacy') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('privacy*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('privacy') }}
                </a>
                <a
                    href="{{ url('/support') }}"
                    class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('support*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                    @if(request()->is('support*')) aria-current="page" @endif
                >
                    {{ __('Support') }}
                </a>
            </div>

        </div>

        {{-- بخش سمت چپ: احراز هویت دسکتاپ، تغییر زبان، سبد خرید و منوی همبرگری موبایل --}}
        <div class="flex items-center gap-3 sm:gap-4">

            {{-- منوی آبشاری تغییر زبان (دسکتاپ) --}}
            @php
                $currentLocale = app()->getLocale();
            @endphp

            @if(Route::has('locale.switch'))
                <div class="relative" @click.outside="langDropdown = false">
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

            {{-- حالت مهمان (Guest) در دسکتاپ --}}
            @guest
                <div class="hidden items-center gap-2.5 sm:flex">
                    @if(Route::has('login'))
                        <a
                            href="{{ route('login') }}"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-transparent px-3.5 py-2 text-xs font-semibold text-gray-300 transition duration-200 hover:border-gray-800 hover:bg-gray-900 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <span>{{ __('Login') }}</span>
                        </a>
                    @endif

                    @if(Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-blue-400/30 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-[length:200%_auto] px-4 py-2 text-xs font-bold text-white shadow-lg shadow-blue-500/25 transition-all duration-300 hover:bg-right hover:shadow-blue-500/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <span>{{ __('Start Free') }}</span>
                        </a>
                    @endif
                </div>
            @endguest

            {{-- حالت وارد شده (Auth) در دسکتاپ --}}
            @auth
                <div class="hidden items-center gap-4 sm:flex">

                    {{-- آیکون سبد خرید --}}
                    @if(Route::has('user.cart.index'))
                        <a
                            href="{{ route('user.cart.index') }}"
                            class="relative rounded-lg p-1.5 text-gray-400 transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                            title="{{ __('Cart') }}"
                            aria-label="{{ __('View shopping cart') }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>

                            @if(isset($pendingCartCount) && $pendingCartCount > 0)
                                <span class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full border border-gray-950 bg-blue-600 text-[9px] font-bold text-white shadow-md">
                                    {{ $pendingCartCount }}
                                </span>
                            @endif
                        </a>
                    @endif

                    {{-- منوی کشویی پروفایل دسکتاپ --}}
                    <div class="relative" @click.outside="profileDropdown = false">
                        <button
                            type="button"
                            @click="profileDropdown = !profileDropdown"
                            :aria-expanded="profileDropdown"
                            aria-haspopup="true"
                            class="flex cursor-pointer items-center gap-2 rounded-xl border border-gray-800 bg-gray-900/80 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-200 shadow-sm transition-colors duration-200 hover:border-blue-500/40 hover:bg-gray-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <div class="relative flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 text-xs font-bold uppercase text-white shadow-sm">
                                {{ mb_substr(Auth::user()?->name ?? 'U', 0, 1) }}
                                <span class="absolute -bottom-0.5 -right-0.5 h-2 w-2 rounded-full border border-gray-950 bg-emerald-500"></span>
                            </div>

                            <span class="max-w-[110px] truncate text-xs font-semibold">
                                {{ Auth::user()?->name }}
                            </span>

                            <svg
                                class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200"
                                :class="{ 'rotate-180': profileDropdown }"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- دراپ‌داون پروفایل --}}
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
                                @if(Route::has('user.cart.index'))
                                    <a
                                        href="{{ route('user.cart.index') }}"
                                        class="flex items-center justify-between rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                                    >
                                        <div class="flex items-center gap-2.5">
                                            <span>{{ __('My Cart') }}</span>
                                        </div>

                                        @if(isset($pendingCartCount) && $pendingCartCount > 0)
                                            <span class="rounded-full border border-blue-500/40 bg-blue-600/30 px-2 py-0.5 text-[10px] font-bold text-blue-300">
                                                {{ $pendingCartCount }}
                                            </span>
                                        @endif
                                    </a>
                                @endif

                                @if(Route::has('dashboard'))
                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                                    >
                                        <span>{{ __('Admin Panel') }}</span>
                                    </a>
                                @endif

                                @if(Route::has('profile.edit'))
                                    <a
                                        href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                                    >
                                        <span>{{ __('Account Settings') }}</span>
                                    </a>
                                @endif

                                <div class="my-1 border-t border-gray-800"></div>

                                @if(Route::has('logout'))
                                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="flex w-full cursor-pointer items-center gap-2.5 rounded-xl px-3 py-2 text-right text-xs font-semibold text-red-400 transition duration-150 hover:bg-red-500/10 hover:text-red-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                                        >
                                            <span>{{ __('Logout') }}</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endauth

            {{-- دکمه منوی همبرگری برای موبایل --}}
            <div class="flex items-center sm:hidden">
                <button
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open"
                    aria-controls="mobile-navigation"
                    aria-label="{{ __('Toggle mobile navigation menu') }}"
                    class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-gray-800 bg-gray-900 text-gray-300 transition duration-150 hover:border-blue-500/30 hover:bg-gray-800 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                >
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- محتوای پنل کشویی منوی موبایل --}}
    <div
        id="mobile-navigation"
        x-show="open"
        @click.outside="open = false"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="border-t border-gray-800 bg-gray-950 sm:hidden"
    >
        <div class="space-y-4 px-4 py-4">

            {{-- تغییر زبان آکاردئونی (موبایل) --}}
            @if(Route::has('locale.switch'))
                <div class="rounded-xl border border-gray-800 bg-gray-900/60 p-2">
                    <button
                        type="button"
                        @click="mobileLangDropdown = !mobileLangDropdown"
                        class="flex w-full cursor-pointer items-center justify-between px-2 py-1 text-xs font-semibold text-gray-200"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg class="h-4 w-4 shrink-0 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 21a9 9 0 100-18 9 9 0 000 18z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.6 9h16.8M3.6 15h16.8" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11.5 3a17 17 0 000 18M12.5 3a17 17 0 010 18" />
                            </svg>
                            <span>{{ __('System Language') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <span class="rounded-lg border border-blue-500/30 bg-blue-500/10 px-2 py-0.5 font-mono text-[10px] font-bold text-blue-400">
                                {{ $currentLocale === 'fa' ? 'فارسی' : 'EN' }}
                            </span>
                            <svg class="h-3.5 w-3.5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': mobileLangDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="mobileLangDropdown" x-cloak class="mt-2 space-y-1 border-t border-gray-800/80 pt-2">
                        <a
                            href="{{ route('locale.switch', 'fa') }}"
                            class="flex items-center justify-between rounded-lg px-3 py-2 text-xs font-medium {{ $currentLocale === 'fa' ? 'bg-blue-600/20 font-bold text-blue-400' : 'text-gray-300 hover:bg-gray-800/50' }}"
                        >
                            <span class="flex items-center gap-2"><span>🇮🇷</span> فارسی</span>
                            @if($currentLocale === 'fa')
                                <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </a>

                        <a
                            href="{{ route('locale.switch', 'en') }}"
                            class="flex items-center justify-between rounded-lg px-3 py-2 text-xs font-medium {{ $currentLocale === 'en' ? 'bg-blue-600/20 font-bold text-blue-400' : 'text-gray-300 hover:bg-gray-800/50' }}"
                        >
                            <span class="flex items-center gap-2"><span>EN</span> English</span>
                            @if($currentLocale === 'en')
                                <svg class="h-4 w-4 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>
            @endif

            {{-- اطلاعات کاربر در موبایل --}}
            @auth
                <div class="flex items-center gap-3 rounded-2xl border border-gray-800 bg-gray-900/90 p-3">
                    <div class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-sm font-bold uppercase text-white">
                        {{ mb_substr(Auth::user()?->name ?? 'U', 0, 1) }}
                        <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-gray-950 bg-emerald-500"></span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="truncate text-sm font-semibold text-white">
                            {{ Auth::user()?->name }}
                        </div>
                        <div class="truncate font-mono text-xs text-gray-400">
                            {{ Auth::user()?->email }}
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    @if(Route::has('user.cart.index'))
                        <a
                            href="{{ route('user.cart.index') }}"
                            class="flex items-center justify-between rounded-xl border border-blue-500/20 bg-blue-600/10 px-4 py-2.5 text-xs font-medium text-blue-300 transition duration-200 hover:bg-blue-600/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <div class="flex items-center gap-2.5">
                                <span>{{ __('My Cart') }}</span>
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
                            class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/60 px-4 py-2.5 text-xs font-medium text-gray-200 transition hover:border-blue-500/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <span>{{ __('Admin Panel') }}</span>
                        </a>
                    @endif

                    @if(Route::has('profile.edit'))
                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/60 px-4 py-2.5 text-xs font-medium text-gray-200 transition hover:border-blue-500/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <span>{{ __('Account Settings') }}</span>
                        </a>
                    @endif

                    @if(Route::has('logout'))
                        <form method="POST" action="{{ route('logout') }}" class="pt-2">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full cursor-pointer items-center gap-2.5 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-2.5 text-right text-xs font-semibold text-red-400 transition hover:bg-red-500/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                            >
                                <span>{{ __('Logout') }}</span>
                            </button>
                        </form>
                    @endif
                </div>
            @endauth

            {{-- مهمان در موبایل --}}
            @guest
                <div class="grid grid-cols-2 gap-2 border-b border-gray-800 pb-3 pt-2">
                    @if(Route::has('login'))
                        <a
                            href="{{ route('login') }}"
                            class="flex items-center justify-center gap-1.5 rounded-xl border border-gray-800 bg-gray-900 py-2.5 text-xs font-semibold text-gray-300 transition hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <span>{{ __('Login') }}</span>
                        </a>
                    @endif

                    @if(Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        >
                            <span>{{ __('Start Free') }}</span>
                        </a>
                    @endif
                </div>
            @endguest

            {{-- لینک‌های ناوبری منوی موبایل --}}
            <div class="space-y-1">
                <a
                    href="{{ url('/') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('/') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('Home') }}
                </a>

                <a
                    href="{{ url('/shop') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('shop*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('Pricing') }}
                </a>

                <button
                    type="button"
                    @click="scrollToFeatures()"
                    class="flex w-full cursor-pointer items-center rounded-lg px-3 py-2 text-right text-xs font-semibold text-gray-400 transition-colors duration-150 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                >
                    {{ __('System Features') }}
                </button>

                <a
                    href="{{ Route::has('blog.index') ? route('blog.index') : url('/blog') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('blog*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('Blog') }}
                </a>

                <a
                    href="{{ url('/about') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('about*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('About Us') }}
                </a>

                <a
                    href="{{ url('/terms') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('terms*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('Rules') }}
                </a>
                <a
                    href="{{ url('/privacy') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('privacy*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('privacy') }}
                </a>
                <a
                    href="{{ url('/support') }}"
                    @click="open = false"
                    class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('support*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                >
                    {{ __('Support') }}
                </a>
            </div>

        </div>
    </div>

</nav>

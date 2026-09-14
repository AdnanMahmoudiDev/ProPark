<nav
    role="navigation"
    aria-label="منوی اصلی سامانه AvaPark"
    x-data="{
        open: false,
        profileDropdown: false,


    scrollToFeatures() {
        this.open = false;
        this.profileDropdown = false;

        const target = document.getElementById('features');

        if (target) {
            const headerOffset = 80;
            const elementPosition = target.getBoundingClientRect().top;
            const offsetPosition =
                elementPosition + window.pageYOffset - headerOffset;

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


{{-- نوار نئونی بالای هدر --}}



<div class="h-[2px] w-full bg-gradient-to-r from-transparent via-blue-500 to-transparent opacity-75"></div>

{{-- کانتینر اصلی --}}
<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

    {{-- لوگو و لینک‌های دسکتاپ --}}
    <div class="flex items-center gap-6 lg:gap-8">

        {{-- لوگو --}}
        <a
            href="{{ auth()->check() ? (Route::has('dashboard') ? route('dashboard') : url('/')) : url('/') }}"
            class="group flex shrink-0 items-center gap-3 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-950"
            aria-label="صفحه اصلی AvaPark"
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
                    سیستم هوشمند مدیریت پارکینگ
                </span>
            </div>
        </a>

        {{-- ناوبری دسکتاپ --}}
        <div class="hidden items-center gap-5 md:flex lg:gap-6">

            {{-- صفحه اصلی --}}
            <a
                href="{{ url('/') }}"
                class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('/') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                @if(request()->is('/')) aria-current="page" @endif
            >
                صفحه اصلی
            </a>

            {{-- تعرفه‌ها --}}
            <a
                href="{{ url('/shop') }}"
                class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('shop*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                @if(request()->is('shop*')) aria-current="page" @endif
            >
                تعرفه‌ها
            </a>

            {{-- امکانات --}}
            <button
                type="button"
                @click="scrollToFeatures()"
                class="cursor-pointer rounded-md text-xs font-semibold text-gray-400 transition-colors duration-200 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
            >
                امکانات سیستم
            </button>

            {{-- درباره ما --}}
            <a
                href="{{ url('/about') }}"
                class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('about*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                @if(request()->is('about*')) aria-current="page" @endif
            >
                درباره ما
            </a>

            {{-- قوانین --}}
            <a
                href="{{ url('/terms') }}"
                class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('terms*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                @if(request()->is('terms*')) aria-current="page" @endif
            >
                قوانین
            </a>

            {{-- حریم خصوصی --}}
            <a
                href="{{ url('/privacy') }}"
                class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('privacy*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                @if(request()->is('privacy*')) aria-current="page" @endif
            >
                حریم خصوصی
            </a>

            {{-- پشتیبانی --}}
            <a
                href="{{ url('/support') }}"
                class="rounded-md text-xs font-semibold transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('support*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
                @if(request()->is('support*')) aria-current="page" @endif
            >
                پشتیبانی
            </a>
        </div>
    </div>

    {{-- ورود، ثبت‌نام، سبد خرید و پروفایل --}}
    <div class="flex items-center gap-4">

        @guest
            <div class="hidden items-center gap-2.5 sm:flex">

                @if(Route::has('login'))
                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-transparent px-3.5 py-2 text-xs font-semibold text-gray-300 transition duration-200 hover:border-gray-800 hover:bg-gray-900 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <svg
                            class="h-3.5 w-3.5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                            />
                        </svg>

                        <span>ورود</span>
                    </a>
                @endif

                @if(Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-blue-400/30 bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-[length:200%_auto] px-4 py-2 text-xs font-bold text-white shadow-lg shadow-blue-500/25 transition-all duration-300 hover:bg-right hover:shadow-blue-500/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <span class="flex items-center gap-1.5">
                            <svg
                                class="h-3.5 w-3.5 text-blue-200"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                                />
                            </svg>

                            <span>شروع رایگان</span>
                        </span>
                    </a>
                @endif

            </div>
        @endguest

        @auth
            <div class="hidden items-center gap-4 sm:flex">

                {{-- سبد خرید --}}
                @if(Route::has('user.cart.index'))
                    <a
                        href="{{ route('user.cart.index') }}"
                        class="relative rounded-lg p-1.5 text-gray-400 transition-colors duration-200 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                        title="سبد خرید"
                        aria-label="مشاهده سبد خرید"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                            />
                        </svg>

                        @if(isset($pendingCartCount) && $pendingCartCount > 0)
                            <span class="absolute -right-0.5 -top-0.5 flex h-4 w-4 items-center justify-center rounded-full border border-gray-950 bg-blue-600 text-[9px] font-bold text-white shadow-md">
                                {{ $pendingCartCount }}
                            </span>
                        @endif
                    </a>
                @endif

                {{-- منوی پروفایل --}}
                <div
                    class="relative"
                    @click.outside="profileDropdown = false"
                >
                    <button
                        type="button"
                        @click="profileDropdown = !profileDropdown"
                        :aria-expanded="profileDropdown"
                        aria-haspopup="true"
                        class="flex cursor-pointer items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/80 py-1.5 pl-3 pr-2 text-sm font-medium text-gray-200 shadow-sm transition-colors duration-200 hover:border-blue-500/40 hover:bg-gray-900 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
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
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>

                    {{-- Dropdown پروفایل --}}
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
                                    کاربر
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
                                        <svg
                                            class="h-4 w-4 text-blue-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                            />
                                        </svg>

                                        <span>سبد خرید من</span>
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
                                    <svg
                                        class="h-4 w-4 text-blue-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2-2v-2z"
                                        />
                                    </svg>

                                    <span>پنل مدیریت</span>
                                </a>
                            @endif

                            @if(Route::has('profile.edit'))
                                <a
                                    href="{{ route('profile.edit') }}"
                                    class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-medium text-gray-300 transition duration-150 hover:bg-blue-500/10 hover:text-blue-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                                >
                                    <svg
                                        class="h-4 w-4 text-gray-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31.826-2.37-2.37a1.724 1.724 0 001.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>

                                    <span>تنظیمات حساب کاربری</span>
                                </a>
                            @endif

                            <div class="my-1 border-t border-gray-800"></div>

                            @if(Route::has('logout'))
                                <form
                                    method="POST"
                                    action="{{ route('logout') }}"
                                    class="m-0"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="flex w-full cursor-pointer items-center gap-2.5 rounded-xl px-3 py-2 text-right text-xs font-semibold text-red-400 transition duration-150 hover:bg-red-500/10 hover:text-red-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                                    >
                                        <svg
                                            class="h-4 w-4 text-red-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                            />
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

        {{-- دکمه منوی موبایل --}}
        <div class="flex items-center sm:hidden">
            <button
                type="button"
                @click="open = !open"
                :aria-expanded="open"
                aria-controls="mobile-navigation"
                aria-label="تغییر وضعیت منوی موبایل"
                class="inline-flex h-10 w-10 cursor-pointer items-center justify-center rounded-xl border border-gray-800 bg-gray-900 text-gray-300 transition duration-150 hover:border-blue-500/30 hover:bg-gray-800 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
            >
                <svg
                    class="h-5 w-5"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
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

{{-- منوی موبایل --}}
<div
    id="mobile-navigation"
    x-cloak
    x-show="open"
    @click.outside="open = false"
    class="border-t border-gray-800 bg-gray-950 sm:hidden"
>
    <div class="space-y-4 px-4 py-4">

        @auth
            {{-- اطلاعات کاربر --}}
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

            {{-- لینک‌های حساب کاربری --}}
            <div class="space-y-1.5 pt-1">

                @if(Route::has('user.cart.index'))
                    <a
                        href="{{ route('user.cart.index') }}"
                        class="flex items-center justify-between rounded-xl border border-blue-500/20 bg-blue-600/10 px-4 py-2.5 text-xs font-medium text-blue-300 transition duration-200 hover:bg-blue-600/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <div class="flex items-center gap-2.5">
                            <svg
                                class="h-4 w-4 text-blue-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                />
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
                        class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/60 px-4 py-2.5 text-xs font-medium text-gray-200 transition hover:border-blue-500/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <svg
                            class="h-4 w-4 text-blue-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2-2v-2z"
                            />
                        </svg>

                        <span>پنل مدیریت</span>
                    </a>
                @endif

                @if(Route::has('profile.edit'))
                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex items-center gap-2.5 rounded-xl border border-gray-800 bg-gray-900/60 px-4 py-2.5 text-xs font-medium text-gray-200 transition hover:border-blue-500/30 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <svg
                            class="h-4 w-4 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543-.94-3.31.826-2.37-2.37a1.724 1.724 0 001.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-2.37 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                            />
                        </svg>

                        <span>تنظیمات حساب</span>
                    </a>
                @endif

                @if(Route::has('logout'))
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="pt-2"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full cursor-pointer items-center gap-2.5 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-2.5 text-right text-xs font-semibold text-red-400 transition hover:bg-red-500/20 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500"
                        >
                            <svg
                                class="h-4 w-4 text-red-400"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                />
                            </svg>

                            <span>خروج از حساب</span>
                        </button>
                    </form>
                @endif

            </div>
        @endauth

        @guest
            {{-- ورود و ثبت‌نام موبایل --}}
            <div class="grid grid-cols-2 gap-2 border-b border-gray-800 pb-3 pt-2">

                @if(Route::has('login'))
                    <a
                        href="{{ route('login') }}"
                        class="flex items-center justify-center gap-1.5 rounded-xl border border-gray-800 bg-gray-900 py-2.5 text-xs font-semibold text-gray-300 transition hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <svg
                            class="h-3.5 w-3.5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                            />
                        </svg>

                        <span>ورود</span>
                    </a>
                @endif

                @if(Route::has('register'))
                    <a
                        href="{{ route('register') }}"
                        class="flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-500/20 transition hover:bg-blue-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
                    >
                        <svg
                            class="h-3.5 w-3.5 text-blue-200"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"
                            />
                        </svg>

                        <span>ثبت‌نام</span>
                    </a>
                @endif

            </div>
        @endguest

        {{-- لینک‌های اصلی موبایل --}}
        <div class="space-y-1">

            <a
                href="{{ url('/') }}"
                @click="open = false"
                class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('/') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
            >
                صفحه اصلی
            </a>

            <a
                href="{{ url('/shop') }}"
                @click="open = false"
                class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('shop*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
            >
                تعرفه‌ها
            </a>

            <button
                type="button"
                @click="scrollToFeatures()"
                class="flex w-full cursor-pointer items-center rounded-lg px-3 py-2 text-right text-xs font-semibold text-gray-400 transition-colors duration-150 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500"
            >
                امکانات سیستم
            </button>

            <a
                href="{{ url('/about') }}"
                @click="open = false"
                class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('about*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
            >
                درباره ما
            </a>

            <a
                href="{{ url('/terms') }}"
                @click="open = false"
                class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('terms*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
            >
                قوانین
            </a>

            <a
                href="{{ url('/privacy') }}"
                @click="open = false"
                class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('privacy*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
            >
                حریم خصوصی
            </a>

            <a
                href="{{ url('/support') }}"
                @click="open = false"
                class="flex items-center rounded-lg px-3 py-2 text-xs font-semibold transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 {{ request()->is('support*') ? 'text-blue-400' : 'text-gray-400 hover:text-white' }}"
            >
                پشتیبانی
            </a>

        </div>
    </div>
</div>


</nav>

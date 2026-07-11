<nav x-data="{ open: false }" class="sticky top-0 z-50 border-b border-gray-800 bg-gray-950/70 backdrop-blur-md">
    {{-- کانتینر اصلی --}}
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-6 py-1">

        {{-- لوگو و برند --}}
        <div class="flex items-center">
            <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex items-center gap-3 shrink-0">
                <x-application-logo class="block h-16 w-16 fill-current text-violet-500" />
                <span class="text-xl font-bold tracking-tight text-violet-400">ProPark</span>
            </a>
        </div>

        {{-- بخش مهمان --}}
        @guest
            <div class="flex items-center gap-3">
                <a
                    href="{{ route('login') }}"
                    class="rounded-xl px-4 py-2 text-sm font-medium text-gray-300 transition duration-200 hover:bg-gray-900 hover:text-violet-400"
                >
                    ورود
                </a>

                <a
                    href="{{ route('register') }}"
                    class="rounded-xl bg-violet-600 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-violet-900/40 transition duration-200 hover:bg-violet-500 hover:shadow-violet-800/50"
                >
                    ثبت‌نام
                </a>
            </div>
        @endguest

        {{-- بخش احراز هویت شده دسکتاپ --}}
        @auth
            <div class="hidden sm:flex sm:items-center gap-4">

                {{-- آیکون سریع سبد خرید --}}
                <a
                    href="{{ route('user.cart.index') }}"
                    class="relative rounded-xl border border-gray-800/60 p-2 text-gray-400 transition duration-200 hover:border-violet-500/30 hover:bg-gray-900 hover:text-violet-400"
                    title="سبد خرید"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>

                    @if(isset($pendingCartCount) && $pendingCartCount > 0)
                        <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-violet-600 text-[10px] font-bold text-white shadow-lg">
                            {{ $pendingCartCount }}
                        </span>
                    @endif
                </a>

                {{-- دراپ‌داون پروفایل کاربر --}}
                <x-dropdown align="left" width="64">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 rounded-xl border border-gray-700 bg-gray-900 px-4 py-2 text-sm font-medium text-gray-200 transition duration-200 hover:border-violet-500/40 hover:bg-gray-800 hover:text-white"
                        >
                            <span>{{ Auth::user()?->name }}</span>
                            <svg class="h-4 w-4 fill-current text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900 shadow-2xl shadow-black/30">
                            {{-- اطلاعات کاربر --}}
                            <div class="border-b border-gray-800 bg-gray-950/40 px-4 py-3">
                                <div class="text-sm font-semibold text-white">{{ Auth::user()?->name }}</div>
                                <div class="mt-1 text-xs text-gray-400">{{ Auth::user()?->email }}</div>
                            </div>

                            {{-- لینک‌ها --}}
                            <div class="space-y-1 p-2">

                                {{-- لینک سبد خرید --}}
                                <x-dropdown-link
                                    :href="route('user.cart.index')"
                                    class="flex items-center justify-between rounded-xl text-violet-300 transition duration-200 hover:bg-violet-500/10 hover:text-violet-200"
                                >
                                    <div class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span>{{ __('سبد خرید من') }}</span>
                                    </div>

                                    @if(isset($pendingCartCount) && $pendingCartCount > 0)
                                        <span class="flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-violet-600 px-1 text-[10px] font-bold text-white">
                                            {{ $pendingCartCount }}
                                        </span>
                                    @endif
                                </x-dropdown-link>

                                {{-- داشبورد --}}
                                <x-dropdown-link
                                    :href="route('dashboard')"
                                    class="flex items-center gap-2 rounded-xl text-indigo-300 transition duration-200 hover:bg-indigo-500/10 hover:text-indigo-200"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    <span>{{ __('داشبورد کاربری') }}</span>
                                </x-dropdown-link>

                                {{-- پروفایل --}}
                                <x-dropdown-link
                                    :href="route('profile.edit')"
                                    class="flex items-center gap-2 rounded-xl text-gray-300 transition duration-200 hover:bg-violet-500/10 hover:text-white"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ __('ویرایش حساب کاربری') }}</span>
                                </x-dropdown-link>

                                {{-- خروج --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link
                                        :href="route('logout')"
                                        class="flex items-center gap-2 rounded-xl text-red-400 transition duration-200 hover:bg-red-950/40 hover:text-red-300"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>{{ __('خروج از حساب کاربری') }}</span>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- دکمه همبرگری موبایل --}}
            <div class="flex items-center sm:hidden">
                <button
                    @click="open = !open"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-800 bg-gray-900 p-2 text-gray-300 transition duration-150 hover:border-violet-500/30 hover:bg-gray-800 hover:text-white focus:outline-none"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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
        @endauth
    </div>

    {{-- منوی موبایل --}}
    @auth
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-gray-800 bg-gray-950 sm:hidden">
            <div class="px-4 py-4">
                {{-- اطلاعات کاربر --}}
                <div class="mb-4 rounded-2xl border border-gray-800 bg-gray-900/60 px-4 py-3">
                    <div class="text-sm font-semibold text-white">{{ Auth::user()?->name }}</div>
                    <div class="mt-1 text-xs text-gray-400">{{ Auth::user()?->email }}</div>
                </div>

                {{-- لینک‌ها --}}
                <div class="space-y-2.5">
                    {{-- سبد خرید --}}
                    <a
                        href="{{ route('user.cart.index') }}"
                        class="flex items-center justify-between rounded-xl border border-violet-500/20 bg-violet-600/10 px-4 py-3 text-sm font-medium text-violet-300 transition duration-200 hover:bg-violet-600/20 hover:text-white"
                    >
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span>{{ __('سبد خرید من') }}</span>
                        </div>

                        @if(isset($pendingCartCount) && $pendingCartCount > 0)
                            <span class="flex h-5 min-w-[1.25rem] items-center justify-center rounded-full bg-violet-600 px-1 text-[10px] font-bold text-white">
                                {{ $pendingCartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- داشبورد --}}
                    <a
                        href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 rounded-xl border border-indigo-500/20 bg-indigo-500/10 px-4 py-3 text-sm font-medium text-indigo-300 transition duration-200 hover:bg-indigo-500/20 hover:text-indigo-200"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        <span>{{ __('داشبورد کاربری') }}</span>
                    </a>

                    {{-- پروفایل --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 rounded-xl border border-gray-800 bg-transparent px-4 py-3 text-sm font-medium text-gray-300 transition duration-200 hover:border-violet-500/20 hover:bg-violet-500/10 hover:text-white"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>{{ __('ویرایش حساب کاربری') }}</span>
                    </a>

                    {{-- خروج --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a
                            href="{{ route('logout') }}"
                            class="flex items-center gap-3 rounded-xl border border-red-500/10 bg-transparent px-4 py-3 text-sm font-medium text-red-400 transition duration-200 hover:bg-red-950/40 hover:text-red-300"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>{{ __('خروج از حساب کاربری') }}</span>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</nav>

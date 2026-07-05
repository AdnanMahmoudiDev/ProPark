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
        <div class="flex items-center gap-3">
            @guest
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
            @endguest
        </div>

        {{-- منوی کاربر در دسکتاپ  --}}
        @auth
        <div class="hidden sm:flex sm:items-center">
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
                        {{-- اطلاعات کاربر جاری --}}
                        <div class="border-b border-gray-800 px-4 py-3 bg-gray-950/40">
                            <div class="text-sm font-semibold text-white">{{ Auth::user()?->name }}</div>
                            <div class="mt-1 text-xs text-gray-400">{{ Auth::user()?->email }}</div>
                        </div>

                        {{-- لینک‌های عملیاتی --}}
                        <div class="p-2 space-y-1">
                            <x-dropdown-link
                                :href="route('dashboard')"
                                class="rounded-xl text-indigo-300 transition duration-200 hover:bg-indigo-500/10 hover:text-indigo-200"
                            >
                                {{ __('داشبورد کاربری') }}
                            </x-dropdown-link>

                            <x-dropdown-link
                                :href="route('profile.edit')"
                                class="rounded-xl text-gray-300 transition duration-200 hover:bg-violet-500/10 hover:text-white"
                            >
                                {{ __('ویرایش حساب کاربری') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link
                                    :href="route('logout')"
                                    class="rounded-xl text-red-400 transition duration-200 hover:bg-red-950/40 hover:text-red-300"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                >
                                    {{ __('خروج از حساب کاربری') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </div>
                </x-slot>
            </x-dropdown>
        </div>
        @endauth

        {{-- دکمه همبرگری موبایل --}}
        @auth
        <div class="flex items-center sm:hidden">
            <button
                @click="open = ! open"
                class="inline-flex items-center justify-center rounded-xl border border-gray-800 bg-gray-900 p-2 text-gray-300 transition duration-150 hover:border-violet-500/30 hover:bg-gray-800 hover:text-white focus:outline-none"
            >
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        @endauth
    </div>

    {{-- منوی بازشوی موبایل  --}}
    @auth
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-gray-800 bg-gray-950 sm:hidden">
        <div class="px-4 py-4">
            {{-- کارت مشخصات کاربر --}}
            <div class="mb-4 rounded-2xl border border-gray-800 bg-gray-900/60 px-4 py-3">
                <div class="text-sm font-semibold text-white">{{ Auth::user()?->name }}</div>
                <div class="mt-1 text-xs text-gray-400">{{ Auth::user()?->email }}</div>
            </div>

            {{-- لینک‌های دسترسی سریع --}}
            <div class="space-y-2.5">
                <a
                    href="{{ route('dashboard') }}"
                    class="block rounded-xl border border-indigo-500/20 bg-indigo-500/10 px-4 py-3 text-sm font-medium text-indigo-300 transition duration-200 hover:bg-indigo-500/20 hover:text-indigo-200"
                >
                    {{ __('داشبورد کاربری') }}
                </a>

                <a
                    href="{{ route('profile.edit') }}"
                    class="block rounded-xl border border-gray-800 bg-transparent px-4 py-3 text-sm font-medium text-gray-300 transition duration-200 hover:border-violet-500/20 hover:bg-violet-500/10 hover:text-white"
                >
                    {{ __('ویرایش حساب کاربری') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a
                        href="{{ route('logout') }}"
                        class="block rounded-xl border border-red-500/10 bg-transparent px-4 py-3 text-sm font-medium text-red-400 transition duration-200 hover:bg-red-950/40 hover:text-red-300"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        {{ __('خروج از حساب کاربری') }}
                    </a>
                </form>
            </div>
        </div>
    </div>
    @endauth
</nav>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ProPark') }} | Admin</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-100" x-data="{ mobileMenu: false }">
    <div class="min-h-screen bg-gradient-to-br from-blue-950 via-gray-950 to-gray-950">

        {{-- نوبار --}}
        <nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    {{-- لوگو و منوی دسکتاپ --}}
                    <div class="flex items-center gap-8">

                        {{-- لوگو --}}
                        <a href="{{ route('admin.dashboard') }}"
                           class="text-lg font-bold text-white tracking-tight">
                            ProPark <span class="text-blue-400">Admin</span>
                        </a>

                        {{-- منوی دسکتاپ --}}
                        <div class="hidden md:flex items-center gap-6 text-sm font-medium text-gray-400">

                            <a href="{{ route('admin.dashboard') }}" class="hover:text-white transition">
                                داشبورد
                            </a>

                            <a href="{{ route('admin.users.index') }}" class="hover:text-white transition">
                                کاربران
                            </a>

                            <a href="{{ route('admin.subscriptions.index') }}" class="hover:text-white transition">
                                اشتراک‌ها
                            </a>

                            <a href="{{ route('admin.store.index') }}" class="hover:text-white transition">
                                فروشگاه
                            </a>

                            {{-- لاگ اوت دسکتاپ --}}
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button
                                    type="submit"
                                    onclick="return confirm('آیا مطمئن هستید که می‌خواهید از حساب کاربری خارج شوید؟')"
                                    class="text-red-300 hover:text-red-200 transition"
                                >
                                    خروج از حساب کاربری
                                </button>
                            </form>

                        </div>
                    </div>

                   
                    <div class="flex items-center gap-3">

                        {{-- ساخت لایسنس --}}
                        <a href="{{ route('admin.licenses.create') }}"
                           class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl text-xs font-bold transition">
                            ایجاد لایسنس جدید
                        </a>

                        {{-- منوی همبرگری موبایل --}}
                        <button
                            type="button"
                            class="md:hidden flex items-center justify-center w-10 h-10 rounded-xl bg-gray-800 border border-gray-700 text-gray-300 hover:bg-gray-700 transition"
                            @click="mobileMenu = true"
                            aria-label="باز کردن منوی موبایل"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                    </div>
                </div>
            </div>
        </nav>

        
        <div
            x-cloak
            x-show="mobileMenu"
            @click="mobileMenu = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/50 z-40"
        ></div>

        {{-- منوی کشویی موبایل --}}
        <div
            x-cloak
            x-show="mobileMenu"
            @click.away="mobileMenu = false"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="fixed inset-y-0 right-0 w-72 bg-gray-900 border-l border-gray-800 shadow-xl z-50"
        >
            <div class="p-5">

                {{-- هدر --}}
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold text-white">
                        منوی ادمین
                    </h2>

                    <button
                        type="button"
                        class="text-gray-400 hover:text-white transition"
                        @click="mobileMenu = false"
                        aria-label="بستن منوی موبایل"
                    >
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- لینک های نویگیشن برای موبایل --}}
                <nav class="space-y-3 text-sm font-medium">

                    <a href="{{ route('admin.dashboard') }}"
                       class="block px-4 py-3 rounded-xl bg-gray-800/50 hover:bg-gray-700 text-gray-200 transition">
                        داشبورد
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block px-4 py-3 rounded-xl bg-gray-800/50 hover:bg-gray-700 text-gray-200 transition">
                        کاربران
                    </a>

                    <a href="{{ route('admin.subscriptions.index') }}"
                       class="block px-4 py-3 rounded-xl bg-gray-800/50 hover:bg-gray-700 text-gray-200 transition">
                        اشتراک‌ها
                    </a>

                    <a href="{{ route('admin.store.index') }}"
                       class="block px-4 py-3 rounded-xl bg-gray-800/50 hover:bg-gray-700 text-gray-200 transition">
                        فروشگاه
                    </a>

                    <a href="{{ route('admin.licenses.create') }}"
                       class="block px-4 py-3 rounded-xl bg-blue-700/30 text-blue-300 hover:bg-blue-700/40 hover:text-white transition">
                        ایجاد لایسنس جدید
                    </a>

                    {{-- لاگ اوت موبایل --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            onclick="return confirm('آیا مطمئن هستید که می‌خواهید از حساب کاربری خارج شوید؟')"
                            class="w-full text-right block px-4 py-3 rounded-xl bg-red-700/20 text-red-300 hover:bg-red-700/30 hover:text-white transition"
                        >
                            خروج از حساب کاربری
                        </button>
                    </form>

                </nav>

            </div>
        </div>

        {{-- محتوای اصلی --}}
        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>

    </div>
</body>
</html>

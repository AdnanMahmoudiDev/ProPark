{{-- نوار ناوبری دسکتاپ و هدر --}}
<nav class="border-b border-gray-800 bg-gray-900/50 backdrop-blur-sm">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- لوگو و منوی دسکتاپ --}}
            <div class="flex items-center gap-8">

                {{-- لوگو --}}
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="text-lg font-bold tracking-tight text-white"
                >
                    AvaPark
                    <span class="text-blue-400">Admin</span>
                </a>

                {{-- منوی دسکتاپ --}}
                <div class="hidden items-center gap-6 text-sm font-medium text-gray-400 md:flex">

                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="transition {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        داشبورد
                    </a>

                    <a
                        href="{{ route('admin.users.index') }}"
                        class="transition {{ request()->routeIs('admin.users.*') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        کاربران
                    </a>

                    <a
                        href="{{ route('admin.subscriptions.index') }}"
                        class="transition {{ request()->routeIs('admin.subscriptions.*') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        اشتراک‌ها
                    </a>

                    <a
                        href="{{ route('admin.store.index') }}"
                        class="transition {{ request()->routeIs('admin.store.*') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        فروشگاه
                    </a>

                    {{-- لینک مدیریت مقالات (وبلاگ) --}}
                    <a
                        href="{{ route('admin.posts.index') }}"
                        class="transition {{ request()->routeIs('admin.posts.*') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        مقالات
                    </a>
                    
                    <a
                        href="{{ route('admin.database.index') }}"
                        class="transition {{ request()->routeIs('admin.database.*') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        دیتابیس
                    </a>

                    {{-- لینک مانیتورینگ سایت و سرور --}}
                    <a
                        href="{{ route('admin.monitoring.index') }}"
                        class="transition {{ request()->routeIs('admin.monitoring.*') ? 'text-blue-400' : 'hover:text-white' }}"
                    >
                        مانیتورینگ سایت و سرور
                    </a>

                    {{-- خروج از حساب در دسکتاپ --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        class="m-0"
                    >
                        @csrf

                        <button
                            type="submit"
                            onclick="return confirm('آیا مطمئن هستید که می‌خواهید از حساب کاربری خارج شوید؟')"
                            class="cursor-pointer text-red-300 transition hover:text-red-200"
                        >
                            خروج از حساب کاربری
                        </button>
                    </form>

                </div>
            </div>

            {{-- اکشن‌های سمت چپ نوار --}}
            <div class="flex items-center gap-3">

                {{-- ساخت لایسنس --}}
                <a
                    href="{{ route('admin.licenses.create') }}"
                    class="rounded-xl bg-blue-600 px-3 py-2 text-[11px] font-bold text-white transition hover:bg-blue-500 sm:px-4 sm:text-xs"
                >
                    ایجاد لایسنس جدید
                </a>

                {{-- دکمه منوی موبایل --}}
                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-700 bg-gray-800 text-gray-300 transition hover:bg-gray-700 md:hidden"
                    @click="mobileMenu = true"
                    aria-label="باز کردن منوی موبایل"
                    :aria-expanded="mobileMenu.toString()"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>

            </div>
        </div>
    </div>
</nav>

{{-- لایه تیره پشت منوی موبایل --}}
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
    class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm"
    aria-hidden="true"
></div>

{{-- منوی کشویی موبایل --}}
<aside
    x-cloak
    x-show="mobileMenu"
    @click.outside="mobileMenu = false"
    x-transition:enter="transform transition ease-out duration-300"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed inset-y-0 right-0 z-50 w-72 border-l border-gray-800 bg-gray-900 shadow-2xl shadow-black/50"
    aria-label="منوی مدیریت"
>
    <div class="p-5">

        {{-- هدر منوی موبایل --}}
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-lg font-bold text-white">
                منوی ادمین
            </h2>

            <button
                type="button"
                class="cursor-pointer text-gray-400 transition hover:text-white"
                @click="mobileMenu = false"
                aria-label="بستن منوی موبایل"
            >
                <svg
                    class="h-6 w-6"
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

        {{-- لینک‌های موبایل --}}
        <nav class="space-y-3 text-sm font-medium">

            <a
                href="{{ route('admin.dashboard') }}"
                class="block rounded-xl {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                داشبورد
            </a>

            <a
                href="{{ route('admin.users.index') }}"
                class="block rounded-xl {{ request()->routeIs('admin.users.*') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                کاربران
            </a>

            <a
                href="{{ route('admin.subscriptions.index') }}"
                class="block rounded-xl {{ request()->routeIs('admin.subscriptions.*') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                اشتراک‌ها
            </a>

            <a
                href="{{ route('admin.store.index') }}"
                class="block rounded-xl {{ request()->routeIs('admin.store.*') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                فروشگاه
            </a>

            {{-- لینک مقالات در موبایل --}}
            <a
                href="{{ route('admin.posts.index') }}"
                class="block rounded-xl {{ request()->routeIs('admin.posts.*') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                مقالات
            </a>

            <a
                href="{{ route('admin.database.index') }}"
                class="block rounded-xl {{ request()->routeIs('admin.database.*') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                دیتابیس
            </a>

            {{-- لینک مانیتورینگ سایت و سرور در موبایل --}}
            <a
                href="{{ route('admin.monitoring.index') }}"
                class="block rounded-xl {{ request()->routeIs('admin.monitoring.*') ? 'bg-blue-600/30 text-blue-300' : 'bg-gray-800/50 text-gray-200' }} px-4 py-3 transition hover:bg-gray-700"
            >
                مانیتورینگ سایت و سرور
            </a>

            <a
                href="{{ route('admin.licenses.create') }}"
                class="block rounded-xl bg-blue-700/30 px-4 py-3 text-blue-300 transition hover:bg-blue-700/40 hover:text-white"
            >
                ایجاد لایسنس جدید
            </a>

            {{-- خروج از حساب در موبایل --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    onclick="return confirm('آیا مطمئن هستید که می‌خواهید از حساب کاربری خارج شوید؟')"
                    class="block w-full cursor-pointer rounded-xl bg-red-700/20 px-4 py-3 text-right text-red-300 transition hover:bg-red-700/30 hover:text-white"
                >
                    خروج از حساب کاربری
                </button>
            </form>

        </nav>
    </div>
</aside>

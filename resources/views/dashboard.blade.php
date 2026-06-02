<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                داشبورد
                <br>
            <span class="text-sm text-gray-500 dark:text-gray-400">
                
                <span> تاریح امروز:</span>  {{ jdate(now())->format('Y/m/d ') }}
            </span>
            </h2>

        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome / Status --}}
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                خوش آمدی، {{ auth()->user()->name }}!
                            </p>
                            <div class="text-xs px-3 py-1 rounded-full
                                    bg-emerald-50 text-emerald-700
                                    dark:bg-emerald-900/30 dark:text-emerald-300">
                                وضعیت حساب: فعال
                            </div>
                        </div>

                            <div class="text-xs px-3 py-1 rounded-full
                                        bg-emerald-50 text-emerald-700
                                        dark:bg-emerald-900/30 dark:text-emerald-300">
                            Logged in
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                        <p class="text-sm text-gray-700 dark:text-gray-200">
                        پنل تست ProPark
                        </p>
                    </div>
                </div>
            </div>

            {{-- Quick stats (static placeholders) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400">اشتراک فعال</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">—</p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">به زودی متصل به دیتابیس</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400">تعداد لایسنس‌ها</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">—</p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Placeholder</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400">درخواست‌های API امروز</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">—</p>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Placeholder</p>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-500 dark:text-gray-400">نقش کاربر</p>
                    <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                        {{ auth()->user()->role ?? '—' }}
                    </p>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 lg:col-span-2">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        دسترسی سریع
                    </h3>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <a href="#"
                           class="block rounded-lg border border-gray-200 dark:border-gray-700 p-4
                                  hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">خرید اشتراک</p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">به زودی</p>
                        </a>

                        <a href="#"
                           class="block rounded-lg border border-gray-200 dark:border-gray-700 p-4
                                  hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">لایسنس‌های من</p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">به زودی</p>
                        </a>

                        <a href="#"
                           class="block rounded-lg border border-gray-200 dark:border-gray-700 p-4
                                  hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">مستندات API</p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">به زودی</p>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="block rounded-lg border border-gray-200 dark:border-gray-700 p-4
                                  hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                            <p class="font-medium text-gray-900 dark:text-gray-100">ویرایش پروفایل</p>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">اطلاعات حساب کاربری</p>
                        </a>
                    </div>
                </div>

                {{-- Account info --}}
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        اطلاعات حساب
                    </h3>

                    <dl class="mt-4 space-y-3">
                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">ایمیل</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100 break-all">
                                {{ auth()->user()->email }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">شماره موبایل</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">
                                {{ auth()->user()->phone_number ?? 'ثبت نشده' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500 dark:text-gray-400">تاریخ عضویت در سایت</dt>
                            <dd class="text-sm text-gray-900 dark:text-gray-100">
                                {{ jdate(auth()->user()->created_at)->format('Y/m/d') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

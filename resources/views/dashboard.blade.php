<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-white leading-tight">
                داشبورد
                <br>
                <span class="text-xs text-gray-500 flex items-center gap-2 mt-1">
                    <span class="w-1.5 h-1.5 bg-violet-500 rounded-full animate-pulse"></span>
                    تاریخ امروز: {{ jdate(now())->format('Y/m/d ') }}
                </span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- خوش امد گویی به کاربر --}}
            <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6 shadow-2xl">
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            
                            <p class="text-lg font-bold text-white">
                                خوش آمدی، {{ auth()->user()->name }}!
                            </p>
                        </div>

                        <div class="text-xs px-3 py-1 rounded-full bg-violet-900/40 text-violet-300 border border-violet-800">
                            حساب: فعال
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-800">
                        <p class="text-sm text-gray-500">
                            پنل تست ProPark
                        </p>
                    </div>
                </div>
            </div>

            {{-- اطلاعات اشتراک و لایسنس فعال --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-gray-900/50 border border-gray-800 p-5 rounded-2xl shadow-sm hover:border-gray-700 transition group">
                    <p class="text-xs text-white font-medium">اشتراک فعال</p>
                    <p class="mt-2 text-2xl font-mono font-bold text-violet-400 group-hover:scale-105 transition">{{ '—' }}</p>
                    <p class="mt-2 text-xs text-gray-600">به زودی متصل به دیتابیس</p>
                </div>

                <div class="bg-gray-900/50 border border-gray-800 p-5 rounded-2xl shadow-sm hover:border-gray-700 transition group">
                    <p class="text-xs text-white font-medium">تعداد لایسنس‌ها</p>
                    <p class="mt-2 text-2xl font-mono font-bold text-violet-400 group-hover:scale-105 transition">—</p>
                    <p class="mt-2 text-xs text-gray-600">به زودی</p>
                </div>

                <div class="bg-gray-900/50 border border-gray-800 p-5 rounded-2xl shadow-sm hover:border-gray-700 transition group">
                    <p class="text-xs text-white font-medium">درخواست‌های API امروز</p>
                    <p class="mt-2 text-2xl font-mono font-bold text-violet-400 group-hover:scale-105 transition">—</p>
                    <p class="mt-2 text-xs text-gray-600">به زودی</p>
                </div>

                <div class="bg-gray-900/50 border border-gray-800 p-5 rounded-2xl shadow-sm hover:border-gray-700 transition group">
                    <p class="text-xs text-white font-medium">نقش کاربر</p>
                    <p class="mt-2 text-2xl font-mono font-bold text-emerald-500 group-hover:scale-105 transition">
                        {{ auth()->user()->role ?? '—' }}
                    </p>
                </div>

            </div>

            {{-- دسترسی سریع --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6 lg:col-span-2">
                    <h3 class="text-sm font-semibold text-white flex items-center gap-2">
                        عملیات سریع
                    </h3>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">

                        <a href="shop"
                           class="flex items-center justify-between p-4 rounded-xl bg-gray-950 border border-gray-800 hover:border-violet-500/50 hover:bg-gray-900/50 transition-all group">
                            <div>
                                <p class="font-medium text-gray-300 group-hover:text-white">خرید اشتراک</p>
                                <p class="mt-1 text-sm text-gray-500">برای خرید اشتراک کلیک کنید</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <a href="#"
                           class="flex items-center justify-between p-4 rounded-xl bg-gray-950 border border-gray-800 hover:border-violet-500/50 hover:bg-gray-900/50 transition-all group">
                            <div>
                                <p class="font-medium text-gray-300 group-hover:text-white">لایسنس‌های من</p>
                                <p class="mt-1 text-sm text-gray-500">به زودی</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <a href="#"
                           class="flex items-center justify-between p-4 rounded-xl bg-gray-950 border border-gray-800 hover:border-violet-500/50 hover:bg-gray-900/50 transition-all group">
                            <div>
                                <p class="font-medium text-gray-300 group-hover:text-white">مستندات API</p>
                                <p class="mt-1 text-sm text-gray-500">به زودی</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center justify-between p-4 rounded-xl bg-gray-950 border border-gray-800 hover:border-violet-500/50 hover:bg-gray-900/50 transition-all group">
                            <div>
                                <p class="font-medium text-gray-300 group-hover:text-white">ویرایش پروفایل</p>
                                <p class="mt-1 text-sm text-gray-500">اطلاعات حساب کاربری</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </a>

                    </div>
                </div>

                {{-- اطلاعات حساب --}}
                <div class="bg-gray-900/50 border border-gray-800 rounded-2xl p-6">
                    <h3 class="text-sm font-semibold text-white mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-violet-500 rounded-full"></span>
                        اطلاعات حساب
                    </h3>

                    <dl class="mt-4 space-y-4">

                        <div>
                            <dt class="text-xs text-gray-500">ایمیل</dt>
                            <dd class="text-sm text-gray-300 font-mono break-all">
                                {{ auth()->user()->email }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">شماره موبایل</dt>
                            <dd class="text-sm text-gray-300">
                                {{ auth()->user()->phone_number ?? 'ثبت نشده' }}
                            </dd>
                        </div>

                        <div class="pt-3 border-t border-gray-800/50">
                            <dt class="text-xs text-gray-500">تاریخ عضویت</dt>
                            <dd class="text-sm text-gray-300">
                                {{ jdate(auth()->user()->created_at)->format('Y/m/d') }}
                            </dd>
                        </div>

                    </dl>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

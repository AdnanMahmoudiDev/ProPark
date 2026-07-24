<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold leading-tight text-white">
                    داشبورد کاربری
                </h2>

                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500"></span>

                    <span>
                        تاریخ امروز:
                        {{ jdate(now())->format('Y/m/d') }}
                    </span>
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <div class="rounded-xl border border-blue-800 bg-blue-900/20 px-4 py-2 text-xs text-blue-300">
                    AvaPark Panel
                </div>
            </div>

        </div>
    </x-slot>

    <div class="min-h-screen bg-[#0b0f19] py-10">

        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            {{-- خوشامد گویی --}}
            <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gradient-to-br from-gray-900 to-gray-950 p-7 shadow-2xl">

                <div class="absolute right-0 top-0 h-72 w-72 rounded-full bg-blue-700/10 blur-3xl"></div>

                <div class="relative z-10">

                    <div class="flex flex-wrap items-start justify-between gap-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-blue-700 bg-blue-600/20">

                                <svg class="h-6 w-6 text-blue-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>

                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    خوش آمدی،
                                    {{ auth()->user()->name }}
                                </h3>

                                <p class="mt-1 text-sm text-gray-400">
                                    مدیریت حساب و اشتراک AvaPark
                                </p>
                            </div>

                        </div>

                        <div class="rounded-xl border border-green-700 bg-green-900/20 px-4 py-2 text-xs font-medium text-green-400">
                            حساب فعال
                        </div>

                    </div>

                </div>

            </div>

            {{-- وضعیت --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- کارت اشتراک --}}
                <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 p-6 transition duration-300 hover:border-blue-700/50">

                    <div class="absolute left-0 top-0 h-40 w-40 rounded-full bg-blue-600/10 blur-3xl"></div>

                    <div class="relative z-10">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-400">
                                    وضعیت اشتراک
                                </p>

                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    @if($activeSubscription)
                                        اشتراک فعال
                                    @else
                                        بدون اشتراک
                                    @endif
                                </h3>
                            </div>

                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-700 bg-blue-600/20">
                                <svg class="h-7 w-7 text-blue-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>

                        </div>

                        <div class="mt-6">

                            @if($activeSubscription)

                                <div class="flex items-center gap-2 text-sm text-green-400">
                                    <span class="h-2 w-2 animate-pulse rounded-full bg-green-400"></span>
                                    اشتراک شما فعال است
                                </div>

                                <div class="mt-3 text-sm text-gray-400">
                                    تاریخ انقضا:
                                    <span class="font-medium text-white">
                                        {{ jdate($activeSubscription->expires_at)->format('Y/m/d') }}
                                    </span>
                                </div>

                                <a href="{{ route('subscription.details') }}"
                                   class="group mt-4 inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60">
                                    اطلاعات بیشتر
                                </a>

                            @else
                                <div class="text-sm text-red-400">
                                    اشتراک فعالی ندارید
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- کارت لایسنس --}}
                <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 p-6 transition duration-300 hover:border-blue-700/50">

                    <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-blue-600/10 blur-3xl"></div>

                    <div class="relative z-10">

                        <div class="flex items-center justify-between">

                            <div class="w-full">

                                <p class="text-sm text-gray-400">
                                    کد لایسنس
                                </p>

                                <div class="mt-4">
                                    @if($license)
                                        <div class="break-all rounded-2xl border border-gray-700 bg-black/40 px-4 py-4 font-mono text-sm text-blue-400 select-all sm:text-base">
                                            {{ $license->license_key }}
                                        </div>
                                    @else
                                        <div class="text-lg text-gray-500">
                                            —
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="mr-5 hidden h-14 w-14 items-center justify-center rounded-2xl border border-blue-700 bg-blue-600/20 sm:flex">
                                <svg class="h-7 w-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                </svg>

                            </div>

                        </div>

                        <div class="mt-5">
                            @if($license)
                                <div class="flex items-center gap-2 text-sm text-green-400">
                                    <span class="h-2 w-2 animate-pulse rounded-full bg-green-400"></span>
                                    لایسنس فعال
                                </div>
                            @else
                                <div class="text-sm text-red-400">
                                    لایسنسی برای شما ثبت نشده است
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">

                {{-- عملیات سریع --}}
                <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-6 lg:col-span-2">

                    <div>
                        <h3 class="text-lg font-bold text-white">عملیات سریع</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            دسترسی سریع به بخش‌های مهم
                        </p>
                    </div>

                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- خرید اشتراک --}}
                        <a href="{{ route('shop') }}"
                           class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60">

                            <div class="flex w-full items-center justify-between gap-4">

                                <div>
                                    <h4 class="font-semibold text-white">خرید اشتراک</h4>
                                    <p class="mt-1 text-sm text-blue-100/80">
                                        مشاهده پلن‌ها و خرید
                                    </p>
                                </div>

                                <svg class="h-5 w-5 text-white/90 transition group-hover:translate-x-[-2px]"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>

                            </div>

                        </a>

                        {{-- ویرایش حساب کاربری --}}
                        <a href="{{ route('profile.edit') }}"
                           class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60">

                            <div class="flex w-full items-center justify-between gap-4">

                                <div>
                                    <h4 class="font-semibold text-white">
                                        ویرایش حساب کاربری
                                    </h4>
                                </div>

                                <svg class="h-6 w-6 text-white/90 transition duration-300 group-hover:rotate-90"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M12 15.25A3.25 3.25 0 1012 8.75a3.25 3.25 0 000 6.5z"/>
                                </svg>

                            </div>

                        </a>

                    </div>

                </div>

                {{-- اطلاعات حساب کاربری --}}
                <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-6">

                    <div class="flex items-center gap-2">
                        <span class="h-6 w-2 rounded-full bg-blue-500"></span>
                        <h3 class="text-lg font-bold text-white">اطلاعات حساب</h3>
                    </div>

                    <div class="mt-6 space-y-5">

                        <div>
                            <p class="text-xs text-gray-500">ایمیل</p>
                            <p class="mt-1 break-all font-mono text-sm text-gray-300">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">شماره موبایل</p>
                            <p class="mt-1 text-sm text-gray-300">
                                {{ auth()->user()->phone_number ?? 'ثبت نشده' }}
                            </p>
                        </div>

                        <div class="border-t border-gray-800 pt-4">
                            <p class="text-xs text-gray-500">تاریخ عضویت</p>
                            <p class="mt-1 text-sm text-gray-300">
                                {{ jdate(auth()->user()->created_at)->format('Y/m/d') }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>

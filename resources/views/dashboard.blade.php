@php
    $isRtl = app()->isLocale('fa');

    // بررسی سطح دسترسی کاربر (ادمین یا کاربر عادی)
    $currentUser = auth()->user();
    $isAdmin = (method_exists($currentUser, 'isAdmin') && $currentUser->isAdmin())
        || ($currentUser->role ?? null) === 'admin'
        || (bool) ($currentUser->is_admin ?? false);

    // ---- پشتیبانی: محاسبه وضعیت ----
    $supportNow = now();

    $supportExpiresAt = ($activeSupport && $activeSupport->expires_at)
        ? \Illuminate\Support\Carbon::parse($activeSupport->expires_at)
        : null;

    $supportIsActive = (bool) (
        $activeSupport
        && $activeSupport->status === 'active'
        && $supportExpiresAt
        && $supportExpiresAt->isFuture()
    );

    // ---- اشتراک: معیار نمایش دکمه جزئیات ----
    $hasSubscription = isset($subscription) && !is_null($subscription);
@endphp

<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold leading-tight text-white">
                    {{ __('dashboard_title') }}
                </h2>
                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500"></span>
                    <span>
                        {{ __('dashboard_today_date') }}
                        {{ $isRtl ? jdate(now())->format('Y/m/d') : now()->format('Y/m/d') }}
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

            {{-- پیام‌های وضعیت سشن (موفقیت یا خطا) --}}
            @if (session('success'))
                <div class="relative overflow-hidden rounded-2xl border border-emerald-500/30 bg-emerald-950/40 p-4 text-emerald-300 shadow-xl backdrop-blur-md">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-emerald-500/40 bg-emerald-500/20">
                            <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm font-semibold leading-relaxed">
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="relative overflow-hidden rounded-2xl border border-rose-500/30 bg-rose-950/40 p-4 text-rose-300 shadow-xl backdrop-blur-md">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-rose-500/40 bg-rose-500/20">
                            <svg class="h-5 w-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="text-sm font-semibold leading-relaxed">
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            {{-- بخش خوش‌آمدگویی --}}
            <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gradient-to-br from-gray-900 to-gray-950 p-7 shadow-2xl">
                <div class="absolute right-0 top-0 h-72 w-72 rounded-full bg-blue-700/10 blur-3xl"></div>
                <div class="relative z-10">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-blue-700 bg-blue-600/20">
                                <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    {{ __('dashboard_welcome', ['name' => auth()->user()->name]) }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-400">{{ __('dashboard_subtitle') }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            {{-- بج نقش مدیر: کاملاً یکپارچه با طیف آبی سامانه --}}
                            @if($isAdmin)
                                <span class="rounded-xl border border-blue-500/40 bg-blue-500/10 px-3.5 py-1.5 text-xs font-semibold text-blue-300 shadow-sm shadow-blue-500/20">
                                    {{ __('نقش: مدیر') }}
                                </span>
                            @endif
                            <div class="rounded-xl border border-green-700 bg-green-900/20 px-4 py-2 text-xs font-medium text-green-400">
                                {{ __('dashboard_active_account') }}
                            </div>
                        </div>
                    </div>

                    {{-- دکمه اختصاصی ورود به پنل ادمین (صرفاً در صورت مدیر بودن کاربر) با رنگ‌بندی آبی هماهنگ --}}
                    @if($isAdmin)
                        <div class="mt-6 pt-5 border-t border-gray-800/80 flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-2.5 text-xs text-slate-400">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                                </span>
                                <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                                <span>شما دسترسی سطح مدیریت سامانه را دارید.</span>
                            </div>

                            <a
                                href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-6 py-3 text-xs font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/40 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                            >
                                <svg class="h-4 w-4 shrink-0 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ __('ورود به پنل کاربری ادمین') }}</span>
                                <svg class="h-3.5 w-3.5 rtl:rotate-180 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- وضعیت --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- کارت پشتیبانی --}}
                <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 p-6 transition duration-300 hover:border-blue-700/50">
                    <div class="absolute left-0 top-0 h-40 w-40 rounded-full bg-blue-600/10 blur-3xl"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-400">{{ __('dashboard_support_status_label') }}</p>
                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    {{ $supportIsActive ? __('dashboard_support_status_active') : __('dashboard_support_status_inactive') }}
                                </h3>
                            </div>

                            {{-- آیکون هدست اپراتور پشتیبانی --}}
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-blue-700 bg-blue-600/20">
                                <svg class="h-7 w-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 14v-3a9 9 0 0 1 18 0v3"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 14h2a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2Zm12 0h2a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2Z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 19c0 1.657-1.343 3-3 3h-2"/>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-6">
                            @if($supportIsActive)
                                <div class="flex items-center gap-2 text-sm text-green-400">
                                    <span class="h-2 w-2 animate-pulse rounded-full bg-green-400"></span>
                                    {{ __('dashboard_support_active_notice') }}
                                </div>

                                <div class="mt-3 text-sm text-gray-400">
                                    {{ __('dashboard_support_expiry_date') }}
                                    <span class="font-medium text-white">
                                        {{ $isRtl ? jdate($supportExpiresAt)->format('Y/m/d') : $supportExpiresAt->format('Y/m/d') }}
                                    </span>
                                </div>
                            @else
                                <div class="text-sm text-red-400">
                                    {{ __('dashboard_support_inactive_notice') }}
                                </div>

                                @if($supportExpiresAt)
                                    <div class="mt-3 text-sm text-gray-400">
                                        {{ __('dashboard_support_expiry_date') }}
                                        <span class="font-medium text-white">
                                            {{ $isRtl ? jdate($supportExpiresAt)->format('Y/m/d') : $supportExpiresAt->format('Y/m/d') }}
                                        </span>
                                    </div>
                                @endif
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
                                <p class="text-sm text-gray-400">{{ __('dashboard_license_code') }}</p>
                                <div class="mt-4">
                                    @if($license)
                                        <div class="break-all rounded-2xl border border-gray-700 bg-black/40 px-4 py-4 font-mono text-sm text-blue-400 select-all sm:text-base">
                                            {{ $license->license_key }}
                                        </div>
                                    @else
                                        <div class="text-lg text-gray-500">—</div>
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
                                    {{ __('dashboard_license_active') }}
                                </div>
                            @else
                                <div class="text-sm text-red-400">{{ __('dashboard_license_none') }}</div>
                            @endif

                            {{-- دکمه مشاهده دستگاه‌های متصل و پشتیبانی --}}
                            @if($hasSubscription)
                                <a
                                    href="{{ route('subscription.details') }}"
                                    class="group mt-4 inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                                >
                                    {{ __('dashboard_view_subscription_details') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 gap-5 lg:grid-cols-3">
                {{-- عملیات سریع --}}
                <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-6 lg:col-span-2">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ __('dashboard_quick_actions') }}</h3>
                        <p class="mt-1 text-sm text-gray-500">{{ __('dashboard_quick_actions_desc') }}</p>
                    </div>

                    {{-- دکمه‌ها: کاملاً یکپارچه با تم آبی AvaPark --}}
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        {{-- ۱. خرید اشتراک --}}
                        <a
                            href="{{ route('shop') }}"
                            class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-6 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                        >
                            <div class="flex w-full items-center justify-between gap-3">
                                <div>
                                    <h4 class="font-semibold text-white">{{ __('dashboard_buy_subscription') }}</h4>
                                    <p class="mt-1 text-xs text-blue-100/80">{{ __('dashboard_buy_subscription_desc') }}</p>
                                </div>
                                <svg class="h-5 w-5 shrink-0 text-white/90 transition rtl:rotate-180 group-hover:translate-x-[-2px] rtl:group-hover:translate-x-[2px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </a>

                        {{-- ۲. تاریخچه خریدها --}}
                        <a
                            href="{{ route('user.invoices.index') }}"
                            class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-6 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                        >
                            <div class="flex w-full items-center justify-between gap-3">
                                <div>
                                    <h4 class="font-semibold text-white">{{ __('dashboard_order_history') }}</h4>
                                    <p class="mt-1 text-xs text-blue-100/80">{{ __('dashboard_order_history_desc') }}</p>
                                </div>
                                <svg class="h-5 w-5 shrink-0 text-white/90 transition duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                        </a>

                        {{-- ۳. ویرایش پروفایل --}}
                        <a
                            href="{{ route('profile.edit') }}"
                            class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-6 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                        >
                            <div class="flex w-full items-center justify-between gap-3">
                                <div>
                                    <h4 class="font-semibold text-white">{{ __('dashboard_edit_profile') }}</h4>
                                    <p class="mt-1 text-xs text-blue-100/80">{{ __('dashboard_email') }} & {{ __('dashboard_phone') }}</p>
                                </div>
                                <svg class="h-5 w-5 shrink-0 text-white/90 transition duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15.25A3.25 3.25 0 1012 8.75a3.25 3.25 0 000 6.5z"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- اطلاعات حساب کاربری --}}
                <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-6">
                    <div class="flex items-center gap-2">
                        <span class="h-6 w-2 rounded-full bg-blue-500"></span>
                        <h3 class="text-lg font-bold text-white">{{ __('dashboard_account_info') }}</h3>
                    </div>
                    <div class="mt-6 space-y-5">
                        <div>
                            <p class="text-xs text-gray-500">{{ __('dashboard_email') }}</p>
                            <p class="mt-1 break-all font-mono text-sm text-gray-300">{{ auth()->user()->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">{{ __('dashboard_phone') }}</p>
                            <p class="mt-1 text-sm text-gray-300">
                                {{ auth()->user()->phone_number ?? __('dashboard_not_set') }}
                            </p>
                        </div>
                        <div class="border-t border-gray-800 pt-4">
                            <p class="text-xs text-gray-500">{{ __('dashboard_joined_date') }}</p>
                            <p class="mt-1 text-sm text-gray-300">
                                {{ $isRtl ? jdate(auth()->user()->created_at)->format('Y/m/d') : \Carbon\Carbon::parse(auth()->user()->created_at)->format('Y/m/d') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

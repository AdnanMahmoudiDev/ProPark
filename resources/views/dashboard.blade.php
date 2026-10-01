@php
    $isRtl = app()->isLocale('fa');

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
    // هدف: دکمه "مشاهده جزئیات" فقط زمانی مخفی شود که کاربر کلاً هیچ اشتراکی نداشته باشد.
    // اگر در این صفحه $subscription پاس داده شده، همان را معیار قرار می‌دهیم.
    // (در غیر این صورت بهتر است از کنترلر پاس داده شود.)
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

            {{-- خوشامد گویی --}}
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
                                <h3 class="text-xl font-bold text-white">{{ __('dashboard_welcome', ['name' => auth()->user()->name]) }}</h3>
                                <p class="mt-1 text-sm text-gray-400">{{ __('dashboard_subtitle') }}</p>
                            </div>
                        </div>
                        <div class="rounded-xl border border-green-700 bg-green-900/20 px-4 py-2 text-xs font-medium text-green-400">
                            {{ __('dashboard_active_account') }}
                        </div>
                    </div>
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
                                <p class="text-sm text-gray-400">{{ __('وضعیت پشتیبانی') }}</p>
                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    {{ $supportIsActive ? __('پشتیبانی فعال') : __('پشتیبانی فعال نیست') }}
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
                                    {{ __('پشتیبانی شما فعال است') }}
                                </div>

                                <div class="mt-3 text-sm text-gray-400">
                                    {{ __('تاریخ پایان پشتیبانی:') }}
                                    <span class="font-medium text-white">
                                        {{ $isRtl ? jdate($supportExpiresAt)->format('Y/m/d') : $supportExpiresAt->format('Y/m/d') }}
                                    </span>
                                </div>
                            @else
                                <div class="text-sm text-red-400">
                                    {{ __('پشتیبانی شما فعال نیست یا منقضی شده است') }}
                                </div>

                                {{-- اگر تاریخ انقضا داریم (ولی منقضی شده)، نمایش بده برای شفافیت --}}
                                @if($supportExpiresAt)
                                    <div class="mt-3 text-sm text-gray-400">
                                        {{ __('تاریخ پایان پشتیبانی:') }}
                                        <span class="font-medium text-white">
                                            {{ $isRtl ? jdate($supportExpiresAt)->format('Y/m/d') : $supportExpiresAt->format('Y/m/d') }}
                                        </span>
                                    </div>
                                @endif
                            @endif

                            {{-- دکمه جزئیات: فقط وقتی کلاً اشتراک داریم نمایش داده شود --}}
                            @if($hasSubscription)
                                <a
                                    href="{{ route('subscription.details') }}"
                                    class="group mt-4 inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                                >
                                    {{ __('مشاهده جزئیات') }}
                                </a>
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
                    <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a href="{{ route('shop') }}" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60">
                            <div class="flex w-full items-center justify-between gap-4">
                                <div>
                                    <h4 class="font-semibold text-white">{{ __('dashboard_buy_subscription') }}</h4>
                                    <p class="mt-1 text-sm text-blue-100/80">{{ __('dashboard_buy_subscription_desc') }}</p>
                                </div>
                                <svg class="h-5 w-5 text-white/90 transition rtl:rotate-180 group-hover:translate-x-[-2px] rtl:group-hover:translate-x-[2px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </div>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-4 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60">
                            <div class="flex w-full items-center justify-between gap-4">
                                <div><h4 class="font-semibold text-white">{{ __('dashboard_edit_profile') }}</h4></div>
                                <svg class="h-6 w-6 text-white/90 transition duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                            <p class="mt-1 text-sm text-gray-300">{{ auth()->user()->phone_number ?? __('dashboard_not_set') }}</p>
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

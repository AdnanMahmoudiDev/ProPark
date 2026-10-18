@extends('admin.layout.app')

@section('title', 'داشبورد مدیریت')
@section('breadcrumb', 'داشبورد')
@section('header-title', 'داشبورد مدیریت')

@section('content')

@php
    $totalUsers = $totalUsers ?? 0;
    $newUsersLast7Days = $newUsersLast7Days ?? 0;
    $conversionRate = $conversionRate ?? 0;

    $totalSubscriptions = $totalSubscriptions ?? 0;
    $activeSubscriptions = $activeSubscriptions ?? 0;
    $newSubscriptionsLast7Days = $newSubscriptionsLast7Days ?? 0;

    $totalSupports = $totalSupports ?? 0;
    $activeSupports = $activeSupports ?? 0;
    $expiredSupports = $expiredSupports ?? 0;
    $expiringSoonSupports = $expiringSoonSupports ?? 0;
    $newSupportsLast7Days = $newSupportsLast7Days ?? 0;
    $supportConversionRate = $supportConversionRate ?? 0;

    $activeSupportChart = max(0, (int) $activeSupports);
    $expiredSupportChart = max(0, (int) $expiredSupports);
    $expiringSupportChart = max(0, (int) $expiringSoonSupports);

    $latestUsers = $latestUsers ?? collect();
    $latestSubscriptions = $latestSubscriptions ?? collect();
    $latestSupports = $latestSupports ?? collect();
@endphp

<div class="space-y-8">

    {{-- Page heading --}}
    <section class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <div class="mb-3 flex items-center gap-2">
                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
                <span class="text-[11px] font-medium text-emerald-300">
                    نمای مدیریتی AvaPark
                </span>
            </div>

            <h2 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                {{ auth()->user()->name ?? 'مدیر' }}
            </h2>

            <p class="mt-2 text-xs leading-6 text-slate-400 sm:text-sm">
                وضعیت کاربران، اشتراک‌ها و پشتیبانی را از یک نگاه بررسی کن.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 rounded-xl border border-white/[.08]
                        bg-white/[.035] px-4 py-3">
                <svg class="h-4 w-4 text-blue-400" viewBox="0 0 24 24"
                     fill="none" stroke="currentColor" stroke-width="1.7">
                    <rect x="3" y="5" width="18" height="16" rx="2"/>
                    <path d="M16 3v4M8 3v4M3 10h18"/>
                </svg>
                <span class="text-xs text-slate-300">
                    {{ jdate(now())->format('Y/m/d') }}
                </span>
            </div>

            <a href="{{ route('admin.licenses.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-blue-600
                      px-4 py-3 text-xs font-bold text-white shadow-lg
                      shadow-blue-900/20 transition hover:bg-blue-500">
                <span class="text-lg leading-none">+</span>
                لایسنس جدید
            </a>
        </div>
    </section>

    {{-- Welcome banner --}}
    <section class="pp-panel relative overflow-hidden rounded-3xl">
        <div class="pp-glow -right-12 -top-24 bg-blue-500"></div>
        <div class="pp-glow -bottom-32 left-1/3 bg-indigo-500"></div>

        <div class="relative flex flex-col justify-between gap-6 p-6 sm:p-8 lg:flex-row lg:items-center">
            <div class="flex items-start gap-4">

<div class="grid h-14 w-14 shrink-0 place-items-center rounded-2xl
            border border-blue-400/20
            bg-gradient-to-br from-blue-500/15 to-indigo-500/10
            text-blue-300 shadow-lg shadow-blue-500/5">

    <svg xmlns="http://www.w3.org/2000/svg"
         class="h-7 w-7"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="1.6"
         stroke-linecap="round"
         stroke-linejoin="round"
         aria-hidden="true">

        <!-- ساختار اصلی داشبورد -->
        <rect x="3" y="3.5" width="18" height="17" rx="2.5"/>

        <!-- نوار بالایی پنل -->
        <path d="M3 8h18"/>

        <!-- کنترل‌های پنجره -->
        <circle cx="6" cy="5.8" r=".55"
                fill="currentColor" stroke="none"/>
        <circle cx="8" cy="5.8" r=".55"
                fill="currentColor" stroke="none"/>

        <!-- کارت آماری -->
        <rect x="5.5" y="10.5" width="5.5" height="3.5" rx="1"/>

        <!-- نمودار میله‌ای -->
        <path d="M6.8 12.8v-.8"/>
        <path d="M8.25 12.8v-1.4"/>
        <path d="M9.7 12.8v-2"/>

        <!-- کارت اطلاعات -->
        <rect x="13" y="10.5" width="5.5" height="7" rx="1"/>

        <!-- نمودار روند صعودی -->
        <path d="m14.2 15.5 1.5-1.6 1.3.9 1.3-2"/>

        <!-- خطوط اطلاعات -->
        <path d="M5.8 16.5h4.9"/>
        <path d="M5.8 18.2h3.2"/>

    </svg>
</div>



                <div>
                    <h3 class="text-lg font-bold text-white sm:text-xl">
                        مرکز کنترل AvaPark
                    </h3>
                    <p class="mt-2 max-w-2xl text-xs leading-7 text-slate-400 sm:text-sm">
                        خلاصه‌ای از وضعیت فعلی سامانه؛ اطلاعات زیر بر اساس
                        آمار ارائه‌شده توسط کنترلر داشبورد نمایش داده می‌شوند.
                    </p>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <span class="rounded-lg border border-blue-400/15
                                     bg-blue-400/[.07] px-3 py-1.5 text-[10px] text-blue-300">
                            مدیریت کاربران
                        </span>
                        <span class="rounded-lg border border-cyan-400/15
                                     bg-cyan-400/[.07] px-3 py-1.5 text-[10px] text-cyan-300">
                            اشتراک‌ها و لایسنس‌ها
                        </span>
                        <span class="rounded-lg border border-violet-400/15
                                     bg-violet-400/[.07] px-3 py-1.5 text-[10px] text-violet-300">
                            پشتیبانی
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex shrink-0 items-center gap-3 rounded-2xl
                        border border-emerald-400/15 bg-emerald-400/[.045] p-4">
                <div class="grid h-10 w-10 place-items-center rounded-xl
                            bg-emerald-400/10 text-emerald-300">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.7">
                        <path d="m5 12 4 4L19 6"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-emerald-300">
                        پنل مدیریت
                    </p>
                    <p class="mt-1 text-[10px] text-slate-500">
                        خوش آمدید
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Users --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="pp-section-title text-sm font-bold text-white">
                نمای کلی کاربران
            </h3>
            <span class="text-[10px] text-slate-500">آمار ثبت‌شده</span>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

            {{-- Total users --}}
            <article class="pp-panel pp-stat rounded-2xl p-5 sm:p-6">
                <div class="pp-glow -right-12 -top-16 bg-blue-500"></div>
                <div class="relative flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">کل کاربران ثبت‌نامی</p>
                        <p class="mt-4 text-3xl font-black tracking-tight text-white">
                            {{ number_format($totalUsers) }}
                        </p>
                        <p class="mt-3 text-[10px] text-slate-500">
                            مجموع کاربران ثبت‌شده
                        </p>
                    </div>
                    <div class="pp-stat-icon bg-blue-500/10 text-blue-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="10" cy="7" r="4"/>
                            <path d="M20 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-5 h-1 overflow-hidden rounded-full bg-white/[.06]">
                    <div class="h-full w-full rounded-full bg-gradient-to-l from-blue-400 to-blue-600"></div>
                </div>
            </article>

            {{-- New users --}}
            <article class="pp-panel pp-stat rounded-2xl p-5 sm:p-6">
                <div class="pp-glow -right-12 -top-16 bg-cyan-500"></div>
                <div class="relative flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">کاربران جدید</p>
                        <p class="mt-4 text-3xl font-black tracking-tight text-cyan-300">
                            {{ number_format($newUsersLast7Days) }}
                        </p>
                        <p class="mt-3 text-[10px] text-slate-500">۷ روز اخیر</p>
                    </div>
                    <div class="pp-stat-icon bg-cyan-500/10 text-cyan-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M3 21v-2a6 6 0 0 1 12 0v2"/>
                            <path d="M19 8v6m-3-3h6"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-5 h-1 overflow-hidden rounded-full bg-white/[.06]">
                    <div class="h-full rounded-full bg-gradient-to-l from-cyan-400 to-blue-500"
                         style="width: {{ $totalUsers > 0 ? min(100, ($newUsersLast7Days / $totalUsers) * 100) : 0 }}%">
                    </div>
                </div>
            </article>

            {{-- Conversion --}}
            <article class="pp-panel pp-stat rounded-2xl p-5 sm:p-6">
                <div class="pp-glow -right-12 -top-16 bg-emerald-500"></div>
                <div class="relative flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">نرخ تبدیل کاربران</p>
                        <p class="mt-4 text-3xl font-black tracking-tight text-emerald-300">
                            {{ number_format((float) $conversionRate, 2) }}%
                        </p>
                        <p class="mt-3 text-[10px] text-slate-500">طبق محاسبه کنترلر</p>
                    </div>
                    <div class="pp-stat-icon bg-emerald-500/10 text-emerald-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M3 17 9 11l4 4 8-9"/>
                            <path d="M15 6h6v6"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-5 h-1 overflow-hidden rounded-full bg-white/[.06]">
                    <div class="h-full rounded-full bg-gradient-to-l from-emerald-400 to-teal-500"
                         style="width: {{ min(100, max(0, (float) $conversionRate)) }}%">
                    </div>
                </div>
            </article>
        </div>
    </section>

    {{-- Subscriptions --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="pp-section-title text-sm font-bold text-white">
                لایسنس‌ها و اشتراک‌ها
            </h3>
            <a href="{{ route('admin.subscriptions.index') }}"
               class="text-[11px] text-blue-400 transition hover:text-blue-300">
                مشاهده اشتراک‌ها ←
            </a>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <article class="pp-panel pp-stat rounded-2xl p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">کل اشتراک‌ها</p>
                        <p class="mt-3 text-2xl font-black text-white">
                            {{ number_format($totalSubscriptions) }}
                        </p>
                    </div>
                    <div class="pp-stat-icon bg-indigo-500/10 text-indigo-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 10h18M7 15h4"/>
                        </svg>
                    </div>
                </div>
            </article>

            <article class="pp-panel pp-stat rounded-2xl p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">اشتراک‌های فعال</p>
                        <p class="mt-3 text-2xl font-black text-emerald-300">
                            {{ number_format($activeSubscriptions) }}
                        </p>
                    </div>
                    <div class="pp-stat-icon bg-emerald-500/10 text-emerald-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="m5 12 4 4L19 6"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                </div>
            </article>

            <article class="pp-panel pp-stat rounded-2xl p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs text-slate-400">اشتراک‌های جدید</p>
                        <p class="mt-3 text-2xl font-black text-cyan-300">
                            {{ number_format($newSubscriptionsLast7Days) }}
                        </p>
                        <p class="mt-2 text-[10px] text-slate-500">۷ روز اخیر</p>
                    </div>
                    <div class="pp-stat-icon bg-cyan-500/10 text-cyan-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                            <path d="M12 5v14M5 12h14"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                    </div>
                </div>
            </article>
        </div>
    </section>

    {{-- Supports --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <h3 class="pp-section-title text-sm font-bold text-white">
                وضعیت پشتیبانی‌ها
            </h3>
            <span class="text-[10px] text-slate-500">آمار فعلی</span>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 xl:grid-cols-6">

            <article class="pp-panel rounded-2xl p-4">
                <p class="text-[11px] leading-5 text-slate-400">کل پشتیبانی‌ها</p>
                <p class="mt-3 text-2xl font-black text-white">{{ number_format($totalSupports) }}</p>
                <div class="mt-3 h-1 rounded-full bg-slate-500/30"></div>
            </article>

            <article class="pp-panel rounded-2xl p-4">
                <p class="text-[11px] leading-5 text-slate-400">فعال</p>
                <p class="mt-3 text-2xl font-black text-emerald-300">{{ number_format($activeSupports) }}</p>
                <div class="mt-3 h-1 rounded-full bg-emerald-400/50"></div>
            </article>

            <article class="pp-panel rounded-2xl p-4">
                <p class="text-[11px] leading-5 text-slate-400">منقضی‌شده</p>
                <p class="mt-3 text-2xl font-black text-rose-300">{{ number_format($expiredSupports) }}</p>
                <div class="mt-3 h-1 rounded-full bg-rose-400/50"></div>
            </article>

            <article class="pp-panel rounded-2xl p-4">
                <p class="text-[11px] leading-5 text-slate-400">در آستانه انقضا</p>
                <p class="mt-3 text-2xl font-black text-amber-300">{{ number_format($expiringSoonSupports) }}</p>
                <div class="mt-3 h-1 rounded-full bg-amber-400/50"></div>
            </article>

            <article class="pp-panel rounded-2xl p-4">
                <p class="text-[11px] leading-5 text-slate-400">جدید</p>
                <p class="mt-3 text-2xl font-black text-cyan-300">{{ number_format($newSupportsLast7Days) }}</p>
                <p class="mt-2 text-[10px] text-slate-500">۷ روز اخیر</p>
            </article>

            <article class="pp-panel rounded-2xl p-4">
                <p class="text-[11px] leading-5 text-slate-400">نرخ تبدیل پشتیبانی</p>
                <p class="mt-3 text-2xl font-black text-violet-300">
                    {{ number_format((float) $supportConversionRate, 2) }}%
                </p>
                <div class="mt-3 h-1 rounded-full bg-violet-400/40"></div>
            </article>
        </div>
    </section>

    {{-- Interactive charts (بخش تحلیل تصویری مدرن با استایل سرور/داشبورد اختصاصی) --}}
    <section>
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="h-2 w-2 rounded-full bg-blue-500"></div>
                <h3 class="pp-section-title text-sm font-bold text-white">
                    تحلیل تصویری و آماری
                </h3>
            </div>
            <span class="rounded-lg border border-white/[.08] bg-white/[.03] px-3 py-1 text-[10px] font-mono text-slate-400">
                LIVE METRICS
            </span>
        </div>

        <div class="grid grid-cols-1 gap-5 xl:grid-cols-5">

            {{-- Comparison chart --}}
            <div class="pp-panel rounded-3xl p-5 sm:p-6 xl:col-span-3 flex flex-col justify-between">
                <div class="mb-5 flex flex-wrap items-center justify-between gap-3 border-b border-white/[.05] pb-4">
                    <div>
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span>مقایسه شاخص‌های کلیدی</span>
                            <span class="rounded bg-blue-500/10 px-2 py-0.5 text-[10px] font-medium text-blue-400">تحلیلی</span>
                        </h4>
                        <p class="mt-1 text-[11px] text-slate-400">
                            بررسی توزیع حجم کاربران، اشتراک‌ها و تعاملات پشتیبانی
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <select id="comparisonMode"
                                class="cursor-pointer rounded-xl border border-white/10 bg-[#0b0f19] px-3 py-2 text-xs font-medium text-slate-200 outline-none transition hover:border-blue-500/50 focus:border-blue-500">
                            <option value="totals">مجموع داده‌ها</option>
                            <option value="recent">آمار ۷ روز اخیر</option>
                        </select>
                    </div>
                </div>

                <div class="pp-chart-wrap relative h-[280px] w-full">
                    <canvas id="comparisonChart"
                            role="img"
                            aria-label="نمودار مقایسه آمار کاربران، اشتراک‌ها و پشتیبانی">
                    </canvas>
                </div>

                <div class="mt-4 flex items-center justify-between border-t border-white/[.05] pt-3 text-[11px] text-slate-400">
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span> کاربران
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-cyan-400"></span> اشتراک‌ها
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="h-2 w-2 rounded-full bg-violet-400"></span> پشتیبانی‌ها
                    </span>
                </div>
            </div>

            {{-- Support status chart --}}
            <div class="pp-panel rounded-3xl p-5 sm:p-6 xl:col-span-2 flex flex-col justify-between">
                <div class="border-b border-white/[.05] pb-4">
                    <h4 class="text-sm font-bold text-white">تفکیک وضعیت لایسنس‌ها</h4>
                    <p class="mt-1 text-[11px] text-slate-400">
                        بررسی نسبت پایداری خدمات پشتیبانی جاری
                    </p>
                </div>

                <div class="relative my-auto flex items-center justify-center py-4">
                    <div class="relative h-[210px] w-[210px]">
                        <canvas id="supportChart"
                                role="img"
                                aria-label="نمودار وضعیت پشتیبانی‌های فعال، منقضی و در آستانه انقضا">
                        </canvas>
                        {{-- نشانگر مرکزی وضعیت داخل دونات --}}
                        <div class="pointer-events-none absolute inset-0 flex flex-col items-center justify-center text-center">
                            <span class="text-[10px] uppercase tracking-wider text-slate-400 font-medium">مجموع</span>
                            <span class="text-2xl font-black text-white font-mono mt-0.5">
                                {{ number_format($totalSupports) }}
                            </span>
                            <span class="text-[10px] text-emerald-400 font-medium mt-0.5">
                                {{ $totalSupports > 0 ? round(($activeSupports / $totalSupports) * 100) : 0 }}% فعال
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-2 border-t border-white/[.05] pt-3">
                    <div class="rounded-xl border border-emerald-500/10 bg-emerald-500/5 p-2 text-center">
                        <span class="block text-[10px] text-emerald-400">فعال</span>
                        <span class="text-sm font-bold text-white font-mono">{{ number_format($activeSupports) }}</span>
                    </div>

                    <div class="rounded-xl border border-rose-500/10 bg-rose-500/5 p-2 text-center">
                        <span class="block text-[10px] text-rose-400">منقضی</span>
                        <span class="text-sm font-bold text-white font-mono">{{ number_format($expiredSupports) }}</span>
                    </div>

                    <div class="rounded-xl border border-amber-500/10 bg-amber-500/5 p-2 text-center">
                        <span class="block text-[10px] text-amber-400">در آستانه</span>
                        <span class="text-sm font-bold text-white font-mono">{{ number_format($expiringSoonSupports) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Recent data tables --}}
    <section>
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <h3 class="pp-section-title text-sm font-bold text-white">
                آخرین فعالیت‌های ثبت‌شده
            </h3>
            <span class="text-[10px] text-slate-500">
                اطلاعات اخیر سامانه
            </span>
        </div>

        <div class="grid grid-cols-1 gap-5 2xl:grid-cols-2">

            {{-- Latest users --}}
            <div class="pp-panel min-w-0 overflow-hidden rounded-3xl">
                <div class="flex items-center justify-between gap-3 border-b
                            border-white/[.06] p-5">
                    <div class="flex items-center gap-3">
                        <div class="grid h-10 w-10 place-items-center rounded-xl
                                    bg-blue-500/10 text-blue-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.7">
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M3 21v-2a6 6 0 0 1 12 0v2"/>
                                <path d="M19 8v6m-3-3h6"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">آخرین کاربران</h4>
                            <p class="mt-1 text-[10px] text-slate-500">کاربران ثبت‌نام‌شده</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.users.index') }}"
                       class="text-[11px] text-blue-400 hover:text-blue-300">
                        همه کاربران ←
                    </a>
                </div>

                <div class="pp-scrollbar overflow-x-auto">
                    <table class="pp-table w-full border-collapse text-right">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام کاربر</th>
                                <th>تاریخ عضویت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestUsers as $user)
                                <tr>
                                    <td class="font-mono text-slate-400">
                                        #{{ $user->id }}
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <div class="grid h-8 w-8 shrink-0 place-items-center
                                                        rounded-lg bg-blue-500/10 text-xs
                                                        font-bold text-blue-300">
                                                {{ mb_substr($user->name ?? '?', 0, 1) }}
                                            </div>
                                            <span class="font-medium text-slate-200">
                                                {{ $user->name ?? 'بدون نام' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-slate-400">
                                        {{ $user->created_at ? jdate($user->created_at)->format('Y/m/d') : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="!py-10 text-center text-slate-500">
                                        هنوز کاربری ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Latest subscriptions --}}
            <div class="pp-panel min-w-0 overflow-hidden rounded-3xl">
                <div class="flex items-center justify-between gap-3 border-b
                            border-white/[.06] p-5">
                    <div class="flex items-center gap-3">
                        <div class="grid h-10 w-10 place-items-center rounded-xl
                                    bg-cyan-500/10 text-cyan-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.7">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="M3 10h18M7 15h4"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">آخرین اشتراک‌ها</h4>
                            <p class="mt-1 text-[10px] text-slate-500">وضعیت اشتراک کاربران</p>
                        </div>
                    </div>

                    <a href="{{ route('admin.subscriptions.index') }}"
                       class="text-[11px] text-blue-400 hover:text-blue-300">
                        همه اشتراک‌ها ←
                    </a>
                </div>

                <div class="pp-scrollbar overflow-x-auto">
                    <table class="pp-table w-full border-collapse text-right">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>کاربر</th>
                                <th>وضعیت</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestSubscriptions as $subscription)
                                @php
                                    $status = strtolower((string) ($subscription->status ?? ''));
                                    $statusClasses = match ($status) {
                                        'active' => 'text-emerald-300 bg-emerald-400/[.06]',
                                        'expired', 'inactive' => 'text-rose-300 bg-rose-400/[.06]',
                                        'pending', 'soon' => 'text-amber-300 bg-amber-400/[.06]',
                                        default => 'text-slate-400 bg-white/[.03]',
                                    };

                                    $statusLabel = match ($status) {
                                        'active' => 'فعال',
                                        'expired' => 'منقضی‌شده',
                                        'inactive' => 'غیرفعال',
                                        'pending' => 'در انتظار',
                                        'soon' => 'نزدیک به انقضا',
                                        default => $subscription->status ?: 'نامشخص',
                                    };
                                @endphp

                                <tr>
                                    <td class="font-mono text-slate-400">
                                        #{{ $subscription->id }}
                                    </td>
                                    <td class="font-medium text-slate-200">
                                        {{ $subscription->user->name ?? 'کاربر ناشناس' }}
                                    </td>
                                    <td>
                                        <span class="pp-status {{ $statusClasses }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="text-slate-400">
                                        {{ $subscription->created_at ? jdate($subscription->created_at)->format('Y/m/d') : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="!py-10 text-center text-slate-500">
                                        هنوز اشتراکی ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Latest supports --}}
            <div class="pp-panel min-w-0 overflow-hidden rounded-3xl 2xl:col-span-2">
                <div class="flex items-center justify-between gap-3 border-b
                            border-white/[.06] p-5">
                    <div class="flex items-center gap-3">
                        <div class="grid h-10 w-10 place-items-center rounded-xl
                                    bg-violet-500/10 text-violet-300">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.7">
                                <path d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">آخرین پشتیبانی‌ها</h4>
                            <p class="mt-1 text-[10px] text-slate-500">وضعیت و تاریخ انقضای پشتیبانی</p>
                        </div>
                    </div>
                </div>

                <div class="pp-scrollbar overflow-x-auto">
                    <table class="pp-table w-full border-collapse text-right">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>کاربر</th>
                                <th>وضعیت</th>
                                <th>تاریخ انقضا</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestSupports as $support)
                                @php
                                    $isSupportActive =
                                        $support->status === 'active'
                                        && $support->expires_at
                                        && \Illuminate\Support\Carbon::parse($support->expires_at)->isFuture();
                                @endphp

                                <tr>
                                    <td class="font-mono text-slate-400">
                                        #{{ $support->id }}
                                    </td>
                                    <td class="font-medium text-slate-200">
                                        {{ $support->user->name ?? 'کاربر ناشناس' }}
                                    </td>
                                    <td>
                                        @if($isSupportActive)
                                            <span class="pp-status bg-emerald-400/[.06] text-emerald-300">
                                                فعال
                                            </span>
                                        @else
                                            <span class="pp-status bg-rose-400/[.06] text-rose-300">
                                                منقضی‌شده
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-slate-400">
                                        {{ $support->expires_at ? jdate($support->expires_at)->format('Y/m/d') : 'نامشخص' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="!py-10 text-center text-slate-500">
                                        هنوز پشتیبانی‌ای ثبت نشده است.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof Chart === 'undefined') {
        console.error('Chart.js بارگذاری نشد.');
        return;
    }

    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = 'Vazirmatn, Tahoma, sans-serif';
    Chart.defaults.font.size = 11;

    const comparisonCanvas = document.getElementById('comparisonChart');
    const ctx = comparisonCanvas.getContext('2d');

    // تابع کمکی برای ایجاد گرادیان رنگی عمودی برای هر ستون
    function getGradient(ctx, topColor, bottomColor) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, topColor);
        gradient.addColorStop(1, bottomColor);
        return gradient;
    }

    const gradBlue = getGradient(ctx, 'rgba(59, 130, 246, 0.95)', 'rgba(30, 58, 138, 0.2)');
    const gradCyan = getGradient(ctx, 'rgba(6, 182, 212, 0.95)', 'rgba(14, 116, 144, 0.2)');
    const gradViolet = getGradient(ctx, 'rgba(139, 92, 246, 0.95)', 'rgba(76, 29, 149, 0.2)');

    const comparisonMode = document.getElementById('comparisonMode');

    const comparisonData = {
        totals: {
            labels: ['کاربران', 'اشتراک‌ها', 'پشتیبانی‌ها'],
            values: [
                @json((float) $totalUsers),
                @json((float) $totalSubscriptions),
                @json((float) $totalSupports)
            ]
        },
        recent: {
            labels: ['کاربران جدید', 'اشتراک‌های جدید', 'پشتیبانی‌های جدید'],
            values: [
                @json((float) $newUsersLast7Days),
                @json((float) $newSubscriptionsLast7Days),
                @json((float) $newSupportsLast7Days)
            ]
        }
    };

    let comparisonChart = null;

    function createComparisonChart(mode) {
        const selected = comparisonData[mode] || comparisonData.totals;

        if (comparisonChart) {
            comparisonChart.destroy();
        }

        comparisonChart = new Chart(comparisonCanvas, {
            type: 'bar',
            data: {
                labels: selected.labels,
                datasets: [{
                    label: 'آمار',
                    data: selected.values,
                    backgroundColor: [gradBlue, gradCyan, gradViolet],
                    borderColor: ['#3b82f6', '#06b6d4', '#8b5cf6'],
                    borderWidth: 1.5,
                    borderRadius: 12,
                    borderSkipped: false,
                    barPercentage: 0.5,
                    categoryPercentage: 0.65
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 900,
                    easing: 'easeOutQuart'
                },
                layout: {
                    padding: { top: 15, bottom: 0, left: 5, right: 5 }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        rtl: true,
                        usePointStyle: true,
                        backgroundColor: 'rgba(11, 15, 25, 0.94)',
                        titleColor: '#ffffff',
                        titleFont: { weight: 'bold', size: 12 },
                        bodyColor: '#cbd5e1',
                        borderColor: 'rgba(255, 255, 255, 0.12)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: function (context) {
                                return ' تعداد کل: ' + new Intl.NumberFormat('fa-IR').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        border: { display: false },
                        ticks: {
                            color: '#94a3b8',
                            font: { weight: '500' }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.04)',
                            drawBorder: false
                        },
                        border: { display: false, dash: [4, 4] },
                        ticks: {
                            color: '#64748b',
                            precision: 0,
                            callback: function (value) {
                                return new Intl.NumberFormat('fa-IR').format(value);
                            }
                        }
                    }
                }
            }
        });
    }

    createComparisonChart('totals');

    comparisonMode.addEventListener('change', function () {
        createComparisonChart(this.value);
    });

    // Donut Chart - پشتیبانی‌ها
    const supportCanvas = document.getElementById('supportChart');

    new Chart(supportCanvas, {
        type: 'doughnut',
        data: {
            labels: ['پشتیبانی فعال', 'منقضی‌شده', 'در آستانه انقضا'],
            datasets: [{
                data: [
                    @json($activeSupportChart),
                    @json($expiredSupportChart),
                    @json($expiringSupportChart)
                ],
                backgroundColor: [
                    '#10b981',
                    '#f43f5e',
                    '#f59e0b'
                ],
                borderColor: '#0b0f19',
                borderWidth: 5,
                hoverOffset: 6,
                borderRadius: 4,
                spacing: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '76%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    rtl: true,
                    backgroundColor: 'rgba(11, 15, 25, 0.94)',
                    titleColor: '#ffffff',
                    bodyColor: '#cbd5e1',
                    borderColor: 'rgba(255, 255, 255, 0.12)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    callbacks: {
                        label: function (context) {
                            return ' ' + context.label + ': ' +
                                new Intl.NumberFormat('fa-IR').format(context.raw);
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush

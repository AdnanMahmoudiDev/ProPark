
@extends('admin.layout.app')

@section('title', 'مانیتورینگ سیستم')

@section('content')
@php
    $ramPercentage = min(100, max(0, (float) ($ram['percentage'] ?? 0)));
    $diskPercentage = min(100, max(0, (float) ($disk['percentage'] ?? 0)));

    $ramColor = $ramPercentage > 85
        ? 'red'
        : ($ramPercentage > 65 ? 'amber' : 'blue');

    $diskColor = $diskPercentage > 85
        ? 'red'
        : ($diskPercentage > 65 ? 'amber' : 'indigo');

    $dbIsHealthy = ($dbStatus ?? null) === 'ok';

    $responseStatus = ($responseTime ?? 0) < 200
        ? 'عالی'
        : (($responseTime ?? 0) < 500 ? 'قابل قبول' : 'نیازمند بررسی');

    $responseColor = ($responseTime ?? 0) < 200
        ? 'emerald'
        : (($responseTime ?? 0) < 500 ? 'amber' : 'red');
@endphp

<div class="space-y-6 pb-8">

    {{-- هدر اصلی --}}
    <section class="relative isolate overflow-hidden rounded-3xl border border-gray-800 bg-gray-900 shadow-2xl shadow-black/10">
        <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -right-20 -top-32 h-72 w-72 rounded-full bg-blue-600/10 blur-3xl"></div>
            <div class="absolute -bottom-32 left-1/4 h-64 w-64 rounded-full bg-violet-600/10 blur-3xl"></div>
            <div class="absolute inset-0 bg-gradient-to-l from-blue-500/[0.04] via-transparent to-violet-500/[0.04]"></div>
        </div>

        <div class="flex flex-col gap-6 p-5 sm:p-7 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-blue-400/20 bg-blue-500/10 text-blue-400 shadow-lg shadow-blue-950/20">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 3v18h18M7 14l4-4 4 4 6-7"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2">
                        <h1 class="text-xl font-extrabold tracking-tight text-white sm:text-2xl">
                            مرکز مانیتورینگ
                        </h1>

                        <span class="rounded-lg border border-blue-400/20 bg-blue-500/10 px-2 py-1 text-[10px] font-bold tracking-wider text-blue-300">
                            SYSTEM OVERVIEW
                        </span>
                    </div>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-400">
                        وضعیت منابع سرور، سلامت پایگاه داده، عملکرد برنامه و آمار ترافیک سایت را در یک نگاه بررسی کن.
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-gray-500">
                        <span class="inline-flex items-center gap-2">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full {{ $dbIsHealthy ? 'bg-emerald-400' : 'bg-red-400' }} opacity-50"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full {{ $dbIsHealthy ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                            </span>
                            {{ $dbIsHealthy ? 'اتصال دیتابیس برقرار است' : 'دیتابیس نیازمند بررسی است' }}
                        </span>

                        <span class="hidden h-3 w-px bg-gray-700 sm:block"></span>

                        <span class="inline-flex items-center gap-1.5">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            آخرین بارگذاری:
                            <span id="lastUpdatedAt" class="text-gray-300">همین لحظه</span>
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 lg:justify-end">
                <div class="inline-flex items-center gap-2 rounded-xl border {{ $dbIsHealthy ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-300' : 'border-red-500/20 bg-red-500/10 text-red-300' }} px-3 py-2 text-xs font-semibold">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($dbIsHealthy)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    {{ $dbIsHealthy ? 'سرویس دیتابیس سالم' : 'اختلال دیتابیس' }}
                </div>

                <button
                    type="button"
                    onclick="window.location.reload()"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg shadow-blue-950/30 transition hover:bg-blue-500 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 focus:ring-offset-gray-900"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v5h5M20 20v-5h-5M5.6 9a7 7 0 0111.8-2L20 9M4 15l2.6 2a7 7 0 0011.8-2"/>
                    </svg>
                    بروزرسانی اطلاعات
                </button>
            </div>
        </div>
    </section>

    {{-- آمار بازدید --}}
    <section class="space-y-4">
        <div class="flex items-center gap-3">
            <div class="h-5 w-1 rounded-full bg-blue-500"></div>
            <h2 class="text-base font-bold text-white">نمای کلی ترافیک</h2>
            <span class="text-xs text-gray-500">Traffic Analytics</span>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            {{-- بازدید صفحات --}}
            <div class="group relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/80 p-5 transition duration-300 hover:border-blue-500/30 hover:bg-gray-900">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-blue-500/[0.06] blur-2xl transition group-hover:bg-blue-500/10"></div>

                <div class="relative flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-gray-400">مجموع بازدید صفحات</p>
                        <p class="mt-1 text-[11px] text-gray-600">TOTAL PAGE VIEWS</p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-blue-500/15 bg-blue-500/10 text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z"/>
                            <circle cx="12" cy="12" r="3" stroke-width="1.7"/>
                        </svg>
                    </div>
                </div>

                <div class="relative mt-5 flex items-end justify-between gap-3">
                    <div>
                        <p class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            {{ number_format($totalVisits) }}
                        </p>
                        <p class="mt-2 text-xs text-gray-500">مجموع بازدیدهای ثبت‌شده</p>
                    </div>

                    <span class="mb-1 inline-flex items-center gap-1 rounded-lg bg-blue-500/10 px-2.5 py-1.5 text-xs font-semibold text-blue-300">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M13 6l6 6-6 6"/>
                        </svg>
                        بازدید
                    </span>
                </div>
            </div>

            {{-- کاربران یکتا --}}
            <div class="group relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/80 p-5 transition duration-300 hover:border-violet-500/30 hover:bg-gray-900">
                <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-violet-500/[0.06] blur-2xl transition group-hover:bg-violet-500/10"></div>

                <div class="relative flex items-start justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-gray-400">بازدیدکنندگان یکتا</p>
                        <p class="mt-1 text-[11px] text-gray-600">UNIQUE VISITORS</p>
                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-violet-500/15 bg-violet-500/10 text-violet-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M10 11a4 4 0 100-8 4 4 0 000 8zM20 8v6m3-3h-6"/>
                        </svg>
                    </div>
                </div>

                <div class="relative mt-5 flex items-end justify-between gap-3">
                    <div>
                        <p class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                            {{ number_format($uniqueVisitors) }}
                        </p>
                        <p class="mt-2 text-xs text-gray-500">بر اساس IPهای ثبت‌شده</p>
                    </div>

                    <span class="mb-1 inline-flex items-center gap-1 rounded-lg bg-violet-500/10 px-2.5 py-1.5 text-xs font-semibold text-violet-300">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12h18M13 6l6 6-6 6"/>
                        </svg>
                        کاربر
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- منابع سرور --}}
    <section class="space-y-4">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="h-5 w-1 rounded-full bg-violet-500"></div>
                <h2 class="text-base font-bold text-white">سلامت زیرساخت</h2>
            </div>

            <span class="rounded-lg border border-gray-800 bg-gray-900 px-3 py-1.5 text-[11px] text-gray-400">
                Server Health
            </span>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

            {{-- RAM --}}
            <div class="rounded-2xl border border-gray-800 bg-gray-900/80 p-5 transition duration-300 hover:border-blue-500/30">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="5" y="6" width="14" height="12" rx="2" stroke-width="1.7"/>
                                <path stroke-linecap="round" stroke-width="1.7" d="M9 3v3m6-3v3M9 18v3m6-3v3M2 10h3m-3 4h3m14-4h3m-3 4h3M9 10h6v4H9z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">حافظه RAM</h3>
                            <p class="mt-0.5 text-[11px] text-gray-500">Memory Usage</p>
                        </div>
                    </div>

                    <span class="rounded-md px-2 py-1 text-[10px] font-bold
                        {{ $ramColor === 'red' ? 'bg-red-500/10 text-red-400' : ($ramColor === 'amber' ? 'bg-amber-500/10 text-amber-400' : 'bg-blue-500/10 text-blue-400') }}">
                        {{ $ramPercentage > 85 ? 'بالا' : ($ramPercentage > 65 ? 'متوسط' : 'عادی') }}
                    </span>
                </div>

                <div class="mt-6 flex items-end justify-between gap-2">
                    <p class="text-3xl font-extrabold text-white">
                        {{ number_format($ramPercentage, 1) }}<span class="text-lg text-gray-400">%</span>
                    </p>
                    <p class="pb-1 text-xs text-gray-500">
                        {{ $ram['used'] ?? 0 }} / {{ $ram['total'] ?? 0 }} GB
                    </p>
                </div>

                <div class="mt-4 h-2 overflow-hidden rounded-full bg-gray-800">
                    <div
                        class="h-full rounded-full transition-all duration-700
                            {{ $ramColor === 'red' ? 'bg-gradient-to-r from-red-600 to-red-400' : ($ramColor === 'amber' ? 'bg-gradient-to-r from-amber-600 to-amber-400' : 'bg-gradient-to-r from-blue-600 to-cyan-400') }}"
                        style="width: {{ $ramPercentage }}%"
                        role="progressbar"
                        aria-label="مصرف RAM"
                        aria-valuenow="{{ $ramPercentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>

                <div class="mt-3 flex justify-between text-[10px] text-gray-600">
                    <span>۰٪</span>
                    <span>ظرفیت استفاده‌شده</span>
                    <span>۱۰۰٪</span>
                </div>
            </div>

            {{-- Disk --}}
            <div class="rounded-2xl border border-gray-800 bg-gray-900/80 p-5 transition duration-300 hover:border-indigo-500/30">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <ellipse cx="12" cy="5" rx="8.5" ry="3" stroke-width="1.7"/>
                                <path stroke-linecap="round" stroke-width="1.7" d="M3.5 5v14c0 1.66 3.81 3 8.5 3s8.5-1.34 8.5-3V5M3.5 12c0 1.66 3.81 3 8.5 3s8.5-1.34 8.5-3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">فضای دیسک</h3>
                            <p class="mt-0.5 text-[11px] text-gray-500">Disk Usage</p>
                        </div>
                    </div>

                    <span class="rounded-md px-2 py-1 text-[10px] font-bold
                        {{ $diskColor === 'red' ? 'bg-red-500/10 text-red-400' : ($diskColor === 'amber' ? 'bg-amber-500/10 text-amber-400' : 'bg-indigo-500/10 text-indigo-400') }}">
                        {{ $diskPercentage > 85 ? 'بالا' : ($diskPercentage > 65 ? 'متوسط' : 'عادی') }}
                    </span>
                </div>

                <div class="mt-6 flex items-end justify-between gap-2">
                    <p class="text-3xl font-extrabold text-white">
                        {{ number_format($diskPercentage, 1) }}<span class="text-lg text-gray-400">%</span>
                    </p>
                    <p class="pb-1 text-xs text-gray-500">
                        {{ $disk['used'] ?? 0 }} / {{ $disk['total'] ?? 0 }} GB
                    </p>
                </div>

                <div class="mt-4 h-2 overflow-hidden rounded-full bg-gray-800">
                    <div
                        class="h-full rounded-full transition-all duration-700
                            {{ $diskColor === 'red' ? 'bg-gradient-to-r from-red-600 to-red-400' : ($diskColor === 'amber' ? 'bg-gradient-to-r from-amber-600 to-amber-400' : 'bg-gradient-to-r from-indigo-600 to-violet-400') }}"
                        style="width: {{ $diskPercentage }}%"
                        role="progressbar"
                        aria-label="مصرف فضای دیسک"
                        aria-valuenow="{{ $diskPercentage }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    ></div>
                </div>

                <div class="mt-3 flex justify-between text-[10px] text-gray-600">
                    <span>۰٪</span>
                    <span>ظرفیت استفاده‌شده</span>
                    <span>۱۰۰٪</span>
                </div>
            </div>

            {{-- Database --}}
            <div class="rounded-2xl border border-gray-800 bg-gray-900/80 p-5 transition duration-300 hover:border-emerald-500/30">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl
                            {{ $dbIsHealthy ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <ellipse cx="12" cy="5" rx="8.5" ry="3" stroke-width="1.7"/>
                                <path stroke-linecap="round" stroke-width="1.7" d="M3.5 5v14c0 1.66 3.81 3 8.5 3s8.5-1.34 8.5-3V5M3.5 12c0 1.66 3.81 3 8.5 3s8.5-1.34 8.5-3"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">پایگاه داده</h3>
                            <p class="mt-0.5 text-[11px] text-gray-500">Database Health</p>
                        </div>
                    </div>

                    <span class="h-2.5 w-2.5 rounded-full {{ $dbIsHealthy ? 'bg-emerald-400 shadow-lg shadow-emerald-500/30' : 'bg-red-400 shadow-lg shadow-red-500/30' }}"></span>
                </div>

                <div class="mt-6">
                    <p class="text-xl font-extrabold {{ $dbIsHealthy ? 'text-emerald-400' : 'text-red-400' }}">
                        {{ $dbIsHealthy ? 'اتصال برقرار' : 'خطای اتصال' }}
                    </p>
                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        {{ $dbIsHealthy ? 'اتصال آزمایشی پایگاه داده موفق بوده است.' : 'اتصال آزمایشی پایگاه داده با خطا مواجه شده است.' }}
                    </p>
                </div>

                <div class="mt-5 flex items-center justify-between border-t border-gray-800 pt-4">
                    <span class="text-xs text-gray-500">زمان تست اتصال</span>
                    <span class="font-mono text-sm font-bold {{ $dbIsHealthy ? 'text-emerald-300' : 'text-red-300' }}">
                        {{ number_format((float) ($dbLatency ?? 0), 2) }} ms
                    </span>
                </div>
            </div>

            {{-- Response Time --}}
            <div class="rounded-2xl border border-gray-800 bg-gray-900/80 p-5 transition duration-300 hover:border-violet-500/30">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-500/10 text-violet-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M13 2L4 14h7l-1 8 10-12h-7l1-8z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">زمان پاسخگویی</h3>
                            <p class="mt-0.5 text-[11px] text-gray-500">Response Time</p>
                        </div>
                    </div>

                    <span class="rounded-md px-2 py-1 text-[10px] font-bold
                        {{ $responseColor === 'emerald' ? 'bg-emerald-500/10 text-emerald-400' : ($responseColor === 'amber' ? 'bg-amber-500/10 text-amber-400' : 'bg-red-500/10 text-red-400') }}">
                        {{ $responseStatus }}
                    </span>
                </div>

                <div class="mt-6">
                    <p class="text-3xl font-extrabold text-white">
                        {{ number_format((float) ($responseTime ?? 0), 2) }}
                        <span class="text-base font-semibold text-gray-400">ms</span>
                    </p>
                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        زمان پردازش اندازه‌گیری‌شده در برنامه
                    </p>
                </div>

                <div class="mt-5 flex items-center justify-between border-t border-gray-800 pt-4">
                    <span class="text-xs text-gray-500">معیار نمایشی</span>
                    <span class="text-xs font-semibold {{ $responseColor === 'emerald' ? 'text-emerald-400' : ($responseColor === 'amber' ? 'text-amber-400' : 'text-red-400') }}">
                        {{ $responseStatus }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- نمودار بازدیدها --}}
    <section class="overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/80 shadow-xl shadow-black/10">
        <div class="flex flex-col gap-4 border-b border-gray-800 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl border border-blue-500/15 bg-blue-500/10 text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 3v18h18M7 14l4-4 4 4 6-7"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-white sm:text-lg">
                        روند ترافیک سایت
                    </h2>
                    <p class="mt-1 text-xs leading-5 text-gray-500">
                        مقایسه بازدید صفحات و بازدیدکنندگان یکتا در شش ماه اخیر
                    </p>
                </div>
            </div>

            <div class="rounded-xl border border-gray-800 bg-gray-950/60 px-4 py-3">
                <p class="text-[11px] text-gray-500">کل بازدید در دوره نمایش‌داده‌شده</p>
                <p class="mt-1 text-lg font-extrabold text-blue-400">
                    {{ number_format(array_sum($monthlyVisits['views'] ?? [])) }}
                    <span class="text-xs font-medium text-gray-500">بازدید</span>
                </p>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            <div class="mb-5 flex flex-wrap items-center gap-x-5 gap-y-3">
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <span class="h-2.5 w-2.5 rounded-full bg-blue-400"></span>
                    بازدید صفحات
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-400">
                    <span class="h-2.5 w-2.5 rounded-full bg-violet-400"></span>
                    بازدیدکنندگان یکتا
                </div>
            </div>

            <div class="relative h-64 w-full sm:h-80">
                <canvas id="visitsChart" aria-label="نمودار مقایسه بازدید صفحات و کاربران یکتا" role="img"></canvas>
            </div>

            <div class="mt-5 flex items-start gap-2 rounded-xl border border-gray-800/80 bg-gray-950/40 p-3.5">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 9v4m0 4h.01M10.3 3.86L1.82 18.5A2 2 0 003.55 21h16.9a2 2 0 001.73-2.5L13.7 3.86a2 2 0 00-3.4 0z"/>
                </svg>
                <p class="text-[11px] leading-5 text-gray-500">
                    این نمودار بر اساس داده‌های ارسالی کنترلر ساخته می‌شود. دقت آمار کاربران یکتا به روش ثبت و تجمیع داده‌ها در برنامه وابسته است.
                </p>
            </div>
        </div>
    </section>

    {{-- خلاصه وضعیت --}}
    <section class="rounded-2xl border border-gray-800 bg-gradient-to-l from-gray-900 via-gray-900 to-gray-950 p-5 sm:p-6">
        <div class="flex items-start gap-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl
                {{ $dbIsHealthy && $ramPercentage <= 85 && $diskPercentage <= 85 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-amber-500/10 text-amber-400' }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($dbIsHealthy && $ramPercentage <= 85 && $diskPercentage <= 85)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 13l4 4L19 7"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v4m0 4h.01M10.3 3.86L1.82 18.5A2 2 0 003.55 21h16.9a2 2 0 001.73-2.5L13.7 3.86a2 2 0 00-3.4 0z"/>
                    @endif
                </svg>
            </div>

            <div class="min-w-0 flex-1">
                <h2 class="font-bold text-white">خلاصه وضعیت منابع</h2>

                <p class="mt-1 text-sm leading-6 text-gray-400">
                    @if(!$dbIsHealthy)
                        اتصال پایگاه داده با مشکل مواجه است. تنظیمات اتصال و گزارش‌های برنامه را بررسی کن.
                    @elseif($ramPercentage > 85 || $diskPercentage > 85)
                        میزان مصرف {{ $ramPercentage > 85 && $diskPercentage > 85 ? 'حافظه RAM و فضای دیسک' : ($ramPercentage > 85 ? 'حافظه RAM' : 'فضای دیسک') }} بالاست. وضعیت منابع سرور را بررسی کن.
                    @elseif($ramPercentage > 65 || $diskPercentage > 65)
                        مصرف بخشی از منابع از حد معمول بالاتر رفته است. بهتر است روند مصرف را زیر نظر داشته باشی.
                    @else
                        بر اساس مقادیر فعلی، اتصال دیتابیس برقرار است و مصرف RAM و دیسک از آستانه هشدار عبور نکرده است.
                    @endif
                </p>

                <p class="mt-2 text-[11px] leading-5 text-gray-600">
                    این جمع‌بندی صرفاً بر اساس مقادیر دریافتی و آستانه‌های نمایشی این صفحه محاسبه می‌شود؛ جایگزین سامانه پایش و هشداردهی سرور نیست.
                </p>
            </div>
        </div>
    </section>

</div>

{{-- کتابخانه نمودار --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const updatedAt = document.getElementById('lastUpdatedAt');

    if (updatedAt) {
        updatedAt.textContent = new Intl.DateTimeFormat('fa-IR', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        }).format(new Date());
    }

    const canvas = document.getElementById('visitsChart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    const labels = @json($monthlyVisits['labels'] ?? []);
    const views = @json($monthlyVisits['views'] ?? []);
    const uniques = @json($monthlyVisits['uniques'] ?? []);

    const chartContext = canvas.getContext('2d');

    const viewsGradient = chartContext.createLinearGradient(0, 0, 0, 320);
    viewsGradient.addColorStop(0, 'rgba(59, 130, 246, 0.22)');
    viewsGradient.addColorStop(1, 'rgba(59, 130, 246, 0.00)');

    const uniquesGradient = chartContext.createLinearGradient(0, 0, 0, 320);
    uniquesGradient.addColorStop(0, 'rgba(167, 139, 250, 0.17)');
    uniquesGradient.addColorStop(1, 'rgba(167, 139, 250, 0.00)');

    new Chart(chartContext, {
        type: 'line',

        data: {
            labels: labels,

            datasets: [
                {
                    label: 'بازدید صفحات',
                    data: views,
                    borderColor: '#60a5fa',
                    backgroundColor: viewsGradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.38,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#60a5fa',
                    pointBorderColor: '#111827',
                    pointBorderWidth: 2
                },
                {
                    label: 'بازدیدکنندگان یکتا',
                    data: uniques,
                    borderColor: '#a78bfa',
                    backgroundColor: uniquesGradient,
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.38,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                    pointBackgroundColor: '#a78bfa',
                    pointBorderColor: '#111827',
                    pointBorderWidth: 2
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    rtl: true,
                    textDirection: 'rtl',
                    backgroundColor: '#111827',
                    titleColor: '#f9fafb',
                    bodyColor: '#d1d5db',
                    borderColor: '#374151',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true,

                    callbacks: {
                        label: function (context) {
                            const value = Number(context.parsed.y ?? 0);

                            return ' ' + context.dataset.label + ': ' +
                                new Intl.NumberFormat('fa-IR').format(value);
                        }
                    }
                }
            },

            scales: {
                x: {
                    border: {
                        display: false
                    },

                    grid: {
                        display: false
                    },

                    ticks: {
                        color: '#9ca3af',
                        font: {
                            family: 'inherit',
                            size: 11
                        },
                        maxRotation: 0,
                        autoSkip: true
                    }
                },

                y: {
                    beginAtZero: true,

                    border: {
                        display: false,
                        dash: [4, 4]
                    },

                    grid: {
                        color: 'rgba(75, 85, 99, 0.18)',
                        drawTicks: false
                    },

                    ticks: {
                        color: '#9ca3af',
                        padding: 12,
                        precision: 0,
                        font: {
                            family: 'inherit',
                            size: 10
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection

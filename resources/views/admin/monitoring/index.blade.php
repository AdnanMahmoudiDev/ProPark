@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- هدر صفحه و دکمه بازخوانی --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white">مانیتورینگ سایت و سرور</h1>
            <p class="mt-1 text-sm text-gray-400">بررسی آنی منابع سخت‌افزاری، سلامت دیتابیس، کانتینرها و بازدیدها</p>
        </div>

        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-medium text-emerald-400">
                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
                وضعیت زنده سیستم
            </span>

            <button
                type="button"
                onclick="window.location.reload()"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-700 bg-gray-800 px-3.5 py-2 text-xs font-semibold text-gray-200 transition hover:bg-gray-700"
            >
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                بروزرسانی داده‌ها
            </button>
        </div>
    </div>

    {{-- کارت‌های آمار بازدید --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

        {{-- مجموع Page Views --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-5 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">مجموع صفحات بازدیدشده (Page Views)</span>
                <div class="rounded-xl bg-blue-500/10 p-2 text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-3xl font-bold text-white">
                {{ number_format($totalVisits) }}
            </div>
            <p class="mt-2 text-xs text-gray-500">مجموع بازدیدهای ثبت‌شده در دیتابیس</p>
        </div>

        {{-- مجموع Unique Visitors --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-5 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">بازدیدکنندگان یکتا (Unique Visitors)</span>
                <div class="rounded-xl bg-violet-500/10 p-2 text-violet-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12 0v-2a4 4 0 00-3-3.87M12 7a4 4 0 11-8 0 4 4 0 018 0zm7 4a4 4 0 100-8" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 text-3xl font-bold text-white">
                {{ number_format($uniqueVisitors) }}
            </div>
            <p class="mt-2 text-xs text-gray-500">برآورد کاربران یکتا بر اساس IP ثبت‌شده</p>
        </div>

    </div>

    {{-- کارت‌های شاخص‌های اصلی سرور --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

        {{-- مصرف رم سرور --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-5 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">مصرف رم (RAM)</span>
                <div class="rounded-xl bg-blue-500/10 p-2 text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M3 9h2m-2 6h2m16-6h2m-2 6h2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <span class="text-2xl font-bold text-white">{{ $ram['percentage'] }}%</span>
                    <span class="text-xs text-gray-400">{{ $ram['used'] }}GB از {{ $ram['total'] }}GB</span>
                </div>
                <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-800">
                    <div
                        class="h-full rounded-full transition-all duration-500 {{ $ram['percentage'] > 85 ? 'bg-red-500' : ($ram['percentage'] > 65 ? 'bg-amber-500' : 'bg-blue-500') }}"
                        style="width: {{ min($ram['percentage'], 100) }}%"
                    ></div>
                </div>
            </div>
        </div>

        {{-- فضای دیسک سرور --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-5 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">فضای دیسک (Disk)</span>
                <div class="rounded-xl bg-indigo-500/10 p-2 text-indigo-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <span class="text-2xl font-bold text-white">{{ $disk['percentage'] }}%</span>
                    <span class="text-xs text-gray-400">{{ $disk['used'] }}GB از {{ $disk['total'] }}GB</span>
                </div>
                <div class="mt-3 h-2 w-full overflow-hidden rounded-full bg-gray-800">
                    <div
                        class="h-full rounded-full transition-all duration-500 {{ $disk['percentage'] > 85 ? 'bg-red-500' : ($disk['percentage'] > 65 ? 'bg-amber-500' : 'bg-indigo-500') }}"
                        style="width: {{ min($disk['percentage'], 100) }}%"
                    ></div>
                </div>
            </div>
        </div>

        {{-- سلامت دیتابیس --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-5 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">وضعیت اتصال به دیتابیس</span>
                <div class="rounded-xl p-2 {{ $dbStatus === 'ok' ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 3.5 3 8 3s8-1 8-3V7M4 7c0 2 3.5 3 8 3s8-1 8-3M4 7c0-2 3.5-3 8-3s8 1-8 3" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <span class="text-2xl font-bold {{ $dbStatus === 'ok' ? 'text-emerald-400' : 'text-red-400' }}">
                        {{ $dbStatus === 'ok' ? 'متصل و پایدار' : 'خطای اتصال' }}
                    </span>
                    <span class="font-mono text-xs text-gray-400">{{ $dbLatency }} ms</span>
                </div>
                <p class="mt-2 text-xs text-gray-500">زمان تست اتصال مستقیم PDO به پایگاه داده</p>
            </div>
        </div>

        {{-- زمان پاسخگویی سرور --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-5 shadow-lg backdrop-blur-md">
            <div class="flex items-center justify-between">
                <span class="text-xs font-medium text-gray-400">زمان پاسخگویی سرور</span>
                <div class="rounded-xl bg-violet-500/10 p-2 text-violet-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline justify-between">
                    <span class="font-mono text-2xl font-bold text-white">{{ $responseTime }}</span>
                    <span class="text-xs text-gray-400">میلی‌ثانیه (ms)</span>
                </div>
                <p class="mt-2 text-xs text-gray-500">زمان پردازش داخلی کنترلر و فریم‌ورک</p>
            </div>
        </div>

    </div>

    {{-- نمودار بازدیدها و وضعیت داکر --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- نمودار آمار بازدیدهای ماهانه --}}
        <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-6 shadow-lg backdrop-blur-md lg:col-span-2">
            <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white">آمار و مقایسه بازدید ماه‌های اخیر</h2>
                    <p class="text-xs text-gray-400">روند Page Views و بازدیدکنندگان یکتا در شش ماه اخیر</p>
                </div>

                <div class="text-left sm:text-right">
                    <div class="text-xs text-gray-400">مجموع بازدید صفحات در این دوره:</div>
                    <div class="mt-1 text-sm font-bold text-blue-400">
                        {{ number_format(array_sum($monthlyVisits['views'])) }}
                    </div>
                </div>
            </div>

            <div class="relative h-72 w-full">
                <canvas id="visitsChart"></canvas>
            </div>
        </div>

        {{-- وضعیت داکرها --}}
        <div class="flex flex-col justify-between rounded-2xl border border-gray-800 bg-gray-900/60 p-6 shadow-lg backdrop-blur-md">
            <div>
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-white">کانتینرهای داکر</h2>
                    <span class="rounded-lg border border-gray-700 bg-gray-800 px-2 py-1 font-mono text-[11px] text-gray-300">
                        {{ count($dockerContainers) }} Container
                    </span>
                </div>

                @if (!$dockerAvailable)
                    <div class="rounded-xl border border-amber-500/20 bg-amber-500/10 p-4 text-xs text-amber-300">
                        سرویس داکر در این محیط اجرا نیست یا وب‌سرور دسترسی مستقیم به سوکت <code>docker.sock</code> ندارد.
                    </div>
                @elseif (empty($dockerContainers))
                    <div class="rounded-xl border border-gray-800 bg-gray-800/40 p-4 text-center text-xs text-gray-400">
                        هیچ کانتینری یافت نشد.
                    </div>
                @else
                    <div class="max-h-72 space-y-3 overflow-y-auto pr-1">
                        @foreach ($dockerContainers as $container)
                            <div class="rounded-xl border border-gray-800 bg-gray-800/40 p-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-semibold text-white">{{ $container['name'] }}</span>
                                    <span class="inline-flex items-center gap-1 rounded-full border px-2 py-0.5 text-[10px] font-medium {{ $container['is_running'] ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-400' : 'border-red-500/20 bg-red-500/10 text-red-400' }}">
                                        {{ $container['is_running'] ? 'فعال' : 'متوقف' }}
                                    </span>
                                </div>
                                <div class="mt-2 truncate font-mono text-[11px] text-gray-400">
                                    {{ $container['image'] }}
                                </div>
                                <div class="mt-1 text-[10px] text-gray-500">
                                    {{ $container['status'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-4 flex items-center justify-between border-t border-gray-800 pt-4 text-[11px] text-gray-400">
                <span class="font-mono text-blue-400">Docker Engine</span>
            </div>
        </div>

    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('visitsChart');

        if (!canvas) {
            return;
        }

        const ctx = canvas.getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyVisits['labels']),
                datasets: [
                    {
                        label: 'بازدید صفحات (Page Views)',
                        data: @json($monthlyVisits['views']),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.12)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.35,
                        pointBackgroundColor: '#60a5fa',
                        pointBorderColor: '#1e293b',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'بازدیدکنندگان یکتا (Unique Visitors)',
                        data: @json($monthlyVisits['uniques']),
                        borderColor: '#a78bfa',
                        backgroundColor: 'rgba(167, 139, 250, 0.12)',
                        borderWidth: 2,
                        fill: false,
                        tension: 0.35,
                        pointBackgroundColor: '#c4b5fd',
                        pointBorderColor: '#1e293b',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        align: 'end',
                        labels: {
                            color: '#cbd5e1',
                            usePointStyle: true,
                            pointStyle: 'circle',
                            padding: 16,
                            font: {
                                family: 'inherit',
                                size: 11
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        titleColor: '#f8fafc',
                        bodyColor: '#cbd5e1',
                        borderColor: '#334155',
                        borderWidth: 1,
                        padding: 10,
                        rtl: true,
                        textDirection: 'rtl'
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(51, 65, 85, 0.3)'
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                family: 'inherit',
                                size: 11
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(51, 65, 85, 0.3)'
                        },
                        ticks: {
                            precision: 0,
                            color: '#94a3b8',
                            font: {
                                family: 'inherit',
                                size: 11
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection

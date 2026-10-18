@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- ================= هدر صفحه حساب‌کتاب مالی ================= --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        
        {{-- افکت هاله نوری آبی تمیز --}}
        <div class="pointer-events-none absolute -top-16 left-1/2 -translate-x-1/2 h-32 w-[550px] rounded-full bg-blue-500/15 blur-3xl"></div>

        <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-blue-500/30 bg-blue-500/10 text-blue-400 shadow-inner shadow-blue-500/20">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                            {{ __('حساب‌کتاب و تحلیل درآمدهای وصول‌شده') }}
                        </h1>
                        <span class="inline-flex items-center gap-1 rounded-full border border-blue-500/30 bg-blue-500/10 px-2.5 py-0.5 text-[11px] font-semibold text-blue-400">
                            {{ __('تسویه‌شده') }}
                        </span>
                    </div>
                    <p class="mt-0.5 text-xs text-gray-400 sm:text-sm">
                        {{ __('بررسی جامع شاخص‌های درآمدی کل، سالانه، ۶ ماهه، ۳۰ روز گذشته و نمودارهای تحلیلی') }}
                    </p>
                </div>
            </div>

            {{-- دکمه بازگشت به دفتر فاکتورها --}}
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.invoices.index') }}" 
                   class="inline-flex items-center gap-2 rounded-2xl border border-gray-800 bg-gray-900/80 px-4 py-2.5 text-xs font-semibold text-gray-300 backdrop-blur-md transition duration-200 hover:border-gray-700 hover:bg-gray-800 hover:text-white">
                    <svg class="h-4 w-4 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>{{ __('بازگشت به فاکتورها') }}</span>
                </a>
            </div>
        </div>

        {{-- ۴ کارت کلیدی بازه‌های زمانی درآمد --}}
        <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            
            {{-- کارت ۱: مجموع درآمد کل --}}
            <div class="relative overflow-hidden rounded-2xl border border-blue-500/30 bg-gradient-to-br from-blue-950/40 via-gray-900/60 to-gray-900/40 p-4 shadow-lg shadow-blue-950/30">
                <div class="flex items-center justify-between text-xs text-blue-300 font-medium">
                    <span>{{ __('مجموع کل درآمد (تمام دوران)') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-500/20 text-blue-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <div class="font-mono text-2xl font-black text-white">
                        {{ number_format($totalRevenue) }}
                    </div>
                    <div class="mt-1 flex items-center justify-between text-[11px] text-gray-400">
                        <span>تومان</span>
                        <span class="font-mono text-blue-400">{{ number_format($totalPaidCount) }} فاکتور پرداخت‌شده</span>
                    </div>
                </div>
            </div>

            {{-- کارت ۲: درآمد سال اخیر --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-blue-500/40">
                <div class="flex items-center justify-between text-xs text-gray-400 font-medium">
                    <span>{{ __('درآمد سال اخیر (۱۲ ماه گذشته)') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-800 text-gray-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <div class="font-mono text-2xl font-black text-white">
                        {{ number_format($yearRevenue) }}
                    </div>
                    <div class="mt-1 flex items-center justify-between text-[11px] text-gray-500">
                        <span>تومان</span>
                        <span>{{ $totalRevenue > 0 ? round(($yearRevenue / $totalRevenue) * 100) : 0 }}% از کل درآمد</span>
                    </div>
                </div>
            </div>

            {{-- کارت ۳: درآمد ۶ ماه اخیر --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-blue-500/40">
                <div class="flex items-center justify-between text-xs text-gray-400 font-medium">
                    <span>{{ __('درآمد ۶ ماه اخیر') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gray-800 text-gray-300">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <div class="font-mono text-2xl font-black text-white">
                        {{ number_format($sixMonthsRevenue) }}
                    </div>
                    <div class="mt-1 flex items-center justify-between text-[11px] text-gray-500">
                        <span>تومان</span>
                        <span>نیم‌سال اخیر</span>
                    </div>
                </div>
            </div>

            {{-- کارت ۴: درآمد ۳۰ روز اخیر (ماه اخیر) --}}
            <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-emerald-500/40">
                <div class="flex items-center justify-between text-xs text-emerald-400 font-medium">
                    <span>{{ __('درآمد ماه اخیر (۳۰ روز گذشته)') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-500/10 text-emerald-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <div class="font-mono text-2xl font-black text-white">
                        {{ number_format($monthRevenue) }}
                    </div>
                    <div class="mt-1 flex items-center justify-between text-[11px] text-gray-500">
                        <span>تومان</span>
                        <span class="font-mono text-emerald-400">میانگین هر سفارش: {{ number_format($averageOrderValue) }} تومان</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ================= بخش نمودار روند ماهانه + تفکیک پکیج‌ها ================= --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        
        {{-- ستون راست (۲ ستون): چارت تعاملی درآمد ۶ ماه اخیر --}}
        <div class="lg:col-span-2 rounded-3xl border border-gray-800/80 bg-gray-950/60 p-5 sm:p-6 backdrop-blur-xl shadow-xl">
            <div class="flex items-center justify-between border-b border-gray-800/80 pb-4">
                <div>
                    <h2 class="text-base font-bold text-white">{{ __('روند درآمد وصول‌شده در ۶ ماه گذشته') }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('بررسی صعودی یا نزولی بودن فروش در ماه‌های اخیر') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-lg border border-blue-500/30 bg-blue-500/10 px-2.5 py-1 text-xs font-mono text-blue-400">
                        <span class="h-2 w-2 rounded-full bg-blue-400 animate-pulse"></span>
                        {{ __('نمودار درآمد') }}
                    </span>
                </div>
            </div>

            {{-- کانتینر نمودار Chart.js --}}
            <div class="mt-6 relative h-72 sm:h-80 w-full">
                <canvas id="revenueMonthlyChart"></canvas>
            </div>
        </div>

        {{-- ستون چپ (۱ ستون): سهم پکیج‌ها و محصولات از درآمد --}}
        <div class="rounded-3xl border border-gray-800/80 bg-gray-950/60 p-5 sm:p-6 backdrop-blur-xl shadow-xl flex flex-col justify-between">
            <div>
                <div class="border-b border-gray-800/80 pb-4">
                    <h2 class="text-base font-bold text-white">{{ __('تفکیک درآمد براساس پکیج‌ها') }}</h2>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('پرفروش‌ترین خدمات و محصولات وصول‌شده') }}</p>
                </div>

                <div class="mt-5 space-y-4">
                    @forelse($packageBreakdown as $pkg)
                        @php
                            $percentage = $totalRevenue > 0 ? round(($pkg->total_amount / $totalRevenue) * 100, 1) : 0;
                        @endphp
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-white truncate max-w-[150px]">{{ $pkg->title ?? __('پکیج نامشخص') }}</span>
                                <span class="font-mono text-gray-300">{{ number_format($pkg->total_amount) }} <span class="text-[10px] text-gray-500">تومان</span></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="h-2 flex-1 overflow-hidden rounded-full bg-gray-800">
                                    <div class="h-full rounded-full bg-gradient-to-r from-blue-600 to-blue-400" style="width: {{ min($percentage, 100) }}%"></div>
                                </div>
                                <span class="w-10 text-left font-mono text-[11px] text-blue-400 font-semibold">{{ $percentage }}%</span>
                            </div>
                            <div class="text-[10px] text-gray-500">
                                {{ __('تعداد فروش موفق:') }} <span class="font-mono text-gray-400">{{ $pkg->total_sold }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-xs text-gray-500">
                            {{ __('هنوز داده‌ای برای تفکیک پکیج‌ها ثبت نشده است.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 rounded-2xl border border-gray-800/60 bg-gray-900/40 p-3.5 text-center">
                <span class="text-xs text-gray-400">{{ __('شاخص سلامت مالی:') }}</span>
                <span class="font-semibold text-emerald-400 text-xs mr-1">{{ __('دریافت آنی از درگاه مستقیم') }}</span>
            </div>
        </div>

    </div>

    {{-- ================= جدول آخرین فاکتورهای وصول‌شده ================= --}}
    <div class="overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-950/50 backdrop-blur-xl shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-800/80 px-5 py-4 sm:px-6">
            <div>
                <h3 class="text-base font-bold text-white">{{ __('آخرین فاکتورهای وصول‌شده') }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('جدیدترین دریافتی‌های سیستم به تفکیک زمان و مشخصات خریدار') }}</p>
            </div>
            <a href="{{ route('admin.invoices.index', ['status' => 'paid']) }}" 
               class="text-xs font-semibold text-blue-400 hover:text-blue-300 transition">
                {{ __('مشاهده همه پرداخت‌شده‌ها') }} &larr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="border-b border-gray-800/60 bg-gray-900/40 text-xs font-semibold text-gray-400">
                        <th class="py-3 px-4">{{ __('شماره فاکتور') }}</th>
                        <th class="py-3 px-4">{{ __('کاربر / مشتری') }}</th>
                        <th class="py-3 px-4">{{ __('مبلغ وصول‌شده') }}</th>
                        <th class="py-3 px-4">{{ __('تاریخ پرداخت') }}</th>
                        <th class="py-3 px-4 text-center">{{ __('عملیات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/40">
                    @forelse($recentPaidInvoices as $inv)
                        <tr class="transition hover:bg-gray-900/40">
                            <td class="py-3.5 px-4 font-mono text-sm font-semibold text-white whitespace-nowrap">
                                {{ $inv->order_number ?? ('ORD-' . $inv->id) }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="text-sm font-medium text-white">{{ $inv->user->name ?? __('کاربر مهمان') }}</div>
                                <div class="text-xs text-gray-400 font-mono">{{ $inv->user->phone_number ?? $inv->user->email ?? '---' }}</div>
                            </td>
                            <td class="py-3.5 px-4 font-mono font-bold text-blue-400 whitespace-nowrap">
                                {{ number_format($inv->payable_amount) }} <span class="text-xs font-normal text-gray-400">تومان</span>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-gray-300 whitespace-nowrap">
                                {{ function_exists('jdate') ? jdate($inv->created_at)->format('Y/m/d - H:i') : $inv->created_at->format('Y-m-d H:i') }}
                            </td>
                            <td class="py-3.5 px-4 text-center whitespace-nowrap">
                                <a href="{{ route('admin.invoices.show', $inv) }}" 
                                   class="inline-flex items-center gap-1 rounded-xl border border-gray-800 bg-gray-900/60 px-3 py-1.5 text-xs font-medium text-blue-400 transition hover:border-blue-500/40 hover:bg-blue-500/10">
                                    <span>{{ __('مشاهده فاکتور') }}</span>
                                    <svg class="h-3.5 w-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-xs text-gray-500">
                                {{ __('هیچ فاکتور وصول‌شده‌ای ثبت نشده است.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- اسکریپت Chart.js برای رسم نمودار حرفه‌ای درآمد ماهانه --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueMonthlyChart');
        if (!ctx) return;

        const labels = @json($chartLabels);
        const dataValues = @json($chartData);

        // گرادیانت زیبای آبی خالص برای پس‌زمینه محدوده نمودار
        const chartCtx = ctx.getContext('2d');
        const gradient = chartCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.45)'); // Blue 500
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'درآمد (تومان)',
                    data: dataValues,
                    borderColor: '#3b82f6', // Pure Blue
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#1d4ed8',
                    pointBorderColor: '#60a5fa',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        rtl: true,
                        backgroundColor: 'rgba(15, 23, 42, 0.95)',
                        titleColor: '#f8fafc',
                        bodyColor: '#60a5fa',
                        borderColor: 'rgba(59, 130, 246, 0.3)',
                        borderWidth: 1,
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('fa-IR').format(context.parsed.y) + ' تومان';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(55, 65, 81, 0.25)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: { family: 'inherit', size: 11 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(55, 65, 81, 0.25)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: { family: 'inherit', size: 11 },
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return (value / 1000000) + ' م';
                                }
                                return new Intl.NumberFormat('fa-IR').format(value);
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection

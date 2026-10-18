@extends('admin.layout.app')

@section('title', __('جزئیات فاکتور') . ' #' . $invoice->order_number)

@section('content')
<style>
    @media print {
        /* پنهان کردن تمام بخش‌های اضافی پنل در حالت چاپ */
        nav, aside, header, footer, .print\\:hidden, #sidebar, .sidebar {
            display: none !important;
        }

        body {
            background-color: #ffffff !important;
            color: #0f172a !important;
            font-size: 12px !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .printable-invoice-container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 20px !important;
            box-shadow: none !important;
            border: none !important;
            background: #ffffff !important;
        }

        .print-border {
            border: 1px solid #cbd5e1 !important;
        }

        .print-bg-gray {
            background-color: #f8fafc !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .page-break {
            page-break-inside: avoid;
        }
    }
</style>

<div class="printable-invoice-container space-y-6">

    {{-- هدر رسمی فاکتور (مخصوص حالت چاپ و سربرگ) --}}
    <div class="hidden print:flex items-center justify-between border-b-2 border-slate-900 pb-4">
        <div class="space-y-1">
            <h2 class="text-xl font-black text-slate-900">{{ config('app.name', 'AvaPark') }}</h2>
            <p class="text-xs text-slate-600">{{ __('فاکتور رسمی فروش خدمات و لایسنس نرم‌افزار') }}</p>
        </div>
        <div class="text-left font-mono text-xs space-y-1">
            <div><span class="font-bold text-slate-700">{{ __('شماره سفارش:') }}</span> #{{ $invoice->order_number }}</div>
            <div><span class="font-bold text-slate-700">{{ __('شناسه فاکتور:') }}</span> #{{ $invoice->id }}</div>
            <div><span class="font-bold text-slate-700">{{ __('تاریخ صدور:') }}</span> {{ function_exists('jdate') ? jdate($invoice->created_at)->format('Y/m/d - H:i') : $invoice->created_at->format('Y-m-d H:i') }}</div>
        </div>
    </div>

    {{-- هدر صفحه و دکمه‌های عملیاتی پنل ادمین (مخفی در پرینت) --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between print:hidden">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.invoices.index') }}"
               class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-blue-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-blue-400">
                <svg class="h-5 w-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-bold text-slate-900 dark:text-white sm:text-2xl">
                        {{ __('فاکتور') }} <span class="font-mono text-blue-600 dark:text-blue-400">#{{ $invoice->order_number }}</span>
                    </h1>
                    <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-xs font-semibold {{ $invoice->status_badge_classes }}">
                        {{ $invoice->status_label }}
                    </span>
                </div>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    {{ __('شناسه دیتابیس:') }} <span class="font-mono text-slate-700 dark:text-slate-300">#{{ $invoice->id }}</span>
                    <span class="mx-1.5 text-slate-300 dark:text-slate-700">|</span>
                    {{ __('تاریخ ثبت:') }} <span class="font-mono">{{ function_exists('jdate') ? jdate($invoice->created_at)->format('Y/m/d - H:i') : $invoice->created_at->format('Y-m-d H:i') }}</span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            {{-- دکمه با آیکون چاپگر شکیل و دقیق --}}
            <button type="button" onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50 hover:text-blue-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-blue-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24-1.07-.367-2.18-.367-3.329 0-3.313 1.87-6.19 4.647-7.653M17.28 13.829c.24-1.07.367-2.18.367-3.329 0-3.313-1.87-6.19-4.647-7.653M12 3v13.5m0 0l-3-3m3 3l3-3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2z" />
                </svg>
                <span>{{ __('چاپ فاکتور') }}</span>
            </button>
            <a href="{{ route('admin.invoices.index') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-blue-500/20 transition hover:bg-blue-700">
                <span>{{ __('بازگشت به لیست') }}</span>
            </a>
        </div>
    </div>

    {{-- کارت اطلاعات مشتری و خلاصه‌ی وضعیت مالی --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 print:grid-cols-3 print:gap-4 page-break">
        {{-- مشخصات خریدار --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 print:border print:border-slate-300 print:p-4 print:shadow-none">
            <div class="flex items-center gap-2 border-b border-slate-100 pb-3 dark:border-slate-800 print:border-slate-200 print:pb-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 print:hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white print:text-xs print:font-bold">{{ __('اطلاعات مشتری / کاربر') }}</h2>
            </div>

            <div class="mt-4 space-y-3 text-sm print:mt-2 print:space-y-1.5 print:text-xs">
                @if($invoice->user)
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-500 dark:text-slate-400 print:text-slate-600">{{ __('نام خریدار:') }}</span>
                        <span class="font-semibold text-slate-900 dark:text-slate-200 print:text-slate-900">{{ $invoice->user->name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-500 dark:text-slate-400 print:text-slate-600">{{ __('شماره تماس:') }}</span>
                        <span class="font-mono font-medium text-slate-900 dark:text-slate-200 print:text-slate-900 dir-ltr text-right">
                            {{ $invoice->user->phone_number ?? '-' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-500 dark:text-slate-400 print:text-slate-600">{{ __('ایمیل:') }}</span>
                        <span class="font-mono text-xs text-slate-700 dark:text-slate-300 print:text-slate-800">{{ $invoice->user->email }}</span>
                    </div>
                    <div class="flex items-center justify-between print:hidden">
                        <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('نقش کاربر:') }}</span>
                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            {{ ucfirst($invoice->user->role ?? 'user') }}
                        </span>
                    </div>
                @else
                    <div class="py-4 text-center text-xs text-slate-400">
                        {{ __('کاربر این فاکتور حذف شده است.') }}
                    </div>
                @endif
            </div>
        </div>

        {{-- وضعیت و جزئیات تسویه --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 print:border print:border-slate-300 print:p-4 print:shadow-none">
            <div class="flex items-center gap-2 border-b border-slate-100 pb-3 dark:border-slate-800 print:border-slate-200 print:pb-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-950/60 dark:text-blue-400 print:hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white print:text-xs print:font-bold">{{ __('اطلاعات پرداخت') }}</h2>
            </div>

            <div class="mt-4 space-y-3 text-sm print:mt-2 print:space-y-1.5 print:text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500 dark:text-slate-400 print:text-slate-600">{{ __('وضعیت فاکتور:') }}</span>
                    <span class="font-bold {{ $invoice->status === 'paid' ? 'text-emerald-600' : 'text-slate-800' }}">
                        {{ $invoice->status_label }}
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500 dark:text-slate-400 print:text-slate-600">{{ __('ارز پرداخت:') }}</span>
                    <span class="font-semibold text-slate-900 dark:text-slate-200 uppercase print:text-slate-900">{{ $invoice->currency ?? 'IRT' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-500 dark:text-slate-400 print:text-slate-600">{{ __('زمان پرداخت نهایی:') }}</span>
                    <span class="font-mono text-xs {{ $invoice->paid_at ? 'text-emerald-600 dark:text-emerald-400 font-semibold' : 'text-slate-400' }}">
                        @if($invoice->paid_at)
                            {{ function_exists('jdate') ? jdate($invoice->paid_at)->format('Y/m/d - H:i') : $invoice->paid_at->format('Y-m-d H:i') }}
                        @else
                            {{ __('پرداخت نشده') }}
                        @endif
                    </span>
                </div>
                <div class="flex items-center justify-between print:hidden">
                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ __('آخرین بروزرسانی:') }}</span>
                    <span class="font-mono text-xs text-slate-500">
                        {{ function_exists('jdate') ? jdate($invoice->updated_at)->format('Y/m/d - H:i') : $invoice->updated_at->format('Y-m-d H:i') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- تفکیک مالی فاکتور --}}
        <div class="rounded-2xl border border-blue-200/60 bg-blue-50/40 p-5 shadow-sm dark:border-blue-900/40 dark:bg-blue-950/20 print:border print:border-slate-300 print:bg-slate-50 print:p-4 print:shadow-none">
            <div class="flex items-center gap-2 border-b border-blue-100 pb-3 dark:border-blue-900/50 print:border-slate-200 print:pb-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm shadow-blue-500/30 print:hidden">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                    </svg>
                </div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white print:text-xs print:font-bold">{{ __('خلاصه مالی سفارش') }}</h2>
            </div>

            <div class="mt-4 space-y-3 text-sm print:mt-2 print:space-y-1.5 print:text-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-600 dark:text-slate-400 print:text-slate-600">{{ __('جمع اقلام:') }}</span>
                    <span class="font-mono text-sm font-bold text-slate-800 dark:text-slate-200 print:text-slate-900">
                        {{ number_format($invoice->subtotal_amount) }} <span class="text-xs font-normal text-slate-500">{{ __('تومان') }}</span>
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-600 dark:text-slate-400 print:text-slate-600">{{ __('تخفیف کل:') }}</span>
                    <span class="font-mono text-sm font-bold {{ $invoice->discount_amount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-500' }} print:text-slate-900">
                        {{ $invoice->discount_amount > 0 ? '-' : '' }}{{ number_format($invoice->discount_amount) }} <span class="text-xs font-normal text-slate-500">{{ __('تومان') }}</span>
                    </span>
                </div>
                <div class="border-t border-blue-200/70 pt-3 dark:border-blue-900/60 print:border-slate-300 print:pt-2 flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-900 dark:text-white print:text-slate-900">{{ __('مبلغ قابل پرداخت:') }}</span>
                    <span class="font-mono text-base font-extrabold text-blue-600 dark:text-blue-400 print:text-slate-900">
                        {{ number_format($invoice->payable_amount) }} <span class="text-xs font-bold">{{ __('تومان') }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- جدول اقلام فاکتور (order_items) --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 print:border print:border-slate-300 print:rounded-none print:shadow-none page-break">
        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 dark:border-slate-800 dark:bg-slate-800/40 print:bg-slate-100 print:px-4 print:py-2">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white print:text-xs print:font-bold">{{ __('اقلام فاکتور') }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 print:hidden">{{ __('لیست پکیج‌ها، لایسنس‌ها یا خدمات خریداری‌شده در این فاکتور') }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm print:text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-100/70 text-xs font-semibold text-slate-600 dark:border-slate-800 dark:bg-slate-800/80 dark:text-slate-300 print:bg-slate-100 print:text-slate-800">
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">#</th>
                        <th class="py-3 px-4 print:py-2 print:px-2">{{ __('عنوان آیتم') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('نوع آیتم / شناسه') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('تعداد') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('قیمت واحد') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('تخفیف') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('مبلغ نهایی') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 print:divide-slate-200">
                    @forelse($invoice->items as $index => $item)
                        <tr class="transition hover:bg-slate-50/60 dark:hover:bg-slate-800/50">
                            <td class="py-3.5 px-4 text-center font-mono text-xs text-slate-400 print:py-2 print:px-2 print:text-slate-600">
                                {{ $index + 1 }}
                            </td>
                            <td class="py-3.5 px-4 print:py-2 print:px-2">
                                <div class="font-semibold text-slate-900 dark:text-slate-100 print:text-slate-900">
                                    {{ $item->title }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-center print:py-2 print:px-2">
                                @if($item->purchasable_type)
                                    <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-0.5 text-xs font-mono text-slate-700 dark:bg-slate-800 dark:text-slate-300 print:border print:border-slate-300 print:bg-white">
                                        {{ class_basename($item->purchasable_type) }} #{{ $item->purchasable_id }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-medium text-slate-700 dark:text-slate-300 print:py-2 print:px-2 print:text-slate-900">
                                {{ $item->quantity }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-slate-700 dark:text-slate-300 print:py-2 print:px-2 print:text-slate-900">
                                {{ number_format($item->unit_price) }} <span class="text-xs text-slate-400 print:text-slate-600">{{ __('تومان') }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono {{ $item->discount_amount > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-slate-400' }} print:py-2 print:px-2 print:text-slate-700">
                                {{ $item->discount_amount > 0 ? number_format($item->discount_amount) : '۰' }} <span class="text-xs text-slate-400 print:text-slate-600">{{ __('تومان') }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-blue-600 dark:text-blue-400 print:py-2 print:px-2 print:text-slate-900">
                                {{ number_format($item->final_amount) }} <span class="text-xs font-normal text-slate-400 print:text-slate-600">{{ __('تومان') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-slate-400 print:py-4">
                                {{ __('هیچ آیتمی برای این سفارش ثبت نشده است.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- تاریخچه و سوابق تراکنش‌های بانکی (payments) --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900 print:border print:border-slate-300 print:rounded-none print:shadow-none page-break">
        <div class="border-b border-slate-100 bg-slate-50/50 px-6 py-4 dark:border-slate-800 dark:bg-slate-800/40 print:bg-slate-100 print:px-4 print:py-2">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white print:text-xs print:font-bold">{{ __('سوابق پرداخت و تراکنش‌ها') }}</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 print:hidden">{{ __('کلیه تلاش‌های پرداخت ثبت‌شده در درگاه برای این فاکتور') }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm print:text-xs">
                <thead>
                    <tr class="border-b border-slate-200 bg-slate-100/70 text-xs font-semibold text-slate-600 dark:border-slate-800 dark:bg-slate-800/80 dark:text-slate-300 print:bg-slate-100 print:text-slate-800">
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('درگاه') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('مبلغ') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('وضعیت') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('شماره پیگیری (Ref ID)') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('شناسه ارجاع (Authority)') }}</th>
                        <th class="py-3 px-4 text-center print:py-2 print:px-2">{{ __('تاریخ و زمان') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 print:divide-slate-200">
                    @forelse($invoice->payments as $payment)
                        <tr class="transition hover:bg-slate-50/60 dark:hover:bg-slate-800/50">
                            <td class="py-3.5 px-4 text-center font-semibold text-slate-800 dark:text-slate-200 print:py-2 print:px-2 print:text-slate-900">
                                <span class="inline-flex items-center gap-1.5 rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 print:border print:border-slate-300 print:bg-white print:text-slate-800">
                                    {{ ucfirst($payment->gateway ?? 'نامشخص') }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800 dark:text-slate-200 print:py-2 print:px-2 print:text-slate-900">
                                {{ number_format($payment->amount) }} <span class="text-xs font-normal text-slate-500 print:text-slate-600">{{ $payment->currency ?? __('تومان') }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-center print:py-2 print:px-2">
                                @if(in_array($payment->status, ['paid', 'success', 'completed']))
                                    <span class="inline-flex items-center rounded-md bg-emerald-500/10 px-2 py-0.5 text-xs font-semibold text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 print:border-none print:text-emerald-700">
                                        {{ __('موفق') }}
                                    </span>
                                @elseif(in_array($payment->status, ['pending', 'waiting']))
                                    <span class="inline-flex items-center rounded-md bg-amber-500/10 px-2 py-0.5 text-xs font-semibold text-amber-600 dark:text-amber-400 border border-amber-500/20 print:border-none print:text-amber-700">
                                        {{ __('در انتظار') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-md bg-rose-500/10 px-2 py-0.5 text-xs font-semibold text-rose-600 dark:text-rose-400 border border-rose-500/20 print:border-none print:text-rose-700" title="{{ $payment->failure_message }}">
                                        {{ __('ناموفق / لغو') }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-xs text-slate-700 dark:text-slate-300 print:py-2 print:px-2 print:text-slate-900">
                                {{ $payment->reference_id ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-xs text-slate-500 print:py-2 print:px-2 print:text-slate-700" title="{{ $payment->authority }}">
                                {{ $payment->authority ? \Illuminate\Support\Str::limit($payment->authority, 16) : '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-xs text-slate-700 dark:text-slate-300 dir-ltr print:py-2 print:px-2 print:text-slate-900">
                                {{ $payment->card_pan ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center font-mono text-xs text-slate-600 dark:text-slate-400 print:py-2 print:px-2 print:text-slate-800">
                                @php
                                    $paymentTime = $payment->paid_at ?? $payment->created_at;
                                @endphp
                                {{ function_exists('jdate') ? jdate($paymentTime)->format('Y/m/d - H:i:s') : $paymentTime->format('Y-m-d H:i:s') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-sm text-slate-400 print:py-4">
                                {{ __('هیچ تراکنش پرداخت بانکی برای این فاکتور ثبت نشده است.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- کادر مهر و امضا و اطلاعات پایین برگه فاکتور (فقط در حالت پرینت) --}}
    <div class="hidden print:grid grid-cols-2 gap-8 pt-8 mt-12 border-t border-slate-300 text-xs text-slate-700 page-break">
        <div class="text-center space-y-12">
            <p class="font-bold">{{ __('مهر و امضای فروشنده') }}</p>
            <div class="h-16"></div>
        </div>
        <div class="text-center space-y-12">
            <p class="font-bold">{{ __('امضای خریدار') }}</p>
            <div class="h-16"></div>
        </div>
    </div>

</div>
@endsection

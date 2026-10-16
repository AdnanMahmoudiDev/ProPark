<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-5 print:hidden sm:flex-row sm:items-center sm:justify-between py-1">
            {{-- تایتل، آیکون و متادیتا --}}
            <div class="flex items-center gap-4 min-w-0">
                <div class="relative flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-600/10 text-blue-400 ring-1 ring-blue-500/30 shadow-inner">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>

                <div class="min-w-0">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <h2 class="text-xl font-black tracking-tight text-white sm:text-2xl">
                            {{ __('جزئیات فاکتور') }}
                        </h2>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg text-xs font-mono font-bold bg-blue-500/10 text-blue-400 ring-1 ring-inset ring-blue-500/30">
                            #{{ $order->order_number ?? $order->id }}
                        </span>
                    </div>

                    <p class="mt-1 text-xs sm:text-sm text-gray-400 flex items-center gap-1.5">
                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        {{ __('مشاهده ریز اقلام و رسید پرداخت دیجیتال') }}
                    </p>
                </div>
            </div>

            {{-- دکمه‌های عملیات هدر --}}
            <div class="flex flex-wrap items-center gap-2.5">
                <button onclick="window.print()"
                        type="button"
                        class="inline-flex h-10 sm:h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs sm:text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition-all hover:bg-blue-500 hover:shadow-blue-500/30 active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                        </path>
                    </svg>
                    {{ __('چاپ یا ذخیره PDF') }}
                </button>

                <a href="{{ route('user.invoices.index') }}"
                   class="inline-flex h-10 sm:h-11 items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-800/80 px-4 py-2 text-xs sm:text-sm font-semibold text-gray-200 shadow-sm transition-all hover:bg-gray-700 hover:text-white active:scale-[0.98]">
                    <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    {{ __('بازگشت به لیست فاکتورها') }}
                </a>
            </div>
        </div>
    </x-slot>

    {{-- استایل اختصاصی چاپ فاکتور --}}
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 10mm;
            }

            html,
            body {
                background: #ffffff !important;
                color: #0f172a !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            nav,
            header,
            aside,
            footer,
            .print\:hidden {
                display: none !important;
            }

            .invoice-wrapper {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-container {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .invoice-card {
                overflow: visible !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 8px !important;
                background: #ffffff !important;
                box-shadow: none !important;
                color: #0f172a !important;
            }

            .invoice-card * {
                text-shadow: none !important;
            }

            .invoice-card .text-slate-800,
            .invoice-card .text-slate-900,
            .invoice-card .text-slate-700,
            .invoice-card .text-slate-600,
            .invoice-card .text-slate-500,
            .invoice-card .text-slate-400,
            .invoice-card .text-gray-100,
            .invoice-card .text-gray-200,
            .invoice-card .text-gray-300,
            .invoice-card .text-gray-400,
            .invoice-card .text-gray-500,
            .invoice-card .text-white,
            .invoice-card .text-blue-400,
            .invoice-card .text-blue-500,
            .invoice-card .text-blue-600,
            .invoice-card .text-emerald-400,
            .invoice-card .text-emerald-500,
            .invoice-card .text-emerald-600,
            .invoice-card .text-rose-400,
            .invoice-card .text-rose-500 {
                color: #0f172a !important;
            }

            .invoice-card .bg-gray-800,
            .invoice-card .bg-gray-900,
            .invoice-card .bg-gray-900\/70,
            .invoice-card .bg-gray-950\/40,
            .invoice-card .bg-gray-800\/50,
            .invoice-card .bg-gradient-to-br {
                background: #ffffff !important;
            }

            .invoice-card .border-gray-700,
            .invoice-card .border-gray-800,
            .invoice-card .border-gray-800\/60,
            .invoice-card .border-gray-800\/80 {
                border-color: #cbd5e1 !important;
            }

            .print-badge {
                border: 1px solid #94a3b8 !important;
                background: #f8fafc !important;
            }

            .print-table th {
                background: #f1f5f9 !important;
                color: #1e293b !important;
                border-bottom: 1px solid #cbd5e1 !important;
            }

            .print-table td {
                border-bottom: 1px solid #e2e8f0 !important;
            }

            .print-summary {
                background: #f8fafc !important;
                border: 1px solid #cbd5e1 !important;
            }

            .print-receipt {
                background: #ffffff !important;
                border-top: 1px solid #cbd5e1 !important;
            }

            .print-break-inside-avoid {
                break-inside: avoid !important;
                page-break-inside: avoid !important;
            }

            .mobile-items {
                display: none !important;
            }

            .desktop-items {
                display: block !important;
            }

            .print-footer {
                display: block !important;
            }

            a {
                text-decoration: none !important;
            }
        }

        @media screen {
            .print-footer {
                display: none;
            }
        }
    </style>

    <div class="invoice-wrapper min-h-screen bg-[#0b0f19] py-6 sm:py-8 lg:py-10">
        <div class="invoice-container mx-auto max-w-4xl px-3 sm:px-6 lg:px-8">

            {{-- کارت اصلی فاکتور با هویت بصری داشبورد --}}
            <div class="invoice-card overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-2xl backdrop-blur-md">

                {{-- سربرگ فاکتور --}}
                <div class="border-b border-gray-800 bg-gray-950/40 p-5 sm:p-6 lg:p-8">
                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-gray-700/60 bg-gray-800/80 p-2 shadow-inner sm:h-14 sm:w-14">
                                <img src="{{ asset('images/ProPark.png') }}"
                                     alt="{{ config('app.name', 'ProPark') }}"
                                     class="max-h-full max-w-full object-contain">
                            </div>

                            <div class="min-w-0">
                                <h3 class="break-words text-lg font-black tracking-tight text-white sm:text-xl">
                                    {{ config('app.name', 'ProPark') }}
                                </h3>

                                <p class="mt-1 text-xs leading-5 text-gray-400">
                                    سامانه هوشمند مدیریت اشتراک و پارکینگ
                                </p>
                            </div>
                        </div>

                        <div class="min-w-0 sm:text-left">
                            @php
                                $invoiceStatusClasses = $order->status === 'paid'
                                    ? 'bg-emerald-500/10 text-emerald-400 ring-emerald-500/30'
                                    : ($order->status === 'pending'
                                        ? 'bg-amber-500/10 text-amber-400 ring-amber-500/30'
                                        : $order->status_badge_classes);
                            @endphp

                            <span class="print-badge inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold ring-1 ring-inset {{ $invoiceStatusClasses }}">
                                @if($order->status === 'paid')
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                              d="M5 13l4 4L19 7">
                                        </path>
                                    </svg>
                                @elseif($order->status === 'pending')
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                        <path stroke-linecap="round" stroke-width="2" d="M12 7v5l3 2"></path>
                                    </svg>
                                @endif

                                {{ $order->status_label }}
                            </span>

                            <div class="mt-3 space-y-1.5 text-xs text-gray-400">
                                <div class="flex items-center gap-1.5 sm:justify-end">
                                    <span>{{ __('شماره فاکتور:') }}</span>
                                    <span class="font-mono font-bold text-gray-200">
                                        #{{ $order->order_number ?? $order->id }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-1.5 sm:justify-end">
                                    <span>{{ __('تاریخ:') }}</span>
                                    <span class="font-mono text-gray-300" dir="ltr">
                                        @if(function_exists('jdate'))
                                            {{ jdate($order->created_at)->format('Y/m/d H:i') }}
                                        @elseif(function_exists('verta'))
                                            {{ verta($order->created_at)->format('Y/m/d H:i') }}
                                        @else
                                            {{ $order->created_at->format('Y-m-d H:i') }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- مشخصات خریدار و فروشنده --}}
                <div class="grid grid-cols-1 gap-4 border-b border-gray-800 p-5 sm:grid-cols-2 sm:gap-6 sm:p-6 lg:p-8">

                    <div class="min-w-0 rounded-2xl border border-gray-800 bg-gray-950/30 p-4 sm:p-5">
                        <div class="mb-3 flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12-13a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            </span>

                            <span class="text-xs font-bold text-gray-400">
                                {{ __('مشخصات خریدار') }}
                            </span>
                        </div>

                        <div class="break-words text-base font-bold text-white">
                            {{ $order->user->name ?? '—' }}
                        </div>

                        <div class="mt-2 break-all font-mono text-xs text-gray-400" dir="ltr">
                            {{ $order->user->email ?? '—' }}
                        </div>

                        @if(!empty($order->user?->phone_number))
                            <div class="mt-2 break-words font-mono text-xs text-gray-400" dir="ltr">
                                {{ $order->user->phone_number }}
                            </div>
                        @else
                            <div class="mt-2 text-xs text-gray-500">—</div>
                        @endif
                    </div>

                    <div class="min-w-0 rounded-2xl border border-gray-800 bg-gray-950/30 p-4 sm:p-5">
                        <div class="mb-3 flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/20">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 10h18M7 15h2m4 0h2m-9 5h12a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </span>

                            <span class="text-xs font-bold text-gray-400">
                                {{ __('مشخصات فروشنده') }}
                            </span>
                        </div>

                        <div class="break-words text-base font-bold text-white">
                            {{ config('app.name', 'ProPark') }}
                        </div>

                        <div class="mt-2 break-all font-mono text-xs text-gray-400" dir="ltr">
                            avapark.ir
                        </div>

                        <div class="mt-2 text-xs leading-5 text-gray-400">
                            {{ __('پشتیبانی آنلاین و سیستم‌های نرم‌افزاری') }}
                        </div>
                    </div>

                </div>

                {{-- شرح سفارش و اقلام --}}
                <div class="p-5 sm:p-6 lg:p-8">
                    <div class="mb-5 flex items-center gap-2">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 ring-1 ring-blue-500/20">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </span>

                        <h4 class="text-sm font-bold text-white">
                            {{ __('شرح سفارش و اقلام') }}
                        </h4>
                    </div>

                    {{-- نمایش موبایل: کارت اقلام --}}
                    <div class="mobile-items space-y-3 sm:hidden">
                        @forelse($order->items as $index => $item)
                            <div class="print-break-inside-avoid rounded-2xl border border-gray-800 bg-gray-950/40 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex min-w-0 items-start gap-2.5">
                                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-gray-800 font-mono text-xs font-bold text-gray-300">
                                            {{ $index + 1 }}
                                        </span>

                                        <div class="min-w-0">
                                            <p class="break-words text-sm font-bold leading-6 text-white">
                                                {{ $item->title }}
                                            </p>

                                            <p class="mt-1 text-xs text-gray-400">
                                                {{ __('تعداد') }}:
                                                <span class="font-mono font-semibold text-gray-200">{{ $item->quantity }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="shrink-0 text-left">
                                        <p class="text-[10px] text-gray-400">
                                            {{ __('مبلغ کل') }}
                                        </p>

                                        <p class="mt-1 font-mono text-sm font-bold text-white">
                                            {{ number_format($item->final_amount) }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-3.5 grid grid-cols-2 gap-3 border-t border-gray-800/80 pt-3">
                                    <div class="min-w-0">
                                        <p class="text-[10px] text-gray-400">
                                            {{ __('مبلغ واحد') }}
                                        </p>

                                        <p class="mt-1 break-words font-mono text-xs font-medium text-gray-300">
                                            {{ number_format($item->unit_price) }}
                                        </p>
                                    </div>

                                    <div class="min-w-0">
                                        <p class="text-[10px] text-gray-400">
                                            {{ __('تخفیف') }}
                                        </p>

                                        <p class="mt-1 break-words font-mono text-xs font-semibold text-rose-400">
                                            {{ $item->discount_amount > 0 ? number_format($item->discount_amount) : '۰' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-gray-800 p-8 text-center text-sm text-gray-500">
                                {{ __('آیتمی یافت نشد.') }}
                            </div>
                        @endforelse
                    </div>

                    {{-- نمایش دسکتاپ: جدول اقلام --}}
                    <div class="desktop-items hidden overflow-x-auto rounded-2xl border border-gray-800 sm:block">
                        <table class="print-table w-full text-right text-sm">
                            <thead class="border-b border-gray-800 bg-gray-950/60 text-xs font-semibold text-gray-400">
                                <tr>
                                    <th scope="col" class="whitespace-nowrap px-4 py-3.5 lg:px-5">#</th>

                                    <th scope="col" class="px-4 py-3.5 lg:px-5">
                                        {{ __('عنوان محصول / پلن') }}
                                    </th>

                                    <th scope="col" class="whitespace-nowrap px-4 py-3.5 text-center lg:px-5">
                                        {{ __('تعداد') }}
                                    </th>

                                    <th scope="col" class="whitespace-nowrap px-4 py-3.5 lg:px-5">
                                        {{ __('مبلغ واحد') }}
                                    </th>

                                    <th scope="col" class="whitespace-nowrap px-4 py-3.5 lg:px-5">
                                        {{ __('تخفیف') }}
                                    </th>

                                    <th scope="col" class="whitespace-nowrap px-4 py-3.5 text-left lg:px-5">
                                        {{ __('مبلغ کل') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-800/60">
                                @forelse($order->items as $index => $item)
                                    <tr class="text-gray-300 transition-colors hover:bg-gray-800/30">
                                        <td class="whitespace-nowrap px-4 py-4 font-mono text-xs text-gray-500 lg:px-5">
                                            {{ $index + 1 }}
                                        </td>

                                        <td class="px-4 py-4 font-semibold text-white lg:px-5">
                                            <span class="break-words">{{ $item->title }}</span>
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4 text-center font-mono lg:px-5">
                                            {{ $item->quantity }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4 font-mono text-gray-300 lg:px-5">
                                            {{ number_format($item->unit_price) }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4 font-mono text-rose-400 lg:px-5">
                                            {{ $item->discount_amount > 0 ? number_format($item->discount_amount) : '۰' }}
                                        </td>

                                        <td class="whitespace-nowrap px-4 py-4 text-left font-mono font-bold text-white lg:px-5">
                                            {{ number_format($item->final_amount) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-xs text-gray-500">
                                            {{ __('آیتمی یافت نشد.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- جمع مبالغ و صورتحساب --}}
                    <div class="mt-6 flex justify-end">
                        <div class="print-summary w-full space-y-3 rounded-2xl border border-gray-800 bg-gray-950/40 p-5 text-sm sm:w-96">

                            <div class="flex items-start justify-between gap-4 text-xs text-gray-400">
                                <span>{{ __('مجموع اقلام:') }}</span>

                                <span class="text-left font-mono font-semibold text-gray-200">
                                    {{ number_format($order->subtotal_amount) }}
                                    {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                </span>
                            </div>

                            @if($order->discount_amount > 0)
                                <div class="flex items-start justify-between gap-4 text-xs text-rose-400">
                                    <span>{{ __('تخفیف کل:') }}</span>

                                    <span class="text-left font-mono font-semibold">
                                        - {{ number_format($order->discount_amount) }}
                                        {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-start justify-between gap-4 border-t border-gray-800 pt-4 text-base font-bold text-white">
                                <span class="shrink-0">{{ __('مبلغ نهایی:') }}</span>

                                <span class="text-left font-mono text-blue-400">
                                    {{ $order->formatted_payable_amount }}

                                    <span class="mt-1 block text-xs font-medium text-gray-400">
                                        {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- سوابق و اطلاعات تراکنش‌های بانکی --}}
                @if($order->payments->isNotEmpty())
                    <div class="print-receipt border-t border-gray-800 bg-gray-950/40 p-5 sm:p-6 lg:p-8">

                        <div class="mb-4 flex items-center gap-2">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 ring-1 ring-emerald-500/20">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                            </span>

                            <h4 class="text-sm font-bold text-white">
                                {{ __('رسید و سوابق تراکنش بانکی') }}
                            </h4>
                        </div>

                        <div class="space-y-3">
                            @foreach($order->payments as $payment)
                                <div class="print-break-inside-avoid grid grid-cols-1 gap-4 rounded-2xl border border-gray-800 bg-gray-900/60 p-4 text-xs sm:grid-cols-2 lg:grid-cols-4">

                                    <div class="min-w-0">
                                        <span class="mb-1.5 block text-gray-400">
                                            {{ __('درگاه پرداخت') }}
                                        </span>

                                        <span class="break-words font-semibold text-gray-200">
                                            {{ strtoupper($payment->gateway ?? 'SEP') }} (سپ)
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <span class="mb-1.5 block text-gray-400">
                                            {{ __('کد پیگیری شاپرک') }}
                                        </span>

                                        <span class="break-all font-mono font-bold text-emerald-400">
                                            {{ $payment->tracking_code ?? $payment->reference_id ?? '—' }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <span class="mb-1.5 block text-gray-400">
                                            {{ __('شماره کارت') }}
                                        </span>

                                        <span class="break-all font-mono text-gray-300">
                                            {{ $payment->card_number ?? '—' }}
                                        </span>
                                    </div>

                                    <div class="min-w-0">
                                        <span class="mb-1.5 block text-gray-400">
                                            {{ __('زمان تراکنش') }}
                                        </span>

                                        <span class="break-words font-mono text-gray-400" dir="ltr">
                                            {{ $payment->paid_at
                                                ? (function_exists('jdate')
                                                    ? jdate($payment->paid_at)->format('Y/m/d H:i:s')
                                                    : (function_exists('verta')
                                                        ? verta($payment->paid_at)->format('Y/m/d H:i:s')
                                                        : $payment->paid_at->format('Y-m-d H:i:s')))
                                                : '—' }}
                                        </span>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- پاورقی فاکتور چاپی --}}
                <div class="print-footer border-t border-slate-200 bg-slate-50 p-4 text-center text-[10px] text-slate-500">
                    این سند الکترونیکی معتبر بوده و از سامانه خودکار
                    {{ config('app.name', 'ProPark') }}
                    صادر گردیده است.
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- ================= هدر صفحه امور مالی و فاکتورها ================= --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        
        {{-- نور پس‌زمینه اختصاصی تم آبی خالص --}}
        <div class="pointer-events-none absolute -top-16 left-1/2 -translate-x-1/2 h-32 w-[500px] rounded-full bg-blue-500/15 blur-3xl"></div>

        <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-4">
                {{-- آیکون مدرن و اختصاصی امور مالی --}}
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-blue-500/30 bg-blue-500/10 text-blue-400 shadow-inner shadow-blue-500/20">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15A2.25 2.25 0 002.25 6.75v10.5A2.25 2.25 0 004.5 21z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                        {{ __('امور مالی و فاکتورها') }}
                    </h1>
                    <p class="mt-0.5 text-xs text-gray-400 sm:text-sm">
                        {{ __('گزارش‌گیری زنده از فاکتورها، پرداخت‌های موفق، در انتظار، منقضی و لغو شده') }}
                    </p>
                </div>
            </div>

            {{-- بخش ابزارهای مالی، درآمد و دکمه حساب‌کتاب --}}
            <div class="flex flex-wrap items-center gap-3">
                
                {{-- خلاصه شاخص کل درآمد خالص --}}
                <div class="flex items-center gap-3 rounded-2xl border border-gray-800 bg-gray-900/60 px-4 py-2.5 backdrop-blur-md">
                    <div class="text-right">
                        <div class="text-[11px] font-medium text-gray-400">{{ __('مجموع درآمد وصول‌شده') }}</div>
                        <div class="font-mono text-base font-extrabold text-blue-400">
                            {{ number_format($totalRevenue ?? 0) }} <span class="text-xs font-normal text-gray-400">تومان</span>
                        </div>
                    </div>
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                {{-- دکمه اختصاصی حساب‌کتاب (هدایت به گزارش‌های تحلیلی و نمودارها) --}}
                <a href="{{ route('admin.invoices.analytics') }}" 
                   class="inline-flex items-center gap-2 rounded-2xl border border-blue-500/40 bg-gradient-to-r from-blue-600 to-blue-500 px-4 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-600/25 transition duration-200 hover:from-blue-500 hover:to-blue-400 hover:shadow-blue-500/40 active:scale-95">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <span>{{ __('حساب‌کتاب') }}</span>
                </a>

            </div>
        </div>

        {{-- ۴ کارت آماری تحلیلی تفکیک‌شده --}}
        <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
            
            {{-- کارت پرداخت‌شده --}}
            <a href="{{ route('admin.invoices.index', ['status' => 'paid']) }}" 
               class="group relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-blue-500/50 hover:bg-gray-900/80">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400">{{ __('فاکتورهای پرداخت‌شده') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-500/10 text-blue-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="font-mono text-2xl font-black text-white">{{ number_format($paidCount ?? 0) }}</span>
                    <span class="text-[11px] font-medium text-emerald-400">
                        {{ $totalCount > 0 ? round((($paidCount ?? 0) / $totalCount) * 100) : 0 }}%
                    </span>
                </div>
                <div class="mt-1 text-[11px] text-gray-500">{{ __('تسویه حساب نهایی') }}</div>
            </a>

            {{-- کارت در انتظار پرداخت --}}
            <a href="{{ route('admin.invoices.index', ['status' => 'pending']) }}" 
               class="group relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-amber-500/50 hover:bg-gray-900/80">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400">{{ __('در انتظار پرداخت') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-500/10 text-amber-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="font-mono text-2xl font-black text-white">{{ number_format($pendingCount ?? 0) }}</span>
                    <span class="text-[11px] font-medium text-amber-400">
                        {{ $totalCount > 0 ? round((($pendingCount ?? 0) / $totalCount) * 100) : 0 }}%
                    </span>
                </div>
                <div class="mt-1 text-[11px] text-gray-500">{{ __('منتظر ورود به درگاه') }}</div>
            </a>

            {{-- کارت منقضی شده --}}
            <a href="{{ route('admin.invoices.index', ['status' => 'expired']) }}" 
               class="group relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-slate-500/50 hover:bg-gray-900/80">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400">{{ __('فاکتورهای منقضی‌شده') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-slate-500/10 text-slate-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="font-mono text-2xl font-black text-white">{{ number_format($expiredCount ?? 0) }}</span>
                    <span class="text-[11px] font-medium text-slate-400">
                        {{ $totalCount > 0 ? round((($expiredCount ?? 0) / $totalCount) * 100) : 0 }}%
                    </span>
                </div>
                <div class="mt-1 text-[11px] text-gray-500">{{ __('اتمام مهلت پرداخت') }}</div>
            </a>

            {{-- کارت لغو شده و ناموفق --}}
            <a href="{{ route('admin.invoices.index', ['status' => 'failed']) }}" 
               class="group relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/40 p-4 transition duration-300 hover:border-rose-500/50 hover:bg-gray-900/80">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-medium text-gray-400">{{ __('لغو شده و ناموفق') }}</span>
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-rose-500/10 text-rose-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline justify-between">
                    <span class="font-mono text-2xl font-black text-white">{{ number_format(($failedCount ?? 0) + ($canceledCount ?? 0)) }}</span>
                    <span class="text-[11px] font-medium text-rose-400">
                        {{ $totalCount > 0 ? round(((($failedCount ?? 0) + ($canceledCount ?? 0)) / $totalCount) * 100) : 0 }}%
                    </span>
                </div>
                <div class="mt-1 text-[11px] text-gray-500">{{ __('تراکنش‌های نافرجام') }}</div>
            </a>

        </div>
    </div>

    {{-- ================= نوار جستجو و فیلترهای سریع ================= --}}
    <div class="rounded-2xl border border-gray-800/80 bg-gray-950/60 p-4 backdrop-blur-xl shadow-lg">
        <form method="GET" action="{{ route('admin.invoices.index') }}" class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
            
            {{-- فیلد جستجوی چندگانه --}}
            <div class="relative flex-1">
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="{{ __('جستجو براساس شماره فاکتور، نام کاربر، ایمیل یا شماره تماس...') }}"
                       class="w-full rounded-xl border border-gray-800 bg-gray-900/70 py-2.5 pr-10 pl-4 text-xs text-white placeholder-gray-500 transition focus:border-blue-500 focus:bg-gray-900 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            {{-- فیلترهای انتخابی و دکمه اعمال --}}
            <div class="flex flex-wrap items-center gap-2">
                <select name="status" class="rounded-xl border border-gray-800 bg-gray-900/70 px-3 py-2.5 text-xs text-gray-300 transition focus:border-blue-500 focus:outline-none">
                    <option value="">{{ __('همه وضعیت‌ها') }}</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>{{ __('پرداخت‌شده') }}</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>{{ __('در انتظار پرداخت') }}</option>
                    <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>{{ __('منقضی‌شده') }}</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>{{ __('ناموفق') }}</option>
                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>{{ __('لغو شده') }}</option>
                </select>

                <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-blue-500 shadow-lg shadow-blue-600/20 active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span>{{ __('اعمال فیلتر') }}</span>
                </button>

                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.invoices.index') }}" class="inline-flex items-center gap-1 rounded-xl border border-gray-800 bg-gray-900/60 px-3 py-2.5 text-xs text-gray-400 transition hover:bg-gray-800 hover:text-white">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        <span>{{ __('حذف فیلترها') }}</span>
                    </a>
                @endif
            </div>
        </form>

        {{-- تب‌های دسترسی سریع (Quick Filter Pills) --}}
        <div class="mt-3 flex flex-wrap items-center gap-1.5 border-t border-gray-800/60 pt-3 text-xs">
            <span class="text-gray-500 ml-1">{{ __('دسترسی سریع:') }}</span>
            <a href="{{ route('admin.invoices.index') }}" 
               class="rounded-lg px-2.5 py-1 transition {{ !request('status') ? 'bg-blue-500/20 text-blue-400 font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
               {{ __('همه') }}
            </a>
            <a href="{{ route('admin.invoices.index', ['status' => 'paid']) }}" 
               class="rounded-lg px-2.5 py-1 transition {{ request('status') === 'paid' ? 'bg-emerald-500/20 text-emerald-400 font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
               <span class="inline-block w-1.5 h-1.5 rounded-full bg-emerald-400 ml-1"></span>{{ __('پرداخت‌شده') }}
            </a>
            <a href="{{ route('admin.invoices.index', ['status' => 'pending']) }}" 
               class="rounded-lg px-2.5 py-1 transition {{ request('status') === 'pending' ? 'bg-amber-500/20 text-amber-400 font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
               <span class="inline-block w-1.5 h-1.5 rounded-full bg-amber-400 ml-1"></span>{{ __('در انتظار پرداخت') }}
            </a>
            <a href="{{ route('admin.invoices.index', ['status' => 'expired']) }}" 
               class="rounded-lg px-2.5 py-1 transition {{ request('status') === 'expired' ? 'bg-slate-500/20 text-slate-300 font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
               <span class="inline-block w-1.5 h-1.5 rounded-full bg-slate-400 ml-1"></span>{{ __('منقضی شده') }}
            </a>
            <a href="{{ route('admin.invoices.index', ['status' => 'failed']) }}" 
               class="rounded-lg px-2.5 py-1 transition {{ request('status') === 'failed' ? 'bg-rose-500/20 text-rose-400 font-semibold' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
               <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-400 ml-1"></span>{{ __('ناموفق / لغو شده') }}
            </a>
        </div>
    </div>

    {{-- ================= جدول و کارت‌های لیست فاکتورها ================= --}}
    <div class="overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-950/50 backdrop-blur-xl shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-800/80 px-5 py-4 sm:px-6">
            <div>
                <h3 class="text-base font-bold text-white">{{ __('دفتر ثبت فاکتورها') }}</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ __('فهرست ردیف‌های مالی ثبت‌شده به همراه تفکیک قیمت کل، تخفیف و مبلغ نهایی') }}</p>
            </div>
            <span class="rounded-xl border border-gray-800 bg-gray-900/60 px-3 py-1 text-xs font-mono text-gray-400">
                {{ $invoices->total() }} {{ __('مورد') }}
            </span>
        </div>

        @if($invoices->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gray-900 border border-gray-800 text-gray-600 mb-3">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="text-base font-bold text-white">{{ __('هیچ فاکتوری یافت نشد') }}</h4>
                <p class="text-xs text-gray-500 mt-1 max-w-sm">{{ __('هیچ رکوردی منطبق با جستجو یا فیلترهای انتخابی شما در دیتابیس وجود ندارد.') }}</p>
            </div>
        @else
            {{-- نسخه دسکتاپ: جدول بهینه‌شده با فواصل مناسب و فونت‌های خوانا --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead>
                        <tr class="border-b border-gray-800/60 bg-gray-900/40 text-xs font-semibold text-gray-400">
                            <th class="py-3 px-4 whitespace-nowrap">{{ __('شماره فاکتور') }}</th>
                            <th class="py-3 px-4">{{ __('مشتری / کاربر') }}</th>
                            <th class="py-3 px-4 min-w-[190px]">{{ __('جزئیات مبالغ مالی') }}</th>
                            <th class="py-3 px-4">{{ __('وضعیت') }}</th>
                            <th class="py-3 px-4">{{ __('تاریخ ثبت') }}</th>
                            <th class="py-3 px-4 text-center">{{ __('عملیات') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/40">
                        @foreach($invoices as $invoice)
                            <tr class="transition duration-200 hover:bg-gray-900/40">
                                
                                {{-- شماره فاکتور --}}
                                <td class="py-3.5 px-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2" x-data="{ copied: false }">
                                        <span class="font-mono text-sm font-semibold text-white tracking-wider inline-block">
                                            {{ $invoice->order_number ?? ('ORD-' . $invoice->id) }}
                                        </span>
                                        <button type="button" 
                                                @click="navigator.clipboard.writeText('{{ $invoice->order_number ?? ('ORD-' . $invoice->id) }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                class="text-gray-500 hover:text-blue-400 transition" 
                                                title="{{ __('کپی شماره سفارش') }}">
                                            <template x-if="!copied">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </template>
                                            <template x-if="copied">
                                                <svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </template>
                                        </button>
                                    </div>
                                    <div class="text-[11px] text-gray-500 font-mono mt-0.5">ID: #{{ $invoice->id }}</div>
                                </td>

                                {{-- مشتری / کاربر --}}
                                <td class="py-3.5 px-4">
                                    <div class="space-y-0.5">
                                        <div class="text-sm font-medium text-white">
                                            {{ $invoice->user->name ?? __('کاربر مهمان') }}
                                        </div>
                                        @if(optional($invoice->user)->phone_number)
                                            <div class="font-mono text-xs text-gray-300 tracking-wider">
                                                {{ $invoice->user->phone_number }}
                                            </div>
                                        @endif
                                        @if(optional($invoice->user)->email)
                                            <div class="font-mono text-xs text-gray-400">
                                                {{ $invoice->user->email }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                {{-- جزئیات مبالغ مالی --}}
                                <td class="py-3.5 px-4">
                                    <div class="space-y-1">
                                        {{-- قیمت کل --}}
                                        <div class="flex items-center justify-between text-xs text-gray-400">
                                            <span>{{ __('قیمت کل:') }}</span>
                                            <span class="font-mono font-medium text-gray-200">
                                                {{ number_format($invoice->subtotal_amount ?? 0) }}
                                                <span class="text-[10px] text-gray-500">تومان</span>
                                            </span>
                                        </div>

                                        {{-- تخفیف --}}
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-gray-400">{{ __('تخفیف:') }}</span>
                                            <span class="font-mono {{ ($invoice->discount_amount ?? 0) > 0 ? 'text-emerald-400 font-medium' : 'text-gray-500' }}">
                                                @if(($invoice->discount_amount ?? 0) > 0)
                                                    -{{ number_format($invoice->discount_amount) }}
                                                @else
                                                    0
                                                @endif
                                                <span class="text-[10px] text-gray-500">تومان</span>
                                            </span>
                                        </div>

                                        {{-- کل پرداخت نهایی --}}
                                        <div class="flex items-center justify-between border-t border-gray-800/80 pt-1 text-xs">
                                            <span class="font-semibold text-white">{{ __('کل پرداخت:') }}</span>
                                            <span class="font-mono text-sm font-bold text-blue-400">
                                                {{ number_format($invoice->payable_amount ?? 0) }}
                                                <span class="text-[10px] font-normal text-gray-400">تومان</span>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                {{-- وضعیت --}}
                                <td class="py-3.5 px-4">
                                    @php
                                        $statusConfig = [
                                            'paid' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/20', 'label' => 'پرداخت‌شده', 'dot' => 'bg-emerald-400'],
                                            'pending' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/20', 'label' => 'در انتظار پرداخت', 'dot' => 'bg-amber-400'],
                                            'expired' => ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-300', 'border' => 'border-slate-500/20', 'label' => 'منقضی شده', 'dot' => 'bg-slate-400'],
                                            'failed' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-400', 'border' => 'border-rose-500/20', 'label' => 'ناموفق', 'dot' => 'bg-rose-400'],
                                            'canceled' => ['bg' => 'bg-gray-800/60', 'text' => 'text-gray-400', 'border' => 'border-gray-700/40', 'label' => 'لغو شده', 'dot' => 'bg-gray-400'],
                                        ][$invoice->status] ?? ['bg' => 'bg-gray-800', 'text' => 'text-gray-300', 'border' => 'border-gray-700', 'label' => $invoice->status, 'dot' => 'bg-gray-400'];
                                    @endphp
                                    <span class="inline-flex items-center gap-1.5 rounded-full border {{ $statusConfig['border'] }} {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} px-2.5 py-0.5 text-xs font-medium">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                        {{ __($statusConfig['label']) }}
                                    </span>
                                </td>

                                {{-- تاریخ ثبت --}}
                                <td class="py-3.5 px-4">
                                    <div class="text-xs text-gray-200">
                                        {{ function_exists('jdate') ? jdate($invoice->created_at)->format('Y/m/d') : $invoice->created_at->format('Y-m-d') }}
                                    </div>
                                    <div class="text-[11px] text-gray-500 font-mono mt-0.5">
                                        {{ function_exists('jdate') ? jdate($invoice->created_at)->format('H:i') : $invoice->created_at->format('H:i') }}
                                    </div>
                                </td>

                                {{-- عملیات --}}
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('admin.invoices.show', $invoice) }}" 
                                       class="inline-flex items-center gap-1 rounded-xl border border-gray-800 bg-gray-900/60 px-3 py-1.5 text-xs font-medium text-blue-400 transition hover:border-blue-500/40 hover:bg-blue-500/10">
                                        <span>{{ __('مشاهده') }}</span>
                                        <svg class="h-3.5 w-3.5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- نسخه موبایل --}}
            <div class="grid grid-cols-1 divide-y divide-gray-800/60 md:hidden">
                @foreach($invoices as $invoice)
                    @php
                        $statusConfig = [
                            'paid' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/20', 'label' => 'پرداخت‌شده'],
                            'pending' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/20', 'label' => 'در انتظار پرداخت'],
                            'expired' => ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-300', 'border' => 'border-slate-500/20', 'label' => 'منقضی شده'],
                            'failed' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-400', 'border' => 'border-rose-500/20', 'label' => 'ناموفق'],
                            'canceled' => ['bg' => 'bg-gray-800/60', 'text' => 'text-gray-400', 'border' => 'border-gray-700/40', 'label' => 'لغو شده'],
                        ][$invoice->status] ?? ['bg' => 'bg-gray-800', 'text' => 'text-gray-300', 'border' => 'border-gray-700', 'label' => $invoice->status];
                    @endphp
                    <div class="p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="font-mono text-sm font-semibold text-white tracking-wider whitespace-nowrap">
                                {{ $invoice->order_number ?? ('ORD-' . $invoice->id) }}
                            </span>
                            <span class="inline-flex items-center rounded-full border {{ $statusConfig['border'] }} {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} px-2 py-0.5 text-[11px] font-medium">
                                {{ __($statusConfig['label']) }}
                            </span>
                        </div>

                        {{-- مشتری در موبایل --}}
                        <div class="text-xs space-y-0.5">
                            <div class="text-white font-medium text-sm">{{ $invoice->user->name ?? __('کاربر مهمان') }}</div>
                            @if(optional($invoice->user)->phone_number)
                                <div class="font-mono text-gray-300 text-xs">{{ $invoice->user->phone_number }}</div>
                            @endif
                            @if(optional($invoice->user)->email)
                                <div class="font-mono text-gray-400 text-[11px]">{{ $invoice->user->email }}</div>
                            @endif
                        </div>

                        {{-- مبالغ مالی در موبایل --}}
                        <div class="rounded-xl border border-gray-800 bg-gray-900/60 p-3 space-y-1.5 text-xs">
                            <div class="flex items-center justify-between text-gray-400">
                                <span>{{ __('قیمت کل:') }}</span>
                                <span class="font-mono text-gray-200">{{ number_format($invoice->subtotal_amount ?? 0) }} تومان</span>
                            </div>
                            <div class="flex items-center justify-between text-gray-400">
                                <span>{{ __('تخفیف:') }}</span>
                                <span class="font-mono {{ ($invoice->discount_amount ?? 0) > 0 ? 'text-emerald-400' : 'text-gray-500' }}">
                                    @if(($invoice->discount_amount ?? 0) > 0)
                                        -{{ number_format($invoice->discount_amount) }}
                                    @else
                                        0
                                    @endif
                                    تومان
                                </span>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-800 pt-1.5 font-semibold text-white">
                                <span>{{ __('کل پرداخت:') }}</span>
                                <span class="font-mono text-sm font-bold text-blue-400">{{ number_format($invoice->payable_amount ?? 0) }} تومان</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-2 border-t border-gray-900 text-xs text-gray-500">
                            <span>{{ function_exists('jdate') ? jdate($invoice->created_at)->format('Y/m/d H:i') : $invoice->created_at->format('Y-m-d H:i') }}</span>
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-blue-400 font-medium hover:underline">
                                {{ __('مشاهده جزییات') }} &larr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- صفحه‌بندی (Pagination) لاراول --}}
        @if($invoices->hasPages())
            <div class="border-t border-gray-800/80 bg-gray-950/80 px-6 py-4">
                {{ $invoices->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-blue-700 bg-blue-600/20">
                        <svg class="h-6 w-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-2xl font-bold leading-tight text-white">
                            {{ __('فاکتورها و سوابق خرید') }}
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-gray-400">
                            {{ __('لیست تمامی سفارش‌ها، فاکتورها و وضعیت پرداخت‌های شما') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex w-full items-center justify-center gap-2 rounded-2xl border border-gray-700 bg-gray-900/70 px-4 py-2.5 text-sm font-semibold text-gray-200 transition duration-300 hover:border-blue-700/50 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-400/40 sm:w-auto">

                    <svg class="h-4 w-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>

                    {{ __('بازگشت به داشبورد') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#0b0f19] py-10">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            {{-- هدر صفحه --}}
            <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gradient-to-br from-gray-900 to-gray-950 p-7 shadow-2xl">
                <div class="absolute right-0 top-0 h-72 w-72 rounded-full bg-blue-700/10 blur-3xl"></div>

                <div class="relative z-10 flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span class="h-2 w-2 animate-pulse rounded-full bg-blue-500"></span>
                            <span>{{ __('مدیریت سفارش‌ها و فاکتورهای حساب کاربری') }}</span>
                        </div>

                        <h1 class="mt-3 text-2xl font-bold text-white sm:text-3xl">
                            {{ __('فاکتورها و سوابق خرید') }}
                        </h1>

                        <p class="mt-3 max-w-2xl text-sm leading-7 text-gray-400">
                            {{ __('در این بخش می‌توانید فاکتورهای پرداخت‌شده، سفارش‌های در انتظار پرداخت، موارد لغوشده و سفارش‌های منقضی‌شده خود را مشاهده و بررسی کنید.') }}
                        </p>
                    </div>

                    <div class="rounded-2xl border border-blue-800 bg-blue-900/20 px-4 py-3 text-sm text-blue-300">
                        {{ __('تعداد فاکتورها') }}:
                        <span class="font-bold text-white">{{ $orders->total() }}</span>
                    </div>
                </div>
            </div>

            {{-- فیلتر وضعیت‌ها --}}
            <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-4 shadow-xl sm:p-5">
                <div class="mb-4 flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl border border-blue-700 bg-blue-600/20">
                        <svg class="h-4 w-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4h18M6 8h12m-9 4h6m-4 4h2">
                            </path>
                        </svg>
                    </span>

                    <div>
                        <h3 class="text-sm font-bold text-white">{{ __('فیلتر فاکتورها') }}</h3>
                        <p class="text-xs text-gray-500">{{ __('برای مشاهده سریع‌تر، وضعیت موردنظر را انتخاب کنید') }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:items-center">
                    {{-- همه فاکتورها --}}
                    <a href="{{ route('user.invoices.index') }}"
                       class="inline-flex min-h-10 items-center justify-center rounded-2xl px-3 py-2 text-center text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                       {{ is_null($status)
                            ? 'bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 text-white shadow-lg shadow-blue-600/20'
                            : 'border border-gray-700 bg-gray-800 text-gray-300 hover:border-blue-700/40 hover:bg-gray-700/70 hover:text-white' }}">
                        {{ __('همه فاکتورها') }}
                    </a>

                    {{-- پرداخت‌شده --}}
                    <a href="{{ route('user.invoices.index', ['status' => \App\Models\Order::STATUS_PAID]) }}"
                       class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-2xl px-3 py-2 text-center text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                       {{ $status === \App\Models\Order::STATUS_PAID
                            ? 'bg-emerald-500/15 text-emerald-300 ring-1 ring-emerald-500/30'
                            : 'border border-gray-700 bg-gray-800 text-gray-300 hover:border-emerald-500/30 hover:bg-emerald-500/10 hover:text-emerald-300' }}">

                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        {{ __('موفق / پرداخت‌شده') }}
                    </a>

                    {{-- در انتظار پرداخت --}}
                    <a href="{{ route('user.invoices.index', ['status' => \App\Models\Order::STATUS_PENDING]) }}"
                       class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-2xl px-3 py-2 text-center text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                       {{ $status === \App\Models\Order::STATUS_PENDING
                            ? 'bg-amber-500/15 text-amber-300 ring-1 ring-amber-500/30'
                            : 'border border-gray-700 bg-gray-800 text-gray-300 hover:border-amber-500/30 hover:bg-amber-500/10 hover:text-amber-300' }}">

                        <span class="h-2 w-2 rounded-full bg-amber-400"></span>
                        {{ __('در انتظار پرداخت') }}
                    </a>

                    {{-- لغوشده / ناموفق --}}
                    <a href="{{ route('user.invoices.index', ['status' => \App\Models\Order::STATUS_CANCELLED]) }}"
                       class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-2xl px-3 py-2 text-center text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                       {{ in_array($status, [\App\Models\Order::STATUS_CANCELLED, \App\Models\Order::STATUS_FAILED, 'canceled'], true)
                            ? 'bg-rose-500/15 text-rose-300 ring-1 ring-rose-500/30'
                            : 'border border-gray-700 bg-gray-800 text-gray-300 hover:border-rose-500/30 hover:bg-rose-500/10 hover:text-rose-300' }}">

                        <span class="h-2 w-2 rounded-full bg-rose-400"></span>
                        {{ __('لغو شده / ناموفق') }}
                    </a>

                    {{-- منقضی شده --}}
                    <a href="{{ route('user.invoices.index', ['status' => \App\Models\Order::STATUS_EXPIRED]) }}"
                       class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-2xl px-3 py-2 text-center text-xs font-semibold transition duration-300 sm:px-4 sm:text-sm
                       {{ $status === \App\Models\Order::STATUS_EXPIRED
                            ? 'bg-slate-500/15 text-slate-200 ring-1 ring-slate-500/30'
                            : 'border border-gray-700 bg-gray-800 text-gray-300 hover:border-slate-500/30 hover:bg-slate-500/10 hover:text-slate-200' }}">

                        <span class="h-2 w-2 rounded-full bg-slate-300"></span>
                        {{ __('منقضی شده') }}
                    </a>
                </div>
            </div>

            {{-- لیست فاکتورها --}}
            <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-2xl">
                @if($orders->count() > 0)

                    {{-- نمایش موبایل --}}
                    <div class="space-y-4 p-3 sm:hidden">
                        @foreach($orders as $order)
                            <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-950/80 shadow-lg">
                                {{-- سربرگ کارت --}}
                                <div class="flex items-center justify-between gap-3 border-b border-gray-800 bg-gray-900/80 px-4 py-4">
                                    <div class="min-w-0">
                                        <p class="text-[11px] text-gray-500">
                                            {{ __('شماره فاکتور') }}
                                        </p>

                                        <p class="mt-1 truncate font-mono text-sm font-bold text-white">
                                            #{{ $order->order_number ?? $order->id }}
                                        </p>
                                    </div>

                                    @php
                                        $invoiceStatusClasses = match($order->status) {
                                            \App\Models\Order::STATUS_PAID => 'bg-emerald-500/15 text-emerald-300 ring-emerald-500/30',
                                            \App\Models\Order::STATUS_PENDING => 'bg-amber-500/15 text-amber-300 ring-amber-500/30',
                                            \App\Models\Order::STATUS_EXPIRED => 'bg-slate-500/15 text-slate-200 ring-slate-500/30',
                                            default => ($order->status_badge_classes ?? 'bg-rose-500/15 text-rose-300 ring-rose-500/30')
                                        };
                                    @endphp

                                    <span class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $invoiceStatusClasses }}">
                                        {{ $order->status_label ?? $order->status }}
                                    </span>
                                </div>

                                {{-- اقلام --}}
                                <div class="space-y-2 px-4 py-4">
                                    <p class="text-xs font-semibold text-gray-500">
                                        {{ __('اقلام خریداری‌شده') }}
                                    </p>

                                    <div class="space-y-2">
                                        @forelse($order->items as $item)
                                            <div class="flex items-start gap-2 text-sm text-gray-300">
                                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-500"></span>

                                                <span class="min-w-0 break-words leading-6">
                                                    {{ $item->title }}

                                                    @if($item->quantity > 1)
                                                        <span class="mr-1 text-xs text-gray-500">
                                                            ({{ $item->quantity }} {{ __('عدد') }})
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        @empty
                                            <p class="text-xs text-gray-500">
                                                {{ __('بدون آیتم') }}
                                            </p>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- مبلغ و تاریخ --}}
                                <div class="grid grid-cols-2 gap-3 border-t border-gray-800 px-4 py-4">
                                    <div class="min-w-0">
                                        <p class="text-[11px] text-gray-500">
                                            {{ __('مبلغ نهایی') }}
                                        </p>

                                        <p class="mt-1 break-words text-sm font-bold text-white">
                                            {{ $order->formatted_payable_amount }}
                                            <span class="text-[10px] font-normal text-gray-500">
                                                {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="min-w-0 text-left">
                                        <p class="text-[11px] text-gray-500">
                                            {{ __('تاریخ ثبت') }}
                                        </p>

                                        <p class="mt-1 break-words text-xs leading-5 text-gray-300" dir="ltr">
                                            @if(function_exists('jdate'))
                                                {{ jdate($order->created_at)->format('Y/m/d - H:i') }}
                                            @elseif(function_exists('verta'))
                                                {{ verta($order->created_at)->format('Y/m/d - H:i') }}
                                            @else
                                                {{ $order->created_at->format('Y-m-d - H:i') }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- عملیات --}}
                                <div class="border-t border-gray-800 p-4">
                                    <a href="{{ route('user.invoices.show', $order) }}"
                                       class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60">

                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>

                                        {{ __('مشاهده فاکتور') }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- نمایش دسکتاپ --}}
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="w-full text-right text-sm">
                            <thead>
                                <tr class="border-b border-gray-800 bg-gray-950/70 text-gray-400">
                                    <th scope="col" class="whitespace-nowrap px-5 py-4 font-semibold lg:px-6">
                                        {{ __('شماره فاکتور') }}
                                    </th>
                                    <th scope="col" class="px-5 py-4 font-semibold lg:px-6">
                                        {{ __('اقلام خریداری‌شده') }}
                                    </th>
                                    <th scope="col" class="whitespace-nowrap px-5 py-4 font-semibold lg:px-6">
                                        {{ __('مبلغ نهایی') }}
                                    </th>
                                    <th scope="col" class="whitespace-nowrap px-5 py-4 text-center font-semibold lg:px-6">
                                        {{ __('تاریخ ثبت') }}
                                    </th>
                                    <th scope="col" class="whitespace-nowrap px-5 py-4 text-center font-semibold lg:px-6">
                                        {{ __('وضعیت') }}
                                    </th>
                                    <th scope="col" class="whitespace-nowrap px-5 py-4 text-center font-semibold lg:px-6">
                                        {{ __('عملیات') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-800/80">
                                @foreach($orders as $order)
                                    <tr class="transition duration-300 hover:bg-white/[0.02]">
                                        {{-- شماره فاکتور --}}
                                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-gray-200 lg:px-6">
                                            #{{ $order->order_number ?? $order->id }}
                                        </td>

                                        {{-- اقلام --}}
                                        <td class="px-5 py-4 lg:px-6">
                                            <div class="flex max-w-xs flex-col gap-2">
                                                @forelse($order->items as $item)
                                                    <span class="break-words font-medium leading-6 text-gray-300">
                                                        <span class="text-blue-500">•</span>
                                                        {{ $item->title }}

                                                        @if($item->quantity > 1)
                                                            <span class="text-xs text-gray-500">
                                                                ({{ $item->quantity }} {{ __('عدد') }})
                                                            </span>
                                                        @endif
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-gray-500">
                                                        {{ __('بدون آیتم') }}
                                                    </span>
                                                @endforelse
                                            </div>
                                        </td>

                                        {{-- مبلغ --}}
                                        <td class="whitespace-nowrap px-5 py-4 font-bold text-white lg:px-6">
                                            {{ $order->formatted_payable_amount }}
                                            <span class="mr-1 text-xs font-normal text-gray-500">
                                                {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                            </span>
                                        </td>

                                        {{-- تاریخ --}}
                                        <td class="whitespace-nowrap px-5 py-4 text-center text-xs text-gray-400 lg:px-6">
                                            @if(function_exists('jdate'))
                                                {{ jdate($order->created_at)->format('Y/m/d - H:i') }}
                                            @elseif(function_exists('verta'))
                                                {{ verta($order->created_at)->format('Y/m/d - H:i') }}
                                            @else
                                                {{ $order->created_at->format('Y-m-d - H:i') }}
                                            @endif
                                        </td>

                                        {{-- وضعیت --}}
                                        <td class="whitespace-nowrap px-5 py-4 text-center lg:px-6">
                                            @php
                                                $badgeClasses = match($order->status) {
                                                    \App\Models\Order::STATUS_PAID => 'bg-emerald-500/15 text-emerald-300 ring-emerald-500/30',
                                                    \App\Models\Order::STATUS_PENDING => 'bg-amber-500/15 text-amber-300 ring-amber-500/30',
                                                    \App\Models\Order::STATUS_EXPIRED => 'bg-slate-500/15 text-slate-200 ring-slate-500/30',
                                                    default => ($order->status_badge_classes ?? 'bg-rose-500/15 text-rose-300 ring-rose-500/30')
                                                };
                                            @endphp

                                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold ring-1 ring-inset {{ $badgeClasses }}">
                                                @if($order->status === \App\Models\Order::STATUS_PAID)
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @elseif($order->status === \App\Models\Order::STATUS_PENDING)
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                                        <path stroke-linecap="round" stroke-width="2" d="M12 7v5l3 2"></path>
                                                    </svg>
                                                @elseif($order->status === \App\Models\Order::STATUS_EXPIRED)
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                @else
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M6 18L18 6M6 6l12 12">
                                                        </path>
                                                    </svg>
                                                @endif

                                                {{ $order->status_label ?? $order->status }}
                                            </span>
                                        </td>

                                        {{-- عملیات --}}
                                        <td class="whitespace-nowrap px-5 py-4 text-center lg:px-6">
                                            <a href="{{ route('user.invoices.show', $order) }}"
                                               class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-4 py-2.5 text-xs font-semibold text-white shadow-lg shadow-blue-600/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60">

                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                    </path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>

                                                {{ __('مشاهده فاکتور') }}
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- صفحه‌بندی --}}
                    @if($orders->hasPages())
                        <div class="border-t border-gray-800 px-4 py-5 sm:px-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    {{-- حالت خالی --}}
                    <div class="px-4 py-16 text-center sm:py-20">
                        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl border border-gray-800 bg-gray-900 text-gray-500">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2 3.5-2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-white">
                            {{ __('هیچ فاکتوری یافت نشد') }}
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-gray-400">
                            {{ __('در حال حاضر هیچ سفارش یا فاکتوری در این وضعیت ثبت نشده است.') }}
                        </p>

                        @if(!is_null($status))
                            <a href="{{ route('user.invoices.index') }}"
                               class="mt-5 inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-600/20 transition duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/30">
                                {{ __('مشاهده همه فاکتورها') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

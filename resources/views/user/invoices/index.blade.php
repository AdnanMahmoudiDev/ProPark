<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="min-w-0">
                <h2 class="flex items-center gap-3 text-xl font-bold leading-tight text-slate-800 dark:text-white sm:text-2xl">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </span>

                    {{ __('فاکتورها و سوابق خرید') }}
                </h2>

                <p class="mt-2 text-sm leading-6 text-slate-500 dark:text-slate-400">
                    {{ __('لیست تمامی سفارش‌ها، فاکتورها و وضعیت پرداخت‌های شما') }}
                </p>
            </div>

            <div class="flex">
                <a href="{{ route('dashboard') }}"
                   class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700 sm:w-auto">

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

    <div class="py-6 sm:py-10">
        <div class="mx-auto max-w-7xl space-y-5 px-3 sm:space-y-6 sm:px-6 lg:px-8">

            {{-- فیلتر وضعیت‌ها --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-800 sm:p-4">
                <div class="mb-3 flex items-center gap-2">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 4h18M6 8h12m-9 4h6m-4 4h2">
                        </path>
                    </svg>

                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                        {{ __('فیلتر فاکتورها') }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 sm:flex sm:flex-wrap sm:items-center">

                    {{-- همه فاکتورها --}}
                    <a href="{{ route('user.invoices.index') }}"
                       class="inline-flex min-h-10 items-center justify-center rounded-xl px-3 py-2 text-center text-xs font-semibold transition-colors sm:px-4 sm:text-sm
                       {{ is_null($status)
                            ? 'bg-blue-600 text-white'
                            : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600' }}">

                        {{ __('همه فاکتورها') }}
                    </a>

                    {{-- پرداخت‌شده --}}
                    <a href="{{ route('user.invoices.index', ['status' => 'paid']) }}"
                       class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-center text-xs font-semibold transition-colors sm:px-4 sm:text-sm
                       {{ $status === 'paid'
                            ? 'bg-emerald-100 text-emerald-800 ring-1 ring-emerald-300 dark:bg-emerald-500/20 dark:text-emerald-300 dark:ring-emerald-500/30'
                            : 'bg-slate-100 text-slate-600 hover:bg-emerald-50 hover:text-emerald-700 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-emerald-500/10 dark:hover:text-emerald-300' }}">

                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        {{ __('موفق / پرداخت‌شده') }}
                    </a>

                    {{-- در انتظار پرداخت --}}
                    <a href="{{ route('user.invoices.index', ['status' => 'pending']) }}"
                       class="inline-flex min-h-10 items-center justify-center gap-1.5 rounded-xl px-3 py-2 text-center text-xs font-semibold transition-colors sm:px-4 sm:text-sm
                       {{ $status === 'pending'
                            ? 'bg-amber-100 text-amber-800 ring-1 ring-amber-300 dark:bg-amber-500/20 dark:text-amber-300 dark:ring-amber-500/30'
                            : 'bg-slate-100 text-slate-600 hover:bg-amber-50 hover:text-amber-800 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-amber-500/10 dark:hover:text-amber-300' }}">

                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                        {{ __('در انتظار پرداخت') }}
                    </a>

                    {{-- لغوشده / ناموفق --}}
                    <a href="{{ route('user.invoices.index', ['status' => 'canceled']) }}"
                       class="inline-flex min-h-10 items-center justify-center rounded-xl px-3 py-2 text-center text-xs font-semibold transition-colors sm:px-4 sm:text-sm
                       {{ in_array($status, ['canceled', 'cancelled'])
                            ? 'bg-rose-100 text-rose-800 ring-1 ring-rose-300 dark:bg-rose-500/20 dark:text-rose-300 dark:ring-rose-500/30'
                            : 'bg-slate-100 text-slate-600 hover:bg-rose-50 hover:text-rose-700 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-rose-500/10 dark:hover:text-rose-300' }}">

                        {{ __('لغو شده / ناموفق') }}
                    </a>

                </div>
            </div>

            {{-- لیست فاکتورها --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800 sm:rounded-3xl">

                @if($orders->count() > 0)

                    {{-- نمایش موبایل: کارت‌های فاکتور --}}
                    <div class="space-y-3 p-3 sm:hidden">
                        @foreach($orders as $order)

                            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-800">

                                {{-- سربرگ کارت --}}
                                <div class="flex items-center justify-between gap-3 border-b border-slate-100 bg-slate-50/80 px-3 py-3 dark:border-slate-700 dark:bg-slate-700/30">
                                    <div class="min-w-0">
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                            {{ __('شماره فاکتور') }}
                                        </p>

                                        <p class="mt-1 truncate font-mono text-sm font-bold text-slate-800 dark:text-white">
                                            #{{ $order->order_number ?? $order->id }}
                                        </p>
                                    </div>

                                    @php
                                        $invoiceStatusClasses = $order->status === 'paid'
                                            ? 'bg-emerald-100 text-emerald-800 ring-emerald-300 dark:bg-emerald-500/20 dark:text-emerald-300 dark:ring-emerald-500/30'
                                            : ($order->status === 'pending'
                                                ? 'bg-amber-100 text-amber-800 ring-amber-300 dark:bg-amber-500/20 dark:text-amber-300 dark:ring-amber-500/30'
                                                : $order->status_badge_classes);
                                    @endphp

                                    <span class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $invoiceStatusClasses }}">
                                        {{ $order->status_label }}
                                    </span>
                                </div>

                                {{-- اقلام خریداری‌شده --}}
                                <div class="space-y-2 px-3 py-3">
                                    <p class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                                        {{ __('اقلام خریداری‌شده') }}
                                    </p>

                                    <div class="space-y-2">
                                        @forelse($order->items as $item)
                                            <div class="flex items-start gap-2 text-sm text-slate-700 dark:text-slate-300">
                                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-blue-500"></span>

                                                <span class="min-w-0 break-words leading-6">
                                                    {{ $item->title }}

                                                    @if($item->quantity > 1)
                                                        <span class="mr-1 text-xs text-slate-400">
                                                            ({{ $item->quantity }} {{ __('عدد') }})
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                        @empty
                                            <p class="text-xs text-slate-400">
                                                {{ __('بدون آیتم') }}
                                            </p>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- مبلغ و تاریخ --}}
                                <div class="grid grid-cols-2 gap-3 border-t border-slate-100 px-3 py-3 dark:border-slate-700">
                                    <div class="min-w-0">
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                            {{ __('مبلغ نهایی') }}
                                        </p>

                                        <p class="mt-1 break-words text-sm font-bold text-slate-900 dark:text-white">
                                            {{ $order->formatted_payable_amount }}

                                            <span class="text-[10px] font-normal text-slate-500 dark:text-slate-400">
                                                {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                            </span>
                                        </p>
                                    </div>

                                    <div class="min-w-0 text-left">
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                            {{ __('تاریخ ثبت') }}
                                        </p>

                                        <p class="mt-1 break-words text-xs leading-5 text-slate-600 dark:text-slate-300" dir="ltr">
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

                                {{-- مشاهده فاکتور --}}
                                <div class="border-t border-slate-100 p-3 dark:border-slate-700">
                                    <a href="{{ route('user.invoices.show', $order) }}"
                                       class="inline-flex min-h-10 w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800">

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

                    {{-- نمایش دسکتاپ: جدول --}}
                    <div class="hidden overflow-x-auto sm:block">
                        <table class="w-full text-right text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 dark:border-slate-700 dark:bg-slate-700/30 dark:text-slate-400">
                                    <th scope="col" class="whitespace-nowrap px-5 py-4 font-semibold lg:px-6">
                                        {{ __('شماره فاکتور') }}
                                    </th>

                                    <th scope="col" class="px-5 py-4 font-semibold lg:px-6">
                                        {{ __('اقلام خریداری‌شده') }}
                                    </th>

                                    <th scope="col" class="whitespace-nowrap px-5 py-4 font-semibold lg:px-6">
                                        {{ __('مبلغ نهایی') }}
                                    </th>

                                    <th scope="col" class="whitespace-nowrap px-5 py-4 font-semibold lg:px-6">
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

                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700/60">
                                @foreach($orders as $order)

                                    <tr class="transition-colors hover:bg-slate-50/80 dark:hover:bg-slate-700/20">

                                        {{-- شماره فاکتور --}}
                                        <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-slate-800 dark:text-slate-200 lg:px-6">
                                            #{{ $order->order_number ?? $order->id }}
                                        </td>

                                        {{-- اقلام خریداری‌شده --}}
                                        <td class="px-5 py-4 lg:px-6">
                                            <div class="flex max-w-xs flex-col gap-2">
                                                @forelse($order->items as $item)
                                                    <span class="break-words font-medium leading-6 text-slate-700 dark:text-slate-300">
                                                        <span class="text-blue-500">•</span>
                                                        {{ $item->title }}

                                                        @if($item->quantity > 1)
                                                            <span class="text-xs text-slate-400">
                                                                ({{ $item->quantity }} {{ __('عدد') }})
                                                            </span>
                                                        @endif
                                                    </span>
                                                @empty
                                                    <span class="text-xs text-slate-400">
                                                        {{ __('بدون آیتم') }}
                                                    </span>
                                                @endforelse
                                            </div>
                                        </td>

                                        {{-- مبلغ --}}
                                        <td class="whitespace-nowrap px-5 py-4 font-bold text-slate-900 dark:text-white lg:px-6">
                                            {{ $order->formatted_payable_amount }}

                                            <span class="mr-1 text-xs font-normal text-slate-500 dark:text-slate-400">
                                                {{ $order->currency === 'IRT' ? __('تومان') : __('ریال') }}
                                            </span>
                                        </td>

                                        {{-- تاریخ --}}
                                        <td class="whitespace-nowrap px-5 py-4 text-xs text-slate-500 dark:text-slate-400 lg:px-6">
                                            @if(function_exists('jdate'))
                                                {{ jdate($order->created_at)->format('Y/m/d - H:i') }}
                                            @elseif(function_exists('verta'))
                                                {{ verta($order->created_at)->format('Y/m/d - H:i') }}
                                            @else
                                                {{ $order->created_at->format('Y-m-d - H:i') }}
                                            @endif
                                        </td>

                                        {{-- وضعیت پرداخت --}}
                                        <td class="whitespace-nowrap px-5 py-4 text-center lg:px-6">
                                            <span class="inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold ring-1 ring-inset
                                                {{ $order->status === 'paid'
                                                    ? 'bg-emerald-100 text-emerald-800 ring-emerald-300 dark:bg-emerald-500/20 dark:text-emerald-300 dark:ring-emerald-500/30'
                                                    : ($order->status === 'pending'
                                                        ? 'bg-amber-100 text-amber-800 ring-amber-300 dark:bg-amber-500/20 dark:text-amber-300 dark:ring-amber-500/30'
                                                        : $order->status_badge_classes) }}">

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
                                        </td>

                                        {{-- عملیات --}}
                                        <td class="whitespace-nowrap px-5 py-4 text-center lg:px-6">
                                            <a href="{{ route('user.invoices.show', $order) }}"
                                               class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-semibold text-blue-700 transition-colors hover:border-blue-600 hover:bg-blue-600 hover:text-white dark:border-blue-500/20 dark:bg-blue-500/10 dark:text-blue-300 dark:hover:border-blue-600 dark:hover:bg-blue-600 dark:hover:text-white">

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
                        <div class="border-t border-slate-200 px-3 py-4 dark:border-slate-700 sm:px-6 sm:py-5">
                            {{ $orders->links() }}
                        </div>
                    @endif

                @else

                    {{-- حالت خالی --}}
                    <div class="px-4 py-14 text-center sm:py-20">
                        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-700/50 dark:text-slate-500">
                            <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2 3.5-2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-slate-700 dark:text-slate-200">
                            {{ __('هیچ فاکتوری یافت نشد') }}
                        </h3>

                        <p class="mx-auto mt-2 max-w-sm text-sm leading-6 text-slate-500 dark:text-slate-400">
                            {{ __('در حال حاضر هیچ سفارش یا فاکتوری در این وضعیت ثبت نشده است.') }}
                        </p>

                        @if(!is_null($status))
                            <a href="{{ route('user.invoices.index') }}"
                               class="mt-5 inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-blue-700">
                                {{ __('مشاهده همه فاکتورها') }}
                            </a>
                        @endif
                    </div>

                @endif

            </div>

        </div>
    </div>
</x-app-layout>
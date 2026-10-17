@extends('admin.layout.app')

@section('content')
<div class="space-y-8">

    {{-- ================= هدر صفحه (هماهنگ با استایل جدید ProPark) ================= --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        
        {{-- افکت‌های هاله نوری درخشان با ته‌رنگ نیلی، آبی و بنفش نئونی --}}
        <div class="pointer-events-none absolute -top-16 left-1/2 -translate-x-1/2 h-36 w-[550px] rounded-full bg-gradient-to-r from-blue-600/20 via-indigo-600/25 to-purple-600/20 blur-[85px] opacity-75"></div>
        <div class="pointer-events-none absolute -top-12 -right-8 h-40 w-40 rounded-full bg-indigo-500/15 blur-[55px] opacity-50"></div>
        <div class="pointer-events-none absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-blue-500/10 blur-[45px] opacity-40"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div class="flex items-center gap-4">
                {{-- آیکون هدر --}}
                <div class="hidden sm:flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700/50 shadow-lg">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                        <span>{{ __('مدیریت پلن‌های فروشگاه') }}</span>
                    </h2>
                    <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 font-normal">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                        <span>{{ __('تعیین قیمت اصلی، درصد تخفیف و محاسبه خودکار قیمت نهایی فروش') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-3">
                {{-- دکمه هدایت به مدیریت تعرفه‌های پشتیبانی --}}
                <a
                    href="{{ url('admin/store/support-prices') }}"
                    class="group relative inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/30 ring-1 ring-white/20 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60 active:translate-y-0"
                >
                    <div class="flex h-6 w-6 items-center justify-center rounded-xl bg-white/15 border border-white/20 shadow-inner">
                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 19a3 3 0 01-3 3h-3" />
                        </svg>
                    </div>

                    <span>{{ __('مدیریت تعرفه پشتیبانی') }}</span>

                    <svg class="h-4 w-4 rtl:rotate-180 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                {{-- بج تعداد پلن‌ها --}}
                <div class="group relative overflow-hidden inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl border border-gray-800/80 bg-gray-950/40 text-gray-300 shadow-inner backdrop-blur-sm transition-all hover:border-gray-700">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="text-[11px] uppercase tracking-wider text-gray-500 font-bold">{{ __('تعداد پلن‌ها') }}:</span>
                    <span class="font-bold text-blue-400 font-mono text-base tracking-tighter">{{ $plans->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= پیام‌های سیستم ================= --}}
    @if(session('success'))
        <div class="relative overflow-hidden flex items-start gap-3 p-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-sm backdrop-blur-md shadow-lg shadow-emerald-950/20 animate-in fade-in slide-in-from-top-2 duration-300">
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent"></div>
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="relative z-10 font-medium">{{ session('success') }}</div>
        </div>
    @endif

    {{-- خطاهای اعتبارسنجی --}}
    @if($errors->any())
        <div class="relative overflow-hidden p-4 rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400 text-sm space-y-2 backdrop-blur-md shadow-lg shadow-rose-950/20">
            <div class="flex items-center gap-2 font-bold">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ __('خطا در داده‌های ارسالی') }}</span>
            </div>

            <ul class="list-disc list-inside text-xs space-y-1 pr-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= فرم ویرایش گروهی پلن‌ها ================= --}}
    <form action="{{ route('admin.store.prices.bulk-update') }}" method="POST" class="space-y-6" id="bulk-plan-form">
        @csrf
        @method('PUT')

        {{-- نمایش کارت‌های نسخه موبایل --}}
        <div class="block md:hidden space-y-4">
            @forelse($plans as $plan)
                <div class="rounded-3xl border border-gray-800/80 bg-gray-900/60 p-5 space-y-4 shadow-xl backdrop-blur-xl plan-row relative group transition-all hover:border-gray-700" data-plan-id="{{ $plan->id }}">
                    <div class="flex items-start justify-between gap-3 border-b border-gray-800/80 pb-3">
                        <div>
                            <div class="text-base font-bold text-white group-hover:text-blue-400 transition-colors">
                                {{ $plan->title }}
                            </div>
                            <span class="text-xs font-mono text-cyan-400/80 bg-cyan-950/30 px-2 py-0.5 rounded-md border border-cyan-800/30 inline-block mt-1">#{{ $plan->slug }}</span>
                        </div>

                        <div class="px-2.5 py-1 rounded-xl text-[10px] font-bold border {{ $plan->is_active ? 'border-emerald-500/30 bg-emerald-500/10 text-emerald-400' : 'border-gray-700 bg-gray-800/60 text-gray-500' }}">
                            {{ $plan->is_active ? __('فعال') : __('غیرفعال') }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3.5">
                        {{-- قیمت اصلی --}}
                        <div>
                            <label class="block text-[11px] text-gray-400 mb-1.5 font-medium">{{ __('قیمت اصلی پلن') }} <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    name="plans[{{ $plan->id }}][original_price]"
                                    value="{{ number_format((int) ($plan->original_price ?? $plan->price ?? 0)) }}"
                                    required
                                    data-price-input
                                    class="plan-original-price w-full rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2.5 px-3 ltr text-left focus:border-blue-600 focus:ring-0 focus:outline-none transition"
                                >
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ __('تومان') }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            {{-- درصد تخفیف --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5 font-medium">{{ __('تخفیف (٪)') }}</label>
                                <input
                                    type="number"
                                    name="plans[{{ $plan->id }}][discount_percent]"
                                    value="{{ $plan->discount_percent ?? 0 }}"
                                    min="0"
                                    max="100"
                                    class="plan-discount w-full rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2.5 px-3 text-center focus:border-blue-600 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-mono"
                                >
                            </div>

                            {{-- تعداد دستگاه --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5 font-medium">{{ __('دستگاه مجاز') }}</label>
                                <input
                                    type="number"
                                    name="plans[{{ $plan->id }}][max_devices]"
                                    value="{{ $plan->max_devices ?? 1 }}"
                                    min="1"
                                    class="w-full rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2.5 px-3 text-center focus:border-blue-600 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-mono"
                                >
                            </div>
                        </div>

                        {{-- قیمت نهایی محاسبه شده --}}
                        <div class="p-3.5 rounded-2xl bg-gradient-to-r from-blue-950/30 to-indigo-950/20 border border-blue-900/40 flex items-center justify-between">
                            <span class="text-xs text-blue-300 font-medium">{{ __('قیمت نهایی فروش') }}:</span>
                            <div class="text-sm font-bold text-emerald-400 font-mono flex items-center gap-1.5">
                                <span class="plan-calculated-price text-base">{{ number_format((int) $plan->price) }}</span>
                                <span class="text-[11px] text-gray-400 font-normal">{{ __('تومان') }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            {{-- ترتیب نمایش --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5 font-medium">{{ __('ترتیب نمایش') }}</label>
                                <input
                                    type="number"
                                    name="plans[{{ $plan->id }}][sort_order]"
                                    value="{{ $plan->sort_order ?? 0 }}"
                                    class="w-full rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2.5 px-3 text-center focus:border-blue-600 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-mono"
                                >
                            </div>

                            {{-- وضعیت --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5 font-medium">{{ __('وضعیت') }}</label>
                                <select
                                    name="plans[{{ $plan->id }}][is_active]"
                                    class="w-full rounded-xl border border-gray-800 bg-gray-950/60 text-gray-300 text-sm py-2.5 px-3 focus:border-blue-600 focus:ring-0 focus:outline-none transition cursor-pointer"
                                >
                                    <option value="1" class="bg-gray-900 text-gray-200" {{ $plan->is_active ? 'selected' : '' }}>{{ __('فعال') }}</option>
                                    <option value="0" class="bg-gray-900 text-gray-200" {{ !$plan->is_active ? 'selected' : '' }}>{{ __('غیرفعال') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-gray-800/80 bg-gray-900/60 p-10 text-center text-sm text-gray-500 backdrop-blur-xl">
                    {{ __('هیچ پلنی یافت نشد.') }}
                </div>
            @endforelse
        </div>

        {{-- نمایش جدول دسکتاپ --}}
        <div class="hidden md:block bg-gray-900/60 border border-gray-800/60 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-xl">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse min-w-[850px]">
                    <thead>
                        <tr class="bg-gray-950/80 border-b border-gray-800/60">
                            <th class="py-5 px-6 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap">{{ __('پلن') }}</th>
                            <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap">{{ __('قیمت اصلی (تومان)') }}</th>
                            <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap text-center">{{ __('تخفیف (٪)') }}</th>
                            <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap">{{ __('قیمت نهایی فروش (خودکار)') }}</th>
                            <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap text-center">{{ __('دستگاه') }}</th>
                            <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap text-center">{{ __('ترتیب') }}</th>
                            <th class="py-5 px-6 text-[11px] font-black text-gray-500 uppercase tracking-wider whitespace-nowrap">{{ __('وضعیت') }}</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800/40">
                        @forelse($plans as $plan)
                            <tr class="group hover:bg-blue-500/[0.02] transition-colors duration-200 plan-row" data-plan-id="{{ $plan->id }}">
                                {{-- مشخصات پلن --}}
                                <td class="py-4 px-6">
                                    <div class="font-bold text-white text-sm group-hover:text-blue-400 transition-colors">{{ $plan->title }}</div>
                                    <div class="text-[10px] font-mono text-cyan-400/80 bg-cyan-950/30 px-2 py-0.5 rounded border border-cyan-800/30 inline-block mt-1">#{{ $plan->slug }}</div>
                                </td>

                                {{-- قیمت اصلی --}}
                                <td class="py-4 px-4">
                                    <input
                                        type="text"
                                        inputmode="numeric"
                                        name="plans[{{ $plan->id }}][original_price]"
                                        value="{{ number_format((int) ($plan->original_price ?? $plan->price ?? 0)) }}"
                                        required
                                        data-price-input
                                        class="plan-original-price w-36 rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2 px-3 ltr text-left focus:border-blue-600 focus:ring-0 focus:outline-none transition font-mono"
                                    >
                                </td>

                                {{-- درصد تخفیف --}}
                                <td class="py-4 px-4 text-center">
                                    <div class="inline-flex items-center gap-1">
                                        <input
                                            type="number"
                                            name="plans[{{ $plan->id }}][discount_percent]"
                                            value="{{ $plan->discount_percent ?? 0 }}"
                                            min="0"
                                            max="100"
                                            class="plan-discount w-16 rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2 px-2 text-center focus:border-blue-600 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-mono"
                                        >
                                        <span class="text-xs text-gray-500 font-mono">٪</span>
                                    </div>
                                </td>

                                {{-- قیمت نهایی محاسبه شده --}}
                                <td class="py-4 px-4">
                                    <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-emerald-950/20 border border-emerald-800/30 text-emerald-400 font-mono text-sm font-bold shadow-inner">
                                        <span class="plan-calculated-price">{{ number_format((int) $plan->price) }}</span>
                                        <span class="text-[10px] font-normal text-gray-500">{{ __('تومان') }}</span>
                                    </div>
                                </td>

                                {{-- حداکثر دستگاه --}}
                                <td class="py-4 px-4 text-center">
                                    <input
                                        type="number"
                                        name="plans[{{ $plan->id }}][max_devices]"
                                        value="{{ $plan->max_devices ?? 1 }}"
                                        min="1"
                                        class="w-16 rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2 px-2 text-center focus:border-blue-600 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-mono"
                                    >
                                </td>

                                {{-- ترتیب نمایش --}}
                                <td class="py-4 px-4 text-center">
                                    <input
                                        type="number"
                                        name="plans[{{ $plan->id }}][sort_order]"
                                        value="{{ $plan->sort_order ?? 0 }}"
                                        class="w-16 rounded-xl border border-gray-800 bg-gray-950/60 text-gray-200 text-sm py-2 px-2 text-center focus:border-blue-600 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none font-mono"
                                    >
                                </td>

                                {{-- وضعیت --}}
                                <td class="py-4 px-6">
                                    <select
                                        name="plans[{{ $plan->id }}][is_active]"
                                        class="min-w-[100px] rounded-xl border border-gray-800 bg-gray-950/60 text-gray-300 text-xs py-2 px-2.5 focus:border-blue-600 focus:ring-0 focus:outline-none transition cursor-pointer"
                                    >
                                        <option value="1" class="bg-gray-900 text-gray-200" {{ $plan->is_active ? 'selected' : '' }}>{{ __('فعال') }}</option>
                                        <option value="0" class="bg-gray-900 text-gray-200" {{ !$plan->is_active ? 'selected' : '' }}>{{ __('غیرفعال') }}</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-sm text-gray-500">
                                    {{ __('هیچ پلنی برای نمایش یافت نشد.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- نوار شناور دکمه ذخیره تغییرات --}}
        @if($plans->count())
            <div class="sticky bottom-6 z-20 flex justify-end">
                <button
                    type="submit"
                    class="group relative inline-flex items-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-7 py-3.5 text-sm font-bold text-white shadow-2xl shadow-blue-600/40 ring-1 ring-white/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-blue-500/60 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400 active:translate-y-0 cursor-pointer"
                >
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ __('ذخیره همه تغییرات') }}</span>
                </button>
            </div>
        @endif
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bulk-plan-form');

        function onlyDigits(value) {
            return (value || '').toString().replace(/\D/g, '');
        }

        function formatNumber(value) {
            const digits = onlyDigits(value);
            if (!digits) return '0';
            return Number(digits).toLocaleString('en-US');
        }

        // تابع محاسبه خودکار قیمت فروش با احتساب درصد تخفیف
        function updateCalculatedPrice(row) {
            const originalInput = row.querySelector('.plan-original-price');
            const discountInput = row.querySelector('.plan-discount');
            const calculatedEl = row.querySelector('.plan-calculated-price');

            if (!originalInput || !calculatedEl) return;

            const originalPrice = parseInt(onlyDigits(originalInput.value)) || 0;
            const discountPercent = Math.min(100, Math.max(0, parseInt(discountInput ? discountInput.value : 0) || 0));

            let finalPrice = originalPrice;
            if (discountPercent > 0) {
                finalPrice = Math.round(originalPrice * (1 - (discountPercent / 100)));
            }

            calculatedEl.textContent = Number(finalPrice).toLocaleString('en-US');
        }

        // افزودن شنونده‌های رویداد (Event Listeners) به تمام اینپوت‌های قیمت و تخفیف
        document.querySelectorAll('.plan-row').forEach(row => {
            const originalInput = row.querySelector('.plan-original-price');
            const discountInput = row.querySelector('.plan-discount');

            if (originalInput) {
                originalInput.addEventListener('input', function () {
                    const oldValue = this.value;
                    const oldSelectionStart = this.selectionStart || 0;
                    const digitsBeforeCursor = onlyDigits(oldValue.slice(0, oldSelectionStart)).length;

                    const formatted = formatNumber(oldValue);
                    this.value = formatted;

                    let newCursor = formatted.length;
                    let digitCount = 0;

                    for (let i = 0; i < formatted.length; i++) {
                        if (/\d/.test(formatted[i])) {
                            digitCount++;
                        }
                        if (digitCount >= digitsBeforeCursor) {
                            newCursor = i + 1;
                            break;
                        }
                    }

                    this.setSelectionRange(newCursor, newCursor);
                    updateCalculatedPrice(row);
                });
            }

            if (discountInput) {
                discountInput.addEventListener('input', function () {
                    let val = parseInt(this.value);
                    if (val > 100) this.value = 100;
                    if (val < 0) this.value = 0;
                    updateCalculatedPrice(row);
                });
            }
        });

        // تمیز کردن کاماها قبل از ارسال فرم به سمت کنترلر
        if (form) {
            form.addEventListener('submit', function () {
                form.querySelectorAll('[data-price-input]').forEach((input) => {
                    input.value = onlyDigits(input.value);
                });
            });
        }
    });
</script>
@endsection

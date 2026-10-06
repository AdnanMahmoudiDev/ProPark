@extends('admin.layout.app')

@section('content')
<div class="space-y-8">

    {{-- هدر صفحه --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        <div class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 h-28 w-80 rounded-full bg-blue-500/10 blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                    <span>{{ __('مدیریت قیمت بسته‌های پشتیبانی') }}</span>
                </h2>
                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 font-normal">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-sm shadow-blue-500"></span>
                    <span>{{ __('تعیین و به‌روزرسانی قیمت، تخفیف، مدت اعتبار و ترتیب نمایش بسته‌ها') }}</span>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-3">
                {{-- دکمه شیک و تعاملی بازگشت به مدیریت پلن‌های فروشگاه --}}
                <a
                    href="{{ route('admin.store.index') }}"
                    class="group relative inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/30 ring-1 ring-white/20 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60 active:translate-y-0"
                >
                    {{-- آیکون پلن‌ها --}}
                    <div class="flex h-6 w-6 items-center justify-center rounded-xl bg-white/15 border border-white/20 shadow-inner">
                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>

                    <span>{{ __('مدیریت پلن‌های فروشگاه') }}</span>

                    {{-- فلش هدایت --}}
                    <svg class="h-4 w-4 rtl:rotate-180 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                {{-- بج تعداد بسته‌ها --}}
                <div class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl border border-gray-800/80 bg-gray-900/80 text-gray-300 text-xs font-semibold shadow-inner">
                    <span class="text-gray-400">{{ __('تعداد بسته‌ها:') }}</span>
                    <span class="font-bold text-blue-400 font-mono text-sm">{{ $packages->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- پیام‌های سیستم --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-sm font-semibold backdrop-blur-xl shadow-lg shadow-emerald-950/20">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400 text-sm space-y-2 backdrop-blur-xl shadow-lg shadow-rose-950/20">
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

    {{-- فرم ویرایش گروهی بسته‌ها --}}
    <form id="bulk-update-form" action="{{ route('admin.store.support-prices.bulk-update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($packages as $package)
                @php
                    $initialPrice = old("packages.{$package->id}.price", $package->original_price ?: $package->price);
                    $initialDiscount = old("packages.{$package->id}.discount_percent", $package->discount_percent ?? 0);
                @endphp

                <div class="package-card relative bg-gray-900/70 border border-gray-800 rounded-3xl p-5 sm:p-6 flex flex-col justify-between shadow-xl transition-all duration-300 hover:border-gray-700/80 hover:bg-gray-900/90"
                     data-package-id="{{ $package->id }}">
                    
                    <div>
                        {{-- هدر کارت --}}
                        <div class="flex items-center justify-between gap-3 pb-4 border-b border-gray-800/80">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 shadow-inner">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-white">{{ $package->title ?? __('بسته پشتیبانی') }}</h3>
                                </div>
                            </div>

                            <div class="px-2.5 py-1 rounded-xl text-[11px] font-medium border {{ ($package->is_active ?? true) ? 'border-emerald-700/60 bg-emerald-900/20 text-emerald-400' : 'border-gray-700 bg-gray-800/70 text-gray-400' }}">
                                {{ ($package->is_active ?? true) ? __('فعال') : __('غیرفعال') }}
                            </div>
                        </div>

                        {{-- فیلدهای ورودی --}}
                        <div class="mt-5 space-y-4">
                            
                            {{-- قیمت پایه --}}
                            <div>
                                <label class="block text-[11px] font-medium text-gray-400 mb-1.5">
                                    {{ __('قیمت اصلی بسته (تومان)') }} <span class="text-rose-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" 
                                           inputmode="numeric"
                                           data-price-input
                                           name="packages[{{ $package->id }}][price]"
                                           value="{{ number_format((int) $initialPrice) }}" 
                                           class="js-price-input w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 ltr text-left focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                           required>
                                    <span class="text-xs text-gray-500 whitespace-nowrap">{{ __('تومان') }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- درصد تخفیف --}}
                                <div>
                                    <label class="block text-[11px] font-medium text-gray-400 mb-1.5">
                                        {{ __('تخفیف (٪)') }}
                                    </label>
                                    <input type="number" 
                                           name="packages[{{ $package->id }}][discount_percent]" 
                                           value="{{ $initialDiscount }}" 
                                           min="0" max="100"
                                           class="js-discount-input w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </div>

                                {{-- مدت اعتبار --}}
                                <div>
                                    <label class="block text-[11px] font-medium text-gray-400 mb-1.5">
                                        {{ __('مدت (ماه)') }}
                                    </label>
                                    <input type="number" 
                                           name="packages[{{ $package->id }}][duration_months]" 
                                           value="{{ old('packages.'.$package->id.'.duration_months', $package->duration_months ?? 1) }}" 
                                           min="1"
                                           class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                {{-- ترتیب نمایش --}}
                                <div>
                                    <label class="block text-[11px] font-medium text-gray-400 mb-1.5">
                                        {{ __('ترتیب نمایش') }}
                                    </label>
                                    <input type="number" 
                                           name="packages[{{ $package->id }}][sort_order]" 
                                           value="{{ old('packages.'.$package->id.'.sort_order', $package->sort_order ?? 0) }}" 
                                           min="0"
                                           class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                </div>

                                {{-- وضعیت پکیج --}}
                                <div>
                                    <label class="block text-[11px] font-medium text-gray-400 mb-1.5">
                                        {{ __('وضعیت') }}
                                    </label>
                                    <select name="packages[{{ $package->id }}][is_active]" 
                                            class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2 px-2.5 focus:border-blue-700 focus:ring-0 focus:outline-none transition">
                                        <option value="1" class="bg-gray-900 text-gray-200" {{ old('packages.'.$package->id.'.is_active', $package->is_active ?? 1) == 1 ? 'selected' : '' }}>{{ __('فعال') }}</option>
                                        <option value="0" class="bg-gray-900 text-gray-200" {{ old('packages.'.$package->id.'.is_active', $package->is_active ?? 1) == 0 ? 'selected' : '' }}>{{ __('غیرفعال') }}</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- فوتر کارت و نمایش محاسبه زنده قیمت نهایی --}}
                    <div class="mt-6 pt-4 border-t border-gray-800/80 flex items-center justify-between">
                        <span class="text-xs text-blue-400">{{ __('قیمت نهایی فروش:') }}</span>
                        <div class="text-sm font-bold text-emerald-400 font-mono flex items-center gap-1.5">
                            <span class="js-final-price">0</span>
                            <span class="text-xs text-gray-400 font-normal">{{ __('تومان') }}</span>
                        </div>
                    </div>

                </div>
            @empty
                <div class="col-span-full p-12 text-center bg-gray-900/40 border border-dashed border-gray-800 rounded-3xl">
                    <p class="text-gray-500 text-sm">{{ __('هیچ بسته پشتیبانی در دیتابیس یافت نشد.') }}</p>
                </div>
            @endforelse
        </div>

        @if($packages->count())
            <div class="sticky bottom-4 z-10 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>{{ __('ذخیره تمام تغییرات') }}</span>
                </button>
            </div>
        @endif
    </form>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bulk-update-form');

        function onlyDigits(value) {
            return (value || '').toString().replace(/\D/g, '');
        }

        function formatNumber(value) {
            const digits = onlyDigits(value);
            if (!digits) return '0';
            return Number(digits).toLocaleString('en-US');
        }

        function calculateCardPrice(card) {
            const priceInput = card.querySelector('.js-price-input');
            const discountInput = card.querySelector('.js-discount-input');
            const finalPriceEl = card.querySelector('.js-final-price');

            if (!priceInput || !discountInput || !finalPriceEl) return;

            const rawPrice = parseInt(onlyDigits(priceInput.value), 10) || 0;
            const discount = Math.min(100, Math.max(0, parseInt(discountInput.value, 10) || 0));

            let finalPrice = rawPrice;
            if (discount > 0) {
                finalPrice = Math.round(rawPrice * (1 - (discount / 100)));
            }

            finalPriceEl.textContent = Number(finalPrice).toLocaleString('en-US');
        }

        document.querySelectorAll('.package-card').forEach(function (card) {
            const priceInput = card.querySelector('.js-price-input');
            const discountInput = card.querySelector('.js-discount-input');

            // اجرای آنی برای لود اولیه
            calculateCardPrice(card);

            if (priceInput) {
                priceInput.addEventListener('input', function () {
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
                    calculateCardPrice(card);
                });
            }

            if (discountInput) {
                discountInput.addEventListener('input', function () {
                    let val = parseInt(this.value);
                    if (val > 100) this.value = 100;
                    if (val < 0) this.value = 0;
                    calculateCardPrice(card);
                });
            }
        });

        // حذف جداکننده‌های هزارگان قبل از سابمیت فرم
        if (form) {
            form.addEventListener('submit', function () {
                form.querySelectorAll('[data-price-input]').forEach((input) => {
                    input.value = onlyDigits(input.value);
                });
            });
        }
    });
</script>
@endpush

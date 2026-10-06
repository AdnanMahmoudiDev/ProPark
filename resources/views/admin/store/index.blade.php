@extends('admin.layout.app')

@section('content')
<div class="space-y-8">

    {{-- هدر صفحه --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        <div class="pointer-events-none absolute -top-10 left-1/2 -translate-x-1/2 h-28 w-80 rounded-full bg-blue-500/10 blur-3xl"></div>
        
        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                    <span>مدیریت پلن‌های فروشگاه</span>
                </h2>
                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 font-normal">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-sm shadow-blue-500"></span>
                    <span>تعیین قیمت اصلی، درصد تخفیف و محاسبه خودکار قیمت نهایی فروش</span>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-3">
                {{-- دکمه شیک، مدرن و برجسته هدایت به مدیریت تعرفه‌های پشتیبانی --}}
                <a
                    href="{{ url('admin/store/support-prices') }}"
                    class="group relative inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/30 ring-1 ring-white/20 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60 active:translate-y-0"
                >
                    {{-- آیکون پشتیبانی --}}
                    <div class="flex h-6 w-6 items-center justify-center rounded-xl bg-white/15 border border-white/20 shadow-inner">
                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 19a3 3 0 01-3 3h-3" />
                        </svg>
                    </div>

                    <span>مدیریت تعرفه پشتیبانی</span>

                    {{-- فلش حرکتی --}}
                    <svg class="h-4 w-4 rtl:rotate-180 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                {{-- بج تعداد پلن‌ها --}}
                <div class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl border border-gray-800/80 bg-gray-900/80 text-gray-300 text-xs font-semibold shadow-inner">
                    <span class="text-gray-400">تعداد پلن‌ها:</span>
                    <span class="font-bold text-blue-400 font-mono text-sm">{{ $plans->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-sm font-semibold backdrop-blur-xl shadow-lg shadow-emerald-950/20">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- خطاهای اعتبارسنجی --}}
    @if($errors->any())
        <div class="p-4 rounded-2xl border border-rose-500/30 bg-rose-500/10 text-rose-400 text-sm space-y-2 backdrop-blur-xl shadow-lg shadow-rose-950/20">
            <div class="flex items-center gap-2 font-bold">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>خطا در داده‌های ارسالی</span>
            </div>

            <ul class="list-disc list-inside text-xs space-y-1 pr-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- فرم ویرایش گروهی پلن‌ها --}}
    <form action="{{ route('admin.store.prices.bulk-update') }}" method="POST" class="space-y-6" id="bulk-plan-form">
        @csrf
        @method('PUT')

        {{-- کارت‌های نسخه موبایل --}}
        <div class="block md:hidden space-y-4">
            @forelse($plans as $plan)
                <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-5 space-y-4 shadow-lg plan-row" data-plan-id="{{ $plan->id }}">
                    <div class="flex items-start justify-between gap-3 border-b border-gray-800/80 pb-3">
                        <div>
                            <div class="text-base font-bold text-white">
                                {{ $plan->title }}
                            </div>
                            <span class="text-xs font-mono text-cyan-400/80">#{{ $plan->slug }}</span>
                        </div>

                        <div class="px-2.5 py-1 rounded-lg text-[11px] border {{ $plan->is_active ? 'border-emerald-700 bg-emerald-900/20 text-emerald-400' : 'border-gray-700 bg-gray-800/70 text-gray-400' }}">
                            {{ $plan->is_active ? 'فعال' : 'غیرفعال' }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-3.5">
                        {{-- قیمت اصلی --}}
                        <div>
                            <label class="block text-[11px] text-gray-400 mb-1.5">قیمت اصلی پلن <span class="text-rose-500">*</span></label>
                            <div class="flex items-center gap-2">
                                <input
                                    type="text"
                                    inputmode="numeric"
                                    name="plans[{{ $plan->id }}][original_price]"
                                    value="{{ number_format((int) ($plan->original_price ?? $plan->price ?? 0)) }}"
                                    required
                                    data-price-input
                                    class="plan-original-price w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 ltr text-left focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                >
                                <span class="text-xs text-gray-500 whitespace-nowrap">تومان</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            {{-- درصد تخفیف --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5">تخفیف (٪)</label>
                                <input
                                    type="number"
                                    name="plans[{{ $plan->id }}][discount_percent]"
                                    value="{{ $plan->discount_percent ?? 0 }}"
                                    min="0"
                                    max="100"
                                    class="plan-discount w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                >
                            </div>

                            {{-- تعداد دستگاه --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5">دستگاه مجاز</label>
                                <input
                                    type="number"
                                    name="plans[{{ $plan->id }}][max_devices]"
                                    value="{{ $plan->max_devices ?? 1 }}"
                                    min="1"
                                    class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                >
                            </div>
                        </div>

                        {{-- قیمت نهایی محاسبه شده (سیستمی) --}}
                        <div class="p-3 rounded-2xl bg-blue-950/20 border border-blue-900/40 flex items-center justify-between">
                            <span class="text-xs text-blue-400">قیمت نهایی فروش:</span>
                            <div class="text-sm font-bold text-emerald-400 font-mono flex items-center gap-1.5">
                                <span class="plan-calculated-price">{{ number_format((int) $plan->price) }}</span>
                                <span class="text-xs text-gray-400 font-normal">تومان</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            {{-- ترتیب نمایش --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5">ترتیب نمایش</label>
                                <input
                                    type="number"
                                    name="plans[{{ $plan->id }}][sort_order]"
                                    value="{{ $plan->sort_order ?? 0 }}"
                                    class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                >
                            </div>

                            {{-- وضعیت --}}
                            <div>
                                <label class="block text-[11px] text-gray-400 mb-1.5">وضعیت</label>
                                <select
                                    name="plans[{{ $plan->id }}][is_active]"
                                    class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2 px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                >
                                    <option value="1" class="bg-gray-900 text-gray-200" {{ $plan->is_active ? 'selected' : '' }}>فعال</option>
                                    <option value="0" class="bg-gray-900 text-gray-200" {{ !$plan->is_active ? 'selected' : '' }}>غیرفعال</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-8 text-center text-sm text-gray-500">
                    هیچ پلنی یافت نشد.
                </div>
            @endforelse
        </div>

        {{-- جدول نسخه دسکتاپ --}}
        <div class="hidden md:block rounded-3xl border border-gray-800 bg-gray-900/70 shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse min-w-[850px]">
                    <thead>
                        <tr class="border-b border-gray-800 bg-gradient-to-r from-[#111827] via-[#0f172a] to-[#111827]">
                            <th class="py-4 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">پلن</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 whitespace-nowrap">قیمت اصلی (تومان)</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 whitespace-nowrap">تخفیف (٪)</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 whitespace-nowrap">قیمت نهایی فروش (خودکار)</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 whitespace-nowrap">دستگاه مجاز</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 whitespace-nowrap">ترتیب</th>
                            <th class="py-4 px-4 text-xs font-semibold text-gray-400 whitespace-nowrap">وضعیت</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800/40">
                        @forelse($plans as $plan)
                            <tr class="hover:bg-gray-800/20 transition duration-150 plan-row" data-plan-id="{{ $plan->id }}">
                                {{-- مشخصات پلن --}}
                                <td class="py-4 px-4">
                                    <div class="font-bold text-white text-sm">{{ $plan->title }}</div>
                                    <div class="text-[11px] font-mono text-cyan-400/80 mt-0.5">#{{ $plan->slug }}</div>
                                </td>

                                {{-- قیمت اصلی (ورودی ادمین) --}}
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            name="plans[{{ $plan->id }}][original_price]"
                                            value="{{ number_format((int) ($plan->original_price ?? $plan->price ?? 0)) }}"
                                            required
                                            data-price-input
                                            class="plan-original-price w-36 rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-3 ltr text-left focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                        >
                                    </div>
                                </td>

                                {{-- درصد تخفیف --}}
                                <td class="py-4 px-3">
                                    <div class="flex items-center gap-1.5">
                                        <input
                                            type="number"
                                            name="plans[{{ $plan->id }}][discount_percent]"
                                            value="{{ $plan->discount_percent ?? 0 }}"
                                            min="0"
                                            max="100"
                                            class="plan-discount w-20 rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-2 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        >
                                        <span class="text-xs text-gray-500 whitespace-nowrap">٪</span>
                                    </div>
                                </td>

                                {{-- قیمت نهایی فروش (محاسبه خودکار و نمایشی) --}}
                                <td class="py-4 px-3">
                                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-950/30 border border-emerald-800/40 text-emerald-400 font-mono text-sm font-semibold">
                                        <span class="plan-calculated-price">{{ number_format((int) $plan->price) }}</span>
                                        <span class="text-[11px] font-normal text-gray-400">تومان</span>
                                    </div>
                                </td>

                                {{-- حداکثر دستگاه --}}
                                <td class="py-4 px-3">
                                    <input
                                        type="number"
                                        name="plans[{{ $plan->id }}][max_devices]"
                                        value="{{ $plan->max_devices ?? 1 }}"
                                        min="1"
                                        class="w-20 rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-2 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    >
                                </td>

                                {{-- ترتیب نمایش --}}
                                <td class="py-4 px-3">
                                    <input
                                        type="number"
                                        name="plans[{{ $plan->id }}][sort_order]"
                                        value="{{ $plan->sort_order ?? 0 }}"
                                        class="w-16 rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2 px-2 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    >
                                </td>

                                {{-- وضعیت --}}
                                <td class="py-4 px-4">
                                    <select
                                        name="plans[{{ $plan->id }}][is_active]"
                                        class="min-w-[100px] rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2 px-2.5 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                    >
                                        <option value="1" class="bg-gray-900 text-gray-200" {{ $plan->is_active ? 'selected' : '' }}>فعال</option>
                                        <option value="0" class="bg-gray-900 text-gray-200" {{ !$plan->is_active ? 'selected' : '' }}>غیرفعال</option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-sm text-gray-500">
                                    هیچ پلنی برای نمایش یافت نشد.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($plans->count())
            <div class="sticky bottom-4 z-10 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 px-6 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span>ذخیره همه تغییرات</span>
                </button>
            </div>
        @endif
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('bulk-plan-form');
        const priceInputs = document.querySelectorAll('[data-price-input]');

        function onlyDigits(value) {
            return (value || '').toString().replace(/\D/g, '');
        }

        function formatNumber(value) {
            const digits = onlyDigits(value);
            if (!digits) return '0';
            return Number(digits).toLocaleString('en-US');
        }

        // تابع محاسبه قیمت فروش بر اساس قیمت اصلی و درصد تخفیف
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

        // افزودن رویداد به ردیف‌ها
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

        // تمیز کردن کاماها قبل از سابمیت فرم
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

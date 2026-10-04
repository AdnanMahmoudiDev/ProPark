@extends('admin.layout.app')

@section('content')
<div class="space-y-8">

    {{-- هدر صفحه --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white leading-tight">
                مدیریت پلن‌های فروشگاه
            </h2>
            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span>تعیین قیمت اصلی، درصد تخفیف و محاسبه خودکار قیمت نهایی فروش</span>
            </div>
        </div>

        <div class="px-4 py-2 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 text-xs">
            تعداد پلن‌ها: {{ $plans->count() }}
        </div>
    </div>

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-green-700 bg-green-900/20 text-green-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- خطاهای اعتبارسنجی --}}
    @if($errors->any())
        <div class="p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm space-y-2">
            <div class="flex items-center gap-2 font-bold">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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

                        <div class="px-2.5 py-1 rounded-lg text-[11px] border {{ $plan->is_active ? 'border-green-700 bg-green-900/20 text-green-400' : 'border-gray-700 bg-gray-800/70 text-gray-400' }}">
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
                    class="inline-flex items-center gap-2 rounded-2xl border border-blue-800 bg-blue-900/90 backdrop-blur px-6 py-3 text-sm font-medium text-blue-300 transition duration-200 hover:bg-blue-800 hover:text-white shadow-lg cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
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

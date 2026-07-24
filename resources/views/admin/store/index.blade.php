@extends('admin.layout.app')

@section('content')
<div class="space-y-8">

    {{-- هدر --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white leading-tight">
                مدیریت پلن‌های فروشگاه
            </h2>
            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span>ویرایش گروهی قیمت‌ها، تخفیف‌ها و وضعیت فعال‌بودن پلن‌های فروشگاه AvaPark</span>
            </div>
        </div>

        <div class="px-4 py-2 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 text-xs">
            تعداد پلن‌ها: {{ $plans->count() }}
        </div>
    </div>

    {{-- پیام موفقیت بودن --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-green-700 bg-green-900/20 text-green-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- ارور های اعتبار سنجی --}}
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

    {{-- فرم --}}
    <form action="{{ route('admin.store.prices.bulk-update') }}" method="POST" class="space-y-8" id="bulk-price-form">
        @csrf
        @method('PUT')

        @forelse($plans as $plan)
            <section class="rounded-3xl border border-gray-800 bg-gray-900/70 shadow-lg overflow-hidden">

                {{-- هدر پلن --}}
                <div class="px-4 sm:px-6 py-5 border-b border-gray-800 bg-gradient-to-r from-[#111827] via-[#0f172a] to-[#111827]">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3">
                            <div class="min-w-0">
                                <h3 class="text-lg font-bold text-white break-words">
                                    {{ $plan->title }}
                                </h3>
                                <p class="mt-1 text-sm text-gray-400 leading-7 break-words">
                                    {{ $plan->description ?: 'توضیحی برای این پلن ثبت نشده است.' }}
                                </p>
                            </div>

                            <div class="self-start md:self-auto shrink-0 px-3 py-1.5 rounded-xl border border-cyan-800 bg-cyan-900/20 text-cyan-300 text-xs whitespace-nowrap">
                                تعداد بازه‌های قیمت: {{ $plan->prices->count() }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- مخصوص موبایل --}}
                <div class="block md:hidden p-4 space-y-4">
                    @forelse($plan->prices as $price)
                        <div class="rounded-2xl border border-gray-800 bg-black/20 p-4 space-y-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="text-sm font-bold text-white">
                                        بازه {{ $price->duration_months }} ماهه
                                    </div>
                                    <div class="mt-1 text-xs font-mono text-gray-500">
                                        شناسه: #{{ $price->id }}
                                    </div>
                                </div>

                                <div class="px-2.5 py-1 rounded-lg text-[11px] border {{ $price->is_active ? 'border-green-700 bg-green-900/20 text-green-400' : 'border-gray-700 bg-gray-800/70 text-gray-400' }}">
                                    {{ $price->is_active ? 'فعال' : 'غیرفعال' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                {{-- قیمت --}}
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-2">
                                        قیمت
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="text"
                                            inputmode="numeric"
                                            name="prices[{{ $price->id }}][price]"
                                            value="{{ number_format((int) $price->price) }}"
                                            required
                                            data-price-input
                                            class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2.5 px-3 ltr text-left focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                        >
                                        <span class="text-xs text-gray-500 whitespace-nowrap">تومان</span>
                                    </div>
                                </div>

                                {{-- تخفیف --}}
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-2">
                                        درصد تخفیف
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="number"
                                            name="prices[{{ $price->id }}][discount_percent]"
                                            value="{{ $price->discount_percent }}"
                                            min="0"
                                            max="100"
                                            required
                                            class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2.5 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        >
                                        <span class="text-xs text-gray-500 whitespace-nowrap">٪</span>
                                    </div>
                                </div>

                                {{-- وضعیت --}}
                                <div>
                                    <label class="block text-[11px] text-gray-500 mb-2">
                                        وضعیت
                                    </label>
                                    <select
                                        name="prices[{{ $price->id }}][is_active]"
                                        class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2.5 px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                    >
                                        <option value="1" class="bg-gray-900 text-gray-200" {{ $price->is_active ? 'selected' : '' }}>
                                            فعال
                                        </option>
                                        <option value="0" class="bg-gray-900 text-gray-200" {{ !$price->is_active ? 'selected' : '' }}>
                                            غیرفعال
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-gray-800 bg-black/10 px-4 py-8 text-center text-sm text-gray-500">
                            هیچ بازه قیمتی برای این پلن ثبت نشده است.
                        </div>
                    @endforelse
                </div>

                {{-- مخصوص موبایل --}}
                <div class="hidden md:block p-4 lg:p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-right border-collapse min-w-[760px]">
                            <thead>
                                <tr class="border-b border-gray-800">
                                    <th class="py-3 px-2 text-xs font-semibold text-gray-400 whitespace-nowrap">شناسه</th>
                                    <th class="py-3 px-2 text-xs font-semibold text-gray-400 whitespace-nowrap">مدت (ماه)</th>
                                    <th class="py-3 px-2 text-xs font-semibold text-gray-400 whitespace-nowrap">قیمت</th>
                                    <th class="py-3 px-2 text-xs font-semibold text-gray-400 whitespace-nowrap">درصد تخفیف</th>
                                    <th class="py-3 px-2 text-xs font-semibold text-gray-400 whitespace-nowrap">وضعیت</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-800/40">
                                @forelse($plan->prices as $price)
                                    <tr class="hover:bg-gray-800/20 transition duration-150">
                                        {{-- ایدی --}}
                                        <td class="py-4 px-2 text-sm font-mono text-gray-300 whitespace-nowrap">
                                            #{{ $price->id }}
                                        </td>

                                        {{-- بازه زمانی --}}
                                        <td class="py-4 px-2 text-sm text-white font-medium whitespace-nowrap">
                                            {{ $price->duration_months }} ماه
                                        </td>

                                        {{-- قیمت --}}
                                        <td class="py-4 px-2">
                                            <div class="flex items-center gap-3">
                                                <input
                                                    type="text"
                                                    inputmode="numeric"
                                                    name="prices[{{ $price->id }}][price]"
                                                    value="{{ number_format((int) $price->price) }}"
                                                    required
                                                    data-price-input
                                                    class="w-36 rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2.5 px-3 ltr text-left focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                                >
                                                <span class="text-xs text-gray-500 whitespace-nowrap">تومان</span>
                                            </div>
                                        </td>

                                        {{-- تخفیف --}}
                                        <td class="py-4 px-2">
                                            <div class="flex items-center gap-3">
                                                <input
                                                    type="number"
                                                    name="prices[{{ $price->id }}][discount_percent]"
                                                    value="{{ $price->discount_percent }}"
                                                    min="0"
                                                    max="100"
                                                    required
                                                    class="w-24 rounded-xl border border-gray-800 bg-black/40 text-gray-200 text-sm py-2.5 px-3 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                >
                                                <span class="text-xs text-gray-500 whitespace-nowrap">٪</span>
                                            </div>
                                        </td>

                                        {{-- فعال --}}
                                        <td class="py-4 px-2">
                                            <select
                                                name="prices[{{ $price->id }}][is_active]"
                                                class="min-w-[110px] rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2.5 px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                            >
                                                <option value="1" class="bg-gray-900 text-gray-200" {{ $price->is_active ? 'selected' : '' }}>
                                                    فعال
                                                </option>
                                                <option value="0" class="bg-gray-900 text-gray-200" {{ !$price->is_active ? 'selected' : '' }}>
                                                    غیرفعال
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-8 text-center text-sm text-gray-500">
                                            هیچ بازه قیمتی برای این پلن ثبت نشده است.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        @empty
            <div class="rounded-3xl border border-gray-800 bg-gray-900/70 p-10 text-center">
                <div class="mx-auto w-14 h-14 rounded-2xl bg-gray-800/80 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-3V3.5A1.5 1.5 0 0013.5 2h-3A1.5 1.5 0 009 3.5V5H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-white">هیچ پلنی یافت نشد</h3>
                <p class="mt-2 text-sm text-gray-500">
                    در حال حاضر هیچ پلنی برای نمایش یا ویرایش در فروشگاه ثبت نشده است.
                </p>
            </div>
        @endforelse

        @if($plans->count())
            <div class="sticky bottom-4 z-10 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-2xl border border-blue-800 bg-blue-900/90 backdrop-blur px-6 py-3 text-sm font-medium text-blue-300 transition duration-200 hover:bg-blue-800 hover:text-white shadow-lg"
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
        const form = document.getElementById('bulk-price-form');
        const priceInputs = document.querySelectorAll('[data-price-input]');

        function onlyDigits(value) {
            return value.replace(/\D/g, '');
        }

        function formatNumber(value) {
            const digits = onlyDigits(value);
            if (!digits) return '';
            return Number(digits).toLocaleString('en-US');
        }

        priceInputs.forEach((input) => {
            input.addEventListener('input', function (e) {
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
            });

            input.addEventListener('blur', function () {
                this.value = formatNumber(this.value);
            });

            input.addEventListener('focus', function () {
                if (this.value) {
                    const len = this.value.length;
                    this.setSelectionRange(len, len);
                }
            });
        });

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

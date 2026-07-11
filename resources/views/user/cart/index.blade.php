<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-right text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('سبد خرید') }}
        </h2>
    </x-slot>

    <div class="py-10" dir="rtl">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Alerts --}}
            @foreach (['success' => 'emerald', 'warning' => 'amber', 'error' => 'rose'] as $type => $color)
                @if(session($type))
                    <div class="mb-4 rounded-2xl border border-{{ $color }}-500/30 bg-{{ $color }}-500/10 px-4 py-3 text-sm text-{{ $color }}-300 shadow-sm text-right">
                        {{ session($type) }}
                    </div>
                @endif
            @endforeach

            @if($cart)
                @php
                    $actionLabels = [
                        'upgrade' => ['title' => 'ارتقای اشتراک', 'color' => 'indigo'],
                        'downgrade' => ['title' => 'تنزل اشتراک', 'color' => 'amber'],
                        'renew' => ['title' => 'تمدید اشتراک', 'color' => 'sky'],
                        'buy' => ['title' => 'خرید اشتراک جدید', 'color' => 'emerald'],
                    ];

                    $actionMeta = $actionLabels[$action] ?? $actionLabels['buy'];

                    $durationMonths = $cart->planPrice->duration_months ?? null;
                    $durationLabel = match ($durationMonths) {
                        1 => '1 ماهه',
                        3 => '3 ماهه',
                        6 => '6 ماهه',
                        12 => '1 ساله',
                        default => $durationMonths ? $durationMonths . ' ماهه' : 'نامشخص',
                    };

                    $price = $cart->planPrice->price ?? 0;
                    $discount = $cart->planPrice->discount ?? 0;
                    $finalPrice = $cart->final_price ?? $price;
                @endphp

                {{-- کارت اطلاع‌رسانی منطق محاسباتی (فقط برای ارتقا و تنزل) --}}
                @if(in_array($action, ['upgrade', 'downgrade']))
                    <div class="mb-6 rounded-2xl border border-amber-500/30 bg-amber-500/10 p-4 shadow-sm">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex-shrink-0">
                                <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-right">
                                <h4 class="text-sm font-bold text-amber-200">توجه در مورد زمان اشتراک:</h4>
                                <p class="mt-1 text-xs leading-5 text-amber-300/90">
                                    @if($action === 'upgrade')
                                        شما در حال **ارتقای اشتراک** هستید. طبق قوانین سیستم، در صورت ارتقا، **50% (نصف)** از زمان باقی‌مانده اشتراک فعلی شما به عنوان بونوس به اشتراک جدید اضافه خواهد شد.
                                    @else
                                        شما در حال **تنزل اشتراک** هستید. در این حالت، **100% (تمام)** زمان باقی‌مانده از اشتراک فعلی شما به انتهای اشتراک جدید منتقل می‌شود.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="overflow-hidden rounded-3xl border border-slate-700 bg-slate-900 shadow-2xl shadow-black/20 text-right">
                    <div class="border-b border-slate-800 px-6 py-5 bg-slate-950/40">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-slate-100">
                                    جزئیات سبد خرید
                                </h3>
                                <p class="mt-1 text-sm text-slate-400">
                                    اطلاعات کامل پلن، بازه زمانی و مبلغ نهایی قبل از پرداخت
                                </p>
                            </div>

                            <span class="inline-flex items-center rounded-full border border-{{ $actionMeta['color'] }}-500/30 bg-{{ $actionMeta['color'] }}-500/10 px-4 py-1.5 text-xs font-semibold text-{{ $actionMeta['color'] }}-300">
                                {{ $actionMeta['title'] }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        {{-- Plan info --}}
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-2xl border border-slate-700 bg-slate-950/40 p-5">
                                <div class="text-xs font-medium text-slate-500">نام پلن</div>
                                <div class="mt-2 text-lg font-bold text-slate-100">
                                    {{ $cart->plan->title ?? '—' }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-700 bg-slate-950/40 p-5">
                                <div class="text-xs font-medium text-slate-500">مدت انتخاب‌شده</div>
                                <div class="mt-2 text-lg font-bold text-slate-100">
                                    {{ $durationLabel }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-700 bg-slate-950/40 p-5">
                                <div class="text-xs font-medium text-slate-500">قیمت پایه</div>
                                <div class="mt-2 text-lg font-bold text-slate-100">
                                    {{ number_format($price) }} تومان
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-700 bg-slate-950/40 p-5">
                                <div class="text-xs font-medium text-slate-500">تخفیف</div>
                                <div class="mt-2 text-lg font-bold text-emerald-400">
                                    {{ $discount > 0 ? number_format($discount) . ' تومان' : 'بدون تخفیف' }}
                                </div>
                            </div>
                        </div>

                        {{-- Full period info --}}
                        <div class="rounded-2xl border border-slate-700 bg-slate-950/40 p-5">
                            <h4 class="text-sm font-semibold text-slate-300 mb-4">بازه زمانی خریداری‌شده</h4>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-4">
                                    <div class="text-xs text-slate-500">شروع اشتراک</div>
                                    <div class="mt-1 text-sm font-bold text-slate-100">
                                        {{ $cart->starts_at?->format('Y/m/d') ?? 'پس از پرداخت فعال می‌شود' }}
                                    </div>
                                </div>

                                <div class="rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-4">
                                    <div class="text-xs text-slate-500">پایان اشتراک</div>
                                    <div class="mt-1 text-sm font-bold text-slate-100">
                                        {{ $cart->ends_at?->format('Y/m/d') ?? 'پس از پرداخت محاسبه می‌شود' }}
                                    </div>
                                </div>

                                <div class="rounded-xl border border-slate-800 bg-slate-900/80 px-4 py-4">
                                    <div class="text-xs text-slate-500">مدت کل</div>
                                    <div class="mt-1 text-sm font-bold text-slate-100">
                                        {{ $durationLabel }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Price summary --}}
                        <div class="rounded-2xl border border-sky-500/20 bg-sky-500/5 p-5">
                            <div class="flex items-center justify-between gap-4">
                                <div>
                                    <div class="text-sm font-medium text-slate-400">مبلغ قابل پرداخت</div>
                                    <div class="mt-2 text-2xl font-extrabold text-emerald-400">
                                        {{ number_format($finalPrice) }} تومان
                                    </div>
                                </div>

                                <div class="text-left text-xs text-slate-500 leading-6">
                                    <div>پرداخت نهایی پس از تایید</div>
                                    <div>اطلاعات این سفارش قبل از ثبت قابل بررسی است</div>
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-3 sm:flex-row sm:justify-between sm:items-center">
                            <form action="{{ route('user.cart.cancel') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl border border-rose-500/30 bg-rose-500/10 px-5 py-3 text-sm font-semibold text-rose-300 transition hover:bg-rose-500/20 sm:w-auto">
                                    لغو سبد خرید
                                </button>
                            </form>

                            <form action="{{ route('user.cart.checkout') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-xl bg-emerald-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-emerald-600/20 transition hover:bg-emerald-700 sm:w-auto">
                                    تایید و پرداخت نهایی
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- سبد خالی --}}
                <div class="rounded-3xl border border-slate-700 bg-slate-900 px-6 py-14 text-center shadow-2xl shadow-black/20">
                    <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-slate-800 text-slate-400">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-slate-100">سبد خرید شما خالی است</h3>
                    <p class="mt-2 text-sm text-slate-400">
                        هنوز هیچ پلنی برای پرداخت انتخاب نشده است.
                    </p>

                    <a href="{{ route('shop') }}"
                       class="mt-6 inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        مشاهده پلن‌ها
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

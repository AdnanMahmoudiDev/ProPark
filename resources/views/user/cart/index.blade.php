<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-right text-gray-800 dark:text-gray-200">
            {{ __('سبد خرید') }}
        </h2>
    </x-slot>

    <div class="py-10" dir="rtl">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

            {{-- Alerts --}}
            @foreach (['success' => 'emerald', 'warning' => 'amber', 'error' => 'rose'] as $type => $color)
                @if(session($type))
                    <div class="mb-4 rounded-2xl border border-{{ $color }}-500/30 bg-{{ $color }}-500/10 px-4 py-3 text-right text-sm text-{{ $color }}-300 shadow-sm">
                        {{ session($type) }}
                    </div>
                @endif
            @endforeach

            @if($cart)
                @php
                    $actionLabels = [
                        'upgrade' => ['title' => 'ارتقای اشتراک', 'color' => 'blue'],
                        'downgrade' => ['title' => 'تنزل اشتراک', 'color' => 'amber'],
                        'renew' => ['title' => 'تمدید اشتراک', 'color' => 'blue'],
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

                @if(in_array($action, ['upgrade', 'downgrade']))
                    <div class="mb-6 rounded-3xl border border-amber-500/25 bg-amber-500/10 p-5 shadow-lg shadow-black/10">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-amber-500/15 text-amber-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>

                            <div class="text-right">
                                <h4 class="text-sm font-bold text-amber-200">توجه در مورد زمان اشتراک</h4>
                                <p class="mt-2 text-xs leading-6 text-amber-100/80">
                                    @if($action === 'upgrade')
                                        شما در حال ارتقای اشتراک هستید. طبق قوانین سیستم، در صورت ارتقا، 50٪ از زمان باقی‌مانده اشتراک فعلی شما به عنوان بونوس به اشتراک جدید اضافه خواهد شد.
                                    @else
                                        شما در حال تنزل اشتراک هستید. در این حالت، 100٪ از زمان باقی‌مانده اشتراک فعلی شما به انتهای اشتراک جدید منتقل می‌شود.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="overflow-hidden rounded-[28px] border border-slate-800 bg-slate-900 text-right shadow-2xl shadow-slate-950/30">
                    <div class="border-b border-slate-800 bg-gradient-to-l from-blue-600/10 via-slate-900 to-slate-900 px-6 py-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white">جزئیات سبد خرید</h3>
                                <p class="mt-1 text-sm text-slate-400">
                                    اطلاعات کامل پلن، بازه زمانی و مبلغ نهایی قبل از پرداخت
                                </p>
                            </div>

                            <span class="inline-flex items-center rounded-full border border-{{ $actionMeta['color'] }}-500/25 bg-{{ $actionMeta['color'] }}-500/10 px-4 py-2 text-xs font-semibold text-{{ $actionMeta['color'] }}-300 shadow-sm">
                                {{ $actionMeta['title'] }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-6 p-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">نام پلن</div>
                                <div class="mt-2 text-lg font-bold text-white">
                                    {{ $cart->plan->title ?? '—' }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">مدت انتخاب‌شده</div>
                                <div class="mt-2 text-lg font-bold text-white">
                                    {{ $durationLabel }}
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">قیمت پایه</div>
                                <div class="mt-2 text-lg font-bold text-white">
                                    {{ number_format($price) }} تومان
                                </div>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-emerald-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">تخفیف</div>
                                <div class="mt-2 text-lg font-bold text-emerald-400">
                                    {{ $discount > 0 ? number_format($discount) . ' تومان' : 'بدون تخفیف' }}
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-800 bg-slate-950/60 p-5">
                            <h4 class="mb-4 text-sm font-semibold text-slate-300">بازه زمانی خریداری‌شده</h4>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="rounded-2xl border border-slate-800 bg-slate-900/80 px-4 py-4">
                                    <div class="text-xs text-slate-500">شروع اشتراک</div>
                                    <div class="mt-1 text-sm font-bold text-white">
                                        {{ $cart->starts_at?->format('Y/m/d') ?? 'پس از پرداخت فعال می‌شود' }}
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-800 bg-slate-900/80 px-4 py-4">
                                    <div class="text-xs text-slate-500">پایان اشتراک</div>
                                    <div class="mt-1 text-sm font-bold text-white">
                                        {{ $cart->ends_at?->format('Y/m/d') ?? 'پس از پرداخت محاسبه می‌شود' }}
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-slate-800 bg-slate-900/80 px-4 py-4">
                                    <div class="text-xs text-slate-500">مدت کل</div>
                                    <div class="mt-1 text-sm font-bold text-white">
                                        {{ $durationLabel }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-blue-500/20 bg-gradient-to-l from-blue-500/10 to-slate-900 p-5 shadow-lg shadow-blue-900/10">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="text-sm font-medium text-slate-400">مبلغ قابل پرداخت</div>
                                    <div class="mt-2 text-3xl font-extrabold tracking-tight text-blue-400">
                                        {{ number_format($finalPrice) }} تومان
                                    </div>
                                </div>

                                <div class="text-xs leading-6 text-slate-500 sm:text-left">
                                    <div>پرداخت نهایی پس از تایید</div>
                                    <div>اطلاعات این سفارش قبل از ثبت قابل بررسی است</div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <form action="{{ route('user.cart.cancel') }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-3 text-sm font-semibold text-rose-300 transition duration-200 hover:bg-rose-500/20 sm:w-auto">
                                    لغو سبد خرید
                                </button>
                            </form>

                            <form action="{{ route('user.cart.checkout') }}" method="POST">
                                @csrf
                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:from-blue-500 hover:to-blue-400 hover:shadow-blue-500/35 sm:w-auto">
                                    تایید و پرداخت نهایی
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="relative overflow-hidden rounded-[30px] border border-slate-800 bg-slate-900 px-6 py-14 text-center shadow-2xl shadow-slate-950/30">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.16),_transparent_35%)]"></div>

                    <div class="relative">
                        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-[24px] border border-blue-500/20 bg-gradient-to-br from-blue-500/15 to-slate-800 text-blue-300 shadow-lg shadow-blue-900/20">
                            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-extrabold tracking-tight text-white">
                            سبد خرید شما خالی است
                        </h3>

                        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-400">
                            هنوز هیچ پلنی برای پرداخت انتخاب نکرده‌اید. از لیست پلن‌ها بازدید کنید و اشتراک مناسب خودتان را انتخاب کنید.
                        </p>

                        <div class="mt-8">
                            <a href="{{ route('shop') }}"
                               class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60">
                                <span>مشاهده پلن‌ها</span>
                                <svg class="h-4 w-4 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </a>
                        </div>

                        <p class="mt-4 text-xs text-slate-500">
                            انتخاب سریع، پرداخت آسان، فعال‌سازی بعد از ثبت سفارش
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

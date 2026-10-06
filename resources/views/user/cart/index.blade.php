@php
    $isRtl = app()->isLocale('fa');
    $direction = $isRtl ? 'rtl' : 'ltr';
    $align = $isRtl ? 'text-right' : 'text-left';

    /*
    |--------------------------------------------------------------------------
    | تشخیص نوع آیتم سبد خرید
    |--------------------------------------------------------------------------
    */
    $isSupportOrder = filled($cart?->support_package_id) && blank($cart?->plan_id);
    $isPlanOrder = filled($cart?->plan_id) && blank($cart?->support_package_id);

    $plan = $cart?->plan;
    $supportPackage = $cart?->supportPackage;

    /*
    |--------------------------------------------------------------------------
    | داده‌های محصول انتخاب‌شده
    |--------------------------------------------------------------------------
    */
    $itemTitle = $isSupportOrder
        ? ($supportPackage?->title ?? __('cart_support_package'))
        : ($plan?->title ?? '—');

    $basePrice = $isSupportOrder
        ? ($supportPackage?->original_price ?? $supportPackage?->price ?? 0)
        : ($plan?->original_price ?? $plan?->price ?? 0);

    $finalPrice = $isSupportOrder
        ? ($supportPackage?->price ?? 0)
        : ($plan?->price ?? 0);

    /*
    |--------------------------------------------------------------------------
    | محاسبه مبلغ تخفیف
    |--------------------------------------------------------------------------
    */
    $discountAmount = max((float) $basePrice - (float) $finalPrice, 0);

    /*
    |--------------------------------------------------------------------------
    | مدت اعتبار پشتیبانی
    |--------------------------------------------------------------------------
    */
    $supportDuration = $supportPackage?->duration_months ?? 0;

    $supportDurationText = $supportDuration . ' ' . (
        $supportDuration == 1
            ? __('cart_month')
            : __('cart_months')
    );

    /*
    |--------------------------------------------------------------------------
    | وضعیت معتبر بودن آیتم سبد
    |--------------------------------------------------------------------------
    */
    $hasValidCartItem = $cart && (
        $isPlanOrder || $isSupportOrder
    );
@endphp

<x-app-layout>
    <x-slot name="header">
        <div dir="{{ $direction }}" class="{{ $align }}">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ __('cart_title') }}
            </h2>
        </div>
    </x-slot>

    <div
        class="min-h-screen bg-gray-950 py-10"
        dir="{{ $direction }}"
    >
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            {{-- پیام‌های سیستم --}}
            @foreach (['success', 'warning', 'error'] as $type)
                @if (session($type))
                    @php
                        $messageClasses = [
                            'success' => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300',
                            'warning' => 'border-amber-500/30 bg-amber-500/10 text-amber-300',
                            'error'   => 'border-rose-500/30 bg-rose-500/10 text-rose-300',
                        ][$type];
                    @endphp

                    <div class="mb-4 rounded-2xl border px-4 py-3 text-sm shadow-sm {{ $messageClasses }} {{ $align }}">
                        <span>{{ session($type) }}</span>
                    </div>
                @endif
            @endforeach

            @if ($hasValidCartItem)
                <div class="overflow-hidden rounded-[28px] border border-slate-800 bg-slate-900 shadow-2xl shadow-slate-950/30">

                    {{-- هدر جزئیات سفارش --}}
                    <div class="border-b border-slate-800 bg-gradient-to-l from-blue-600/10 via-slate-900 to-slate-900 px-6 py-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="{{ $align }}">
                                <h3 class="text-lg font-bold text-white">
                                    {{ __('cart_order_details') }}
                                </h3>

                                <p class="mt-1 text-sm text-slate-400">
                                    {{ __('cart_order_subtitle') }}
                                </p>
                            </div>

                            {{-- نوع سفارش (بج بالا) --}}
                            @if ($isSupportOrder)
                                <span class="inline-flex items-center self-start rounded-full border border-sky-500/25 bg-sky-500/10 px-3.5 py-1.5 text-xs font-semibold text-sky-300 md:self-auto shadow-sm">
                                    {{ __('cart_support_purchase_badge') }}
                                </span>
                            @else
                                <span class="inline-flex items-center self-start rounded-full border border-emerald-500/25 bg-emerald-500/10 px-3.5 py-1.5 text-xs font-semibold text-emerald-300 md:self-auto shadow-sm">
                                    {{ __('cart_license_purchase_badge') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-6 p-6">

                        {{-- عنوان نوع سفارش --}}
                        <div class="rounded-2xl border border-blue-500/20 bg-blue-500/5 p-5 {{ $align }}">
                            <div class="text-xs font-medium text-slate-500">
                                {{ __('cart_order_type') }}
                            </div>

                            <div class="mt-1 text-lg font-bold text-blue-400">
                                @if ($isSupportOrder)
                                    {{ __('cart_support_purchase_title') }}
                                @else
                                    {{ __('cart_license_purchase_title') }}
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            {{-- اطلاعات مخصوص پلن --}}
                            @if ($isPlanOrder)
                                <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950 {{ $align }}">
                                    <div class="text-xs font-medium text-slate-500">
                                        {{ __('cart_plan_name') }}
                                    </div>

                                    <div class="mt-2 text-lg font-bold text-white">
                                        {{ $itemTitle }}
                                    </div>
                                </div>
                            @endif

                            {{-- اطلاعات مخصوص پشتیبانی --}}
                            @if ($isSupportOrder)
                                <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-sky-500/30 hover:bg-slate-950 {{ $align }}">
                                    <div class="text-xs font-medium text-slate-500">
                                        {{ __('cart_support_package_name') }}
                                    </div>

                                    <div class="mt-2 text-lg font-bold text-white">
                                        {{ $itemTitle }}
                                    </div>
                                </div>
                            @endif

                            {{-- نوع اعتبار --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950 {{ $align }}">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_validity_type') }}
                                </div>

                                <div class="mt-2 text-lg font-bold text-blue-400">
                                    @if ($isSupportOrder)
                                        {{ $supportDurationText }}
                                    @else
                                        {{ __('cart_lifetime_license') }}
                                    @endif
                                </div>
                            </div>

                            {{-- قیمت پایه --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950 {{ $align }}">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_base_price') }}
                                </div>

                                <div class="mt-2 text-lg font-bold text-white">
                                    {{ number_format($basePrice) }}
                                    {{ __('cart_currency') }}
                                </div>
                            </div>

                            {{-- میزان تخفیف --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-emerald-500/30 hover:bg-slate-950 {{ $align }}">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_discount_amount') }}
                                </div>

                                <div class="mt-2 text-lg font-bold text-emerald-400">
                                    @if ($discountAmount > 0)
                                        {{ number_format($discountAmount) }}
                                        {{ __('cart_currency') }}
                                    @else
                                        {{ __('cart_no_discount') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- مبلغ قابل پرداخت --}}
                        <div class="rounded-3xl border border-blue-500/20 bg-gradient-to-l from-blue-500/10 to-slate-900 p-5 shadow-lg shadow-blue-900/10">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="{{ $align }}">
                                    <div class="text-sm font-medium text-slate-400">
                                        {{ __('cart_payable_amount') }}
                                    </div>

                                    <div class="mt-2 text-3xl font-extrabold tracking-tight text-blue-400">
                                        {{ number_format($finalPrice) }}
                                        {{ __('cart_currency') }}
                                    </div>
                                </div>

                                <div class="text-xs leading-6 text-slate-500 {{ $align }}">
                                    @if ($isSupportOrder)
                                        <div>
                                            {{ __('cart_support_notice_activation') }}
                                        </div>
                                    @else
                                        <div>
                                            {{ __('cart_license_notice_activation') }}
                                        </div>
                                    @endif

                                    <div>
                                        {{ __('cart_notice_rights') }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- اقدامات --}}
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                            {{-- لغو سبد --}}
                            <form action="{{ route('user.cart.cancel') }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-3 text-sm font-semibold text-rose-300 transition duration-200 hover:bg-rose-500/20 sm:w-auto"
                                >
                                    {{ __('cart_cancel_button') }}
                                </button>
                            </form>

                            {{-- پرداخت نهایی --}}
                            <form action="{{ route('user.cart.checkout') }}" method="POST">
                                @csrf

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:from-blue-500 hover:to-blue-400 hover:shadow-blue-500/35 sm:w-auto"
                                >
                                    {{ __('cart_checkout_button') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- سبد خرید خالی یا نامعتبر --}}
                <div class="relative overflow-hidden rounded-[30px] border border-slate-800 bg-slate-900 px-6 py-14 text-center shadow-2xl shadow-slate-950/30">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.16),_transparent_35%)]"></div>

                    <div class="relative">
                        <h3 class="text-2xl font-extrabold tracking-tight text-white">
                            {{ __('cart_empty_title') }}
                        </h3>

                        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-400">
                            {{ __('cart_empty_desc') }}
                        </p>

                        <div class="mt-8">
                            <a
                                href="{{ route('shop') }}"
                                class="group inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40"
                            >
                                <span>{{ __('cart_view_plans_button') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

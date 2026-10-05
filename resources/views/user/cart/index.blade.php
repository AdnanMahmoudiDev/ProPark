@php
    $isRtl = app()->isLocale('fa');
    $align = $isRtl ? 'text-right' : 'text-left';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 {{ $align }}">
            {{ __('cart_title') }}
        </h2>
    </x-slot>

    <div class="py-10" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
        <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

            {{-- پیام‌های سیستم --}}
            @foreach (['success', 'warning', 'error'] as $type)
                @if(session($type))
                    @php
                        $classes = [
                            'success' => 'border-emerald-500/30 bg-emerald-500/10 text-emerald-300',
                            'warning' => 'border-amber-500/30 bg-amber-500/10 text-amber-300',
                            'error'   => 'border-rose-500/30 bg-rose-500/10 text-rose-300',
                        ][$type];
                    @endphp
                    <div class="mb-4 rounded-2xl border px-4 py-3 text-sm shadow-sm {{ $classes }} {{ $align }}">
                        {{ session($type) }}
                    </div>
                @endif
            @endforeach

            @if($cart)
                <div class="overflow-hidden rounded-[28px] border border-slate-800 bg-slate-900 {{ $align }} shadow-2xl shadow-slate-950/30">
                    <div class="border-b border-slate-800 bg-gradient-to-l from-blue-600/10 via-slate-900 to-slate-900 px-6 py-6">
                        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white">
                                    {{ __('cart_order_details') }}
                                </h3>
                                <p class="mt-1 text-sm text-slate-400">
                                    {{ __('cart_order_subtitle') }}
                                </p>
                            </div>
                            <span class="inline-flex items-center rounded-full border px-4 py-2 text-xs font-semibold shadow-sm border-emerald-500/25 bg-emerald-500/10 text-emerald-300">
                                {{ __('cart_license_purchase_badge') }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-6 p-6">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            {{-- نام پلن --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_plan_name') }}
                                </div>
                                <div class="mt-2 text-lg font-bold text-white">
                                    {{ $cart->plan->title ?? '—' }}
                                </div>
                            </div>

                            {{-- نوع لایسنس --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_validity_type') }}
                                </div>
                                <div class="mt-2 text-lg font-bold text-blue-400">
                                    {{ __('cart_lifetime_license') }}
                                </div>
                            </div>

                            {{-- قیمت پایه --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-blue-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_base_price') }}
                                </div>
                                <div class="mt-2 text-lg font-bold text-white">
                                    {{ number_format($cart->plan->price ?? 0) }} {{ __('cart_currency') }}
                                </div>
                            </div>

                            {{-- تخفیف --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950/70 p-5 transition hover:border-emerald-500/30 hover:bg-slate-950">
                                <div class="text-xs font-medium text-slate-500">
                                    {{ __('cart_discount_amount') }}
                                </div>
                                <div class="mt-2 text-lg font-bold text-emerald-400">
                                    @if(($cart->plan->discount ?? 0) > 0)
                                        {{ number_format($cart->plan->discount) }} {{ __('cart_currency') }}
                                    @else
                                        {{ __('cart_no_discount') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- مبلغ قابل پرداخت --}}
                        <div class="rounded-3xl border border-blue-500/20 bg-gradient-to-l from-blue-500/10 to-slate-900 p-5 shadow-lg shadow-blue-900/10">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="text-sm font-medium text-slate-400">
                                        {{ __('cart_payable_amount') }}
                                    </div>
                                    <div class="mt-2 text-3xl font-extrabold tracking-tight text-blue-400">
                                        {{ number_format($cart->final_price ?? 0) }} {{ __('cart_currency') }}
                                    </div>
                                </div>
                                <div class="text-xs leading-6 text-slate-500 {{ $align }}">
                                    <div>{{ __('cart_notice_activation') }}</div>
                                    <div>{{ __('cart_notice_rights') }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- اقدامات --}}
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <form action="{{ route('user.cart.cancel') }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-3 text-sm font-semibold text-rose-300 transition duration-200 hover:bg-rose-500/20 sm:w-auto">
                                    {{ __('cart_cancel_button') }}
                                </button>
                            </form>

                            <form action="{{ route('user.cart.checkout') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:from-blue-500 hover:to-blue-400 hover:shadow-blue-500/35 sm:w-auto">
                                    {{ __('cart_checkout_button') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                {{-- سبد خرید خالی --}}
                <div class="relative overflow-hidden rounded-[30px] border border-slate-800 bg-slate-900 px-6 py-14 text-center shadow-2xl shadow-slate-950/30">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.16),_transparent_35%)]"></div>
                    <div class="relative">
                        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-[24px] border border-blue-500/20 bg-gradient-to-br from-blue-500/15 to-slate-800 text-blue-300 shadow-lg shadow-blue-900/20">
                            <svg class="h-9 w-9" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-extrabold tracking-tight text-white">
                            {{ __('cart_empty_title') }}
                        </h3>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-7 text-slate-400">
                            {{ __('cart_empty_desc') }}
                        </p>
                        <div class="mt-8">
                            <a href="{{ route('shop') }}" class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-8 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40">
                                <span>{{ __('cart_view_plans_button') }}</span>
                                <svg class="h-4 w-4 transition duration-300 {{ $isRtl ? 'group-hover:-translate-x-1 rotate-180' : 'group-hover:translate-x-1' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

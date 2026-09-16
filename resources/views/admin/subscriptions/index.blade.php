@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- ================= هدر صفحه ================= --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white leading-tight">
                مدیریت اشتراک‌ها
            </h2>
            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span>
                    نظارت، تمدید، تغییر وضعیت و مدیریت لایسنس‌های مشترکین AvaPark
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <div class="px-4 py-2 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 text-xs font-medium">
                تعداد کل اشتراک‌ها: {{ $subscriptions->total() }}
            </div>
        </div>
    </div>

    {{-- ================= پیام موفقیت ================= --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-green-700 bg-green-900/20 text-green-400 text-sm animate-[fadeIn_0.3s_ease]">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- ================= پیام خطا ================= --}}
    @if(session('error'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm animate-[fadeIn_0.3s_ease]">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- ================= خطاهای اعتبارسنجی ================= --}}
    @if($errors->any())
        <div class="p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm space-y-2 animate-[fadeIn_0.3s_ease]">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>خطای ورودی رخ داده است:</span>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pr-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ================= توابع کمکی وضعیت ================= --}}
    @php
        $getStatusBadge = function ($status) {
            $status = strtolower($status ?? '');

            return match ($status) {
                'active'    => 'bg-green-900/20 border border-green-700 text-green-400',
                'expired'   => 'bg-red-900/20 border border-red-700 text-red-400',
                'cancelled' => 'bg-gray-800/80 border border-gray-700 text-gray-400',
                'suspended' => 'bg-amber-900/20 border border-amber-700 text-amber-400',
                default     => 'bg-gray-900/20 border border-gray-800 text-gray-400',
            };
        };

        $getStatusLabel = function ($status) {
            $status = strtolower($status ?? '');

            return match ($status) {
                'active'    => 'فعال',
                'expired'   => 'منقضی',
                'cancelled' => 'لغو شده',
                'suspended' => 'معلق',
                default     => $status ?: '—',
            };
        };
    @endphp

    {{-- ================= کارت اصلی ================= --}}
    <div class="bg-gray-900/70 border border-gray-800 rounded-3xl overflow-hidden">

        {{-- هدر جدول --}}
        <div class="px-5 py-4 md:px-6 md:py-5 border-b border-gray-800 bg-gradient-to-r from-blue-900/20 to-transparent">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base md:text-lg font-semibold text-white">
                        لیست اشتراک‌ها
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">
                        برای اعمال تغییرات در هر اشتراک، روی دکمه مدیریت (⚙) کلیک کنید
                    </p>
                </div>

                <div class="text-xs text-gray-500">
                    مجموع نتایج این صفحه: {{ $subscriptions->count() }}
                </div>
            </div>
        </div>

        @if($subscriptions->count() > 0)

            {{-- ================= مخصوص موبایل (کارت‌های مجزا) ================= --}}
            <div class="md:hidden p-4 space-y-4">
                @foreach($subscriptions as $subscription)
                    @php
                        $statusValue = $subscription->effective_status ?? $subscription->status ?? '—';
                        $statusBadge = $getStatusBadge($statusValue);
                        $statusLabel = $getStatusLabel($statusValue);
                    @endphp

                    <div class="rounded-2xl border border-gray-800 bg-black/20 p-4 space-y-4">

                        {{-- هدر کارت --}}
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-white">
                                    {{ $subscription->user->name ?? '—' }}
                                </div>
                                <div class="mt-1 text-xs text-gray-400 font-mono">
                                    ایمیل: {{ $subscription->user->email ?? '—' }}
                                </div>
                            </div>

                            <div class="shrink-0">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium {{ $statusBadge }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        {{-- جزئیات پلن و لایسنس --}}
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">پلن فعلی</div>
                                <div class="text-gray-200 font-medium break-words">
                                    {{ $subscription->plan->title ?? $subscription->plan->name ?? '—' }}
                                </div>
                                @if($subscription->planPrice)
                                    <div class="text-[10px] text-gray-500 mt-0.5">
                                        {{ $subscription->planPrice->duration_months ? $subscription->planPrice->duration_months . ' ماهه' : '—' }}
                                    </div>
                                @endif
                            </div>

                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">لایسنس</div>
                                <div class="text-blue-400 font-mono break-all text-xs">
                                    {{ $subscription->license->license_key ?? '—' }}
                                </div>
                            </div>
                        </div>

                        {{-- تاریخ‌ها --}}
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">شروع</div>
                                <div class="text-gray-300 font-mono text-xs">
                                    {{ $subscription->started_at_jalali ?? $subscription->starts_at_jalali ?? '—' }}
                                </div>
                            </div>

                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">انقضا</div>
                                <div class="text-gray-300 font-mono text-xs">
                                    {{ $subscription->expires_at_jalali ?? $subscription->ends_at_jalali ?? '—' }}
                                </div>
                            </div>
                        </div>

                        {{-- دکمه مدیریت (در موبایل) --}}
                        <button
                            type="button"
                            onclick="toggleActionsMobile({{ $subscription->id }})"
                            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 hover:bg-blue-600 hover:text-white text-sm font-medium transition duration-200"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            عملیات مدیریت
                        </button>

                        {{-- عملیات مخفی موبایل با ۴ بخش تفکیک‌شده --}}
                        <div id="mobile-actions-{{ $subscription->id }}" class="hidden space-y-4 pt-4 border-t border-gray-800 animate-[fadeIn_0.3s_ease]">

                            {{-- ۱. تغییر پلن --}}
                            <div class="p-4 rounded-2xl border border-gray-800 bg-gray-950/60 space-y-3">
                                <div class="flex items-center gap-2 text-xs font-bold text-blue-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                    </svg>
                                    تغییر پلن اشتراک
                                </div>
                                <form method="POST" action="{{ route('admin.subscriptions.update-plan', $subscription) }}" class="space-y-3">
                                    @csrf @method('PATCH')
                                    <select
                                        name="plan_price_id"
                                        class="w-full h-11 rounded-xl border border-gray-800 bg-black/60 text-gray-200 text-sm px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                    >
                                        @foreach($plans as $plan)
                                            <optgroup label="{{ $plan->title ?? $plan->name ?? 'پلن' }}" class="bg-gray-950 text-blue-400 font-bold">
                                                @foreach($plan->prices as $price)
                                                    <option
                                                        value="{{ $price->id }}"
                                                        class="bg-gray-900 text-gray-200 py-1"
                                                        @selected($subscription->plan_price_id == $price->id)
                                                    >
                                                        {{ ($plan->title ?? $plan->name ?? 'پلن') }} - {{ $price->duration_months ? $price->duration_months . ' ماهه' : 'بازه نامشخص' }} - {{ isset($price->price) ? number_format($price->price) . ' تومان' : 'قیمت نامشخص' }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="w-full h-11 rounded-xl bg-blue-600 text-white hover:bg-blue-500 text-sm font-medium transition">
                                        ثبت پلن جدید
                                    </button>
                                </form>
                            </div>

                            {{-- ۲. تغییر وضعیت --}}
                            <div class="p-4 rounded-2xl border border-gray-800 bg-gray-950/60 space-y-3">
                                <div class="flex items-center gap-2 text-xs font-bold text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    تغییر وضعیت اشتراک
                                </div>
                                <form method="POST" action="{{ route('admin.subscriptions.update-status', $subscription) }}" class="space-y-3">
                                    @csrf @method('PATCH')
                                    <select
                                        name="status"
                                        class="w-full h-11 rounded-xl border border-gray-800 bg-black/60 text-gray-200 text-sm px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                    >
                                        <option value="active" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'active')>فعال</option>
                                        <option value="expired" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'expired')>منقضی</option>
                                        <option value="cancelled" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'cancelled')>لغو شده</option>
                                        <option value="suspended" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'suspended')>معلق</option>
                                    </select>
                                    <button type="submit" class="w-full h-11 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 hover:bg-blue-600 hover:text-white text-sm font-medium transition">
                                        ثبت وضعیت
                                    </button>
                                </form>
                            </div>

                            {{-- ۳. تمدید اشتراک --}}
                            <div class="p-4 rounded-2xl border border-gray-800 bg-gray-950/60 space-y-3">
                                <div class="flex items-center gap-2 text-xs font-bold text-emerald-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    تمدید اشتراک
                                </div>
                                <form method="POST" action="{{ route('admin.subscriptions.renew', $subscription) }}" class="space-y-3">
                                    @csrf
                                    <input
                                        type="number"
                                        name="months"
                                        min="1"
                                        max="120"
                                        placeholder="تعداد ماه"
                                        required
                                        class="w-full h-11 rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm px-3 focus:border-emerald-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                    >
                                    <button type="submit" class="w-full h-11 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 text-sm font-medium transition">
                                        تمدید اشتراک
                                    </button>
                                </form>
                            </div>

                            {{-- ۴. حذف کامل اشتراک --}}
                            <div class="p-4 rounded-2xl border border-rose-900/40 bg-rose-950/10 space-y-3">
                                <div class="flex items-center gap-2 text-xs font-bold text-rose-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    حذف کامل اشتراک
                                </div>
                                <form
                                    method="POST"
                                    action="{{ route('admin.subscriptions.destroy', $subscription) }}"
                                    onsubmit="return confirm('آیا از حذف مطمئن هستید؟ با این کار تمامی اطلاعات اشتراک، لایسنس و دستگاه‌های متصل به صورت دائم پاک خواهند شد.')"
                                >
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full h-11 rounded-xl border border-rose-900/40 bg-rose-950/20 text-rose-400 hover:bg-rose-900 hover:text-white text-sm font-medium transition">
                                        حذف اشتراک
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ================= مخصوص دسکتاپ (جدول + ۴ کارت مجزا در Accordion) ================= --}}
            <div class="hidden md:block">
                <table class="w-full text-right border-separate border-spacing-0">
                    <thead class="bg-gray-950/60">
                        <tr>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">اشتراک</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">کاربر</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">پلن فعلی</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">وضعیت</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">شروع</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">انقضا</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800">لایسنس</th>
                            <th class="py-4 px-3 text-xs font-semibold text-gray-400 border-b border-gray-800 text-center">مدیریت</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($subscriptions as $subscription)
                            @php
                                $statusValue = $subscription->effective_status ?? $subscription->status ?? '—';
                                $statusBadge = $getStatusBadge($statusValue);
                                $statusLabel = $getStatusLabel($statusValue);
                            @endphp

                            {{-- ردیف اصلی اطلاعات --}}
                            <tr class="hover:bg-blue-900/10 transition-colors">
                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <span class="text-sm font-mono text-blue-500 font-medium">#{{ $subscription->id }}</span>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-white">
                                            {{ $subscription->user->name ?? '—' }}
                                        </span>
                                        <span class="text-[11px] text-gray-500 font-mono">
                                            {{ $subscription->user->email ?? '—' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <div class="text-sm text-gray-200 font-medium">
                                        {{ $subscription->plan->title ?? $subscription->plan->name ?? '—' }}
                                    </div>
                                    <div class="text-[11px] text-gray-500 mt-0.5">
                                        {{ $subscription->planPrice->duration_months ? $subscription->planPrice->duration_months . ' ماهه' : '—' }}
                                    </div>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-[11px] font-medium {{ $statusBadge }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <span class="text-xs text-gray-300 font-mono whitespace-nowrap">
                                        {{ $subscription->started_at_jalali ?? $subscription->starts_at_jalali ?? '—' }}
                                    </span>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <span class="text-xs text-gray-300 font-mono whitespace-nowrap">
                                        {{ $subscription->expires_at_jalali ?? $subscription->ends_at_jalali ?? '—' }}
                                    </span>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50">
                                    <code class="text-[11px] bg-black/40 px-2 py-1 rounded border border-gray-700 text-blue-400 font-mono">
                                        {{ $subscription->license->license_key ?? '—' }}
                                    </code>
                                </td>

                                <td class="py-4 px-3 border-b border-gray-800/50 text-center">
                                    <button
                                        type="button"
                                        onclick="toggleActions({{ $subscription->id }})"
                                        class="p-2 hover:bg-blue-600/20 rounded-lg text-blue-400 transition-all cursor-pointer"
                                        title="مدیریت اشتراک"
                                    >
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>

                            {{-- ردیف مخفی عملیات (Accordion) با ۴ کارت مجزا --}}
                            <tr id="actions-{{ $subscription->id }}" class="hidden bg-blue-950/10">
                                <td colspan="8" class="p-6 border-b border-gray-800 bg-gray-950/40">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 animate-[fadeIn_0.3s_ease] items-stretch">

                                        {{-- ===== کارت ۱: تغییر پلن ===== --}}
                                        <div class="flex flex-col h-full rounded-2xl border border-gray-800 bg-gray-900/70 p-5">
                                            <div class="flex items-center gap-2 h-10 pb-3 border-b border-gray-800">
                                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                                </svg>
                                                <span class="text-xs font-bold text-blue-400">تغییر پلن اشتراک</span>
                                            </div>

                                            <form method="POST" action="{{ route('admin.subscriptions.update-plan', $subscription) }}" class="flex flex-col flex-1 justify-between gap-4 pt-4">
                                                @csrf @method('PATCH')

                                                <div>
                                                    <label class="block text-[11px] text-gray-400 mb-2">انتخاب پلن و دوره</label>
                                                    <select
                                                        name="plan_price_id"
                                                        class="w-full h-11 rounded-xl border border-gray-800 bg-black/60 text-gray-200 text-sm px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                                    >
                                                        @foreach($plans as $plan)
                                                            <optgroup label="{{ $plan->title ?? $plan->name ?? 'پلن' }}" class="bg-gray-950 text-blue-400 font-bold">
                                                                @foreach($plan->prices as $price)
                                                                    <option
                                                                        value="{{ $price->id }}"
                                                                        class="bg-gray-900 text-gray-200 py-1"
                                                                        @selected($subscription->plan_price_id == $price->id)
                                                                    >
                                                                        {{ ($plan->title ?? $plan->name ?? 'پلن') }} - {{ $price->duration_months ? $price->duration_months . ' ماهه' : 'بازه نامشخص' }} - {{ isset($price->price) ? number_format($price->price) . ' تومان' : 'قیمت نامشخص' }}
                                                                    </option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <button type="submit" class="mt-auto w-full h-11 rounded-xl bg-blue-600 text-white hover:bg-blue-500 text-sm font-medium transition duration-200 flex items-center justify-center gap-2">
                                                    ثبت پلن جدید
                                                </button>
                                            </form>
                                        </div>

                                        {{-- ===== کارت ۲: تغییر وضعیت ===== --}}
                                        <div class="flex flex-col h-full rounded-2xl border border-gray-800 bg-gray-900/70 p-5">
                                            <div class="flex items-center gap-2 h-10 pb-3 border-b border-gray-800">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-xs font-bold text-gray-400">تغییر وضعیت</span>
                                            </div>

                                            <form method="POST" action="{{ route('admin.subscriptions.update-status', $subscription) }}" class="flex flex-col flex-1 justify-between gap-4 pt-4">
                                                @csrf @method('PATCH')

                                                <div>
                                                    <label class="block text-[11px] text-gray-400 mb-2">انتخاب وضعیت جدید</label>
                                                    <select
                                                        name="status"
                                                        class="w-full h-11 rounded-xl border border-gray-800 bg-black/60 text-gray-200 text-sm px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                                    >
                                                        <option value="active" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'active')>فعال</option>
                                                        <option value="expired" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'expired')>منقضی</option>
                                                        <option value="cancelled" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'cancelled')>لغو شده</option>
                                                        <option value="suspended" class="bg-gray-950 text-gray-200" @selected(($subscription->status ?? null) === 'suspended')>معلق</option>
                                                    </select>
                                                </div>

                                                <button type="submit" class="mt-auto w-full h-11 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 hover:bg-blue-600 hover:text-white text-sm font-medium transition duration-200">
                                                    ثبت وضعیت
                                                </button>
                                            </form>
                                        </div>

                                        {{-- ===== کارت ۳: تمدید اشتراک ===== --}}
                                        <div class="flex flex-col h-full rounded-2xl border border-gray-800 bg-gray-900/70 p-5">
                                            <div class="flex items-center gap-2 h-10 pb-3 border-b border-gray-800">
                                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <span class="text-xs font-bold text-emerald-400">تمدید اشتراک</span>
                                            </div>

                                            <form method="POST" action="{{ route('admin.subscriptions.renew', $subscription) }}" class="flex flex-col flex-1 justify-between gap-4 pt-4">
                                                @csrf

                                                <div>
                                                    <label class="block text-[11px] text-gray-400 mb-2">تعداد ماه تمدید</label>
                                                    <input
                                                        type="number"
                                                        name="months"
                                                        min="1"
                                                        max="120"
                                                        placeholder="مثال: 3"
                                                        required
                                                        class="w-full h-11 rounded-xl border border-gray-800 bg-black/60 text-gray-300 text-sm px-3 focus:border-emerald-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                                    >
                                                </div>

                                                <button type="submit" class="mt-auto w-full h-11 rounded-xl bg-emerald-600 text-white hover:bg-emerald-500 text-sm font-medium transition duration-200 flex items-center justify-center gap-2">
                                                    تمدید اشتراک
                                                </button>
                                            </form>
                                        </div>

                                        {{-- ===== کارت ۴: حذف کامل اشتراک (منطقه خطر) ===== --}}
                                        <div class="flex flex-col h-full rounded-2xl border border-rose-950/60 bg-rose-950/10 p-5">
                                            <div class="flex items-center gap-2 h-10 pb-3 border-b border-rose-900/40">
                                                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="text-xs font-bold text-rose-400">حذف دائم</span>
                                            </div>

                                            <div class="flex flex-col flex-1 justify-between gap-4 pt-4">
                                                <div>
                                                    <p class="text-[11px] text-gray-400 leading-relaxed">
                                                        حذف لایسنس، سوابق اشتراک و دستگاه‌های متصل کاربر به صورت برگشت‌ناپذیر.
                                                    </p>
                                                </div>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.subscriptions.destroy', $subscription) }}"
                                                    onsubmit="return confirm('آیا از حذف مطمئن هستید؟ با این کار تمامی اطلاعات اشتراک، لایسنس و دستگاه‌های متصل به صورت دائم پاک خواهند شد.')"
                                                    class="mt-auto"
                                                >
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-full h-11 rounded-xl border border-rose-900/50 bg-rose-950/40 text-rose-400 hover:bg-rose-900 hover:text-white text-sm font-medium transition duration-200 flex items-center justify-center gap-2">
                                                        حذف کامل اشتراک
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ================= صفحه‌بندی ================= --}}
            @if ($subscriptions->hasPages())
                <div class="px-5 py-4 md:px-6 border-t border-gray-800 bg-gray-950/20">
                    {{ $subscriptions->links() }}
                </div>
            @endif

        @else

            {{-- ================= حالت خالی (Empty State) ================= --}}
            <div class="px-6 py-16 text-center animate-[fadeIn_0.3s_ease]">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-800/70 border border-gray-700 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 17v-2a4 4 0 014-4h6m-6 8h6m-6-8V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h6"/>
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-white mb-2">
                    هیچ اشتراکی یافت نشد
                </h3>

                <p class="text-sm text-gray-500">
                    در حال حاضر هیچ اشتراکی برای نمایش در این بخش وجود ندارد.
                </p>
            </div>

        @endif
    </div>
</div>

{{-- ================= اسکریپت‌های مدیریت Accordion ================= --}}
<script>
    function toggleActions(id) {
        const el = document.getElementById('actions-' + id);
        if (!el) return;

        const isOpen = !el.classList.contains('hidden');

        document.querySelectorAll('[id^="actions-"]').forEach(item => {
            item.classList.add('hidden');
        });

        if (!isOpen) {
            el.classList.remove('hidden');
            el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function toggleActionsMobile(id) {
        const el = document.getElementById('mobile-actions-' + id);
        if (!el) return;

        const isOpen = !el.classList.contains('hidden');

        document.querySelectorAll('[id^="mobile-actions-"]').forEach(item => {
            item.classList.add('hidden');
        });

        if (!isOpen) {
            el.classList.remove('hidden');
        }
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="actions-"]').forEach(item => {
                item.classList.add('hidden');
            });
            document.querySelectorAll('[id^="mobile-actions-"]').forEach(item => {
                item.classList.add('hidden');
            });
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

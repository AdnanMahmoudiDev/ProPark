@extends('admin.layout.app')

@section('content')
<div class="space-y-8">

    {{-- ================= هدر صفحه (با هاله نوری بنفش و نیلی نئونی) ================= --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        {{-- افکت هاله نوری درخشان ترکیبی بنفش، نیلی و آبی --}}
        <div class="pointer-events-none absolute -top-12 left-1/2 -translate-x-1/2 h-32 w-96 rounded-full bg-gradient-to-r from-blue-600/15 via-indigo-600/25 to-purple-600/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -top-10 -right-10 h-40 w-40 rounded-full bg-purple-600/15 blur-2xl"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                    <span>مدیریت اشتراک‌ها</span>
                </h2>
                <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 font-normal">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-sm shadow-blue-500"></span>
                    <span>
                        نظارت، تمدید، تغییر وضعیت و مدیریت لایسنس‌های مشترکین AvaPark
                    </span>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-3">
                {{-- دکمه شیک، مدرن و برجسته هدایت به مدیریت پشتیبانی‌ها --}}
                <a
                    href="{{ route('admin.supports.index') }}"
                    class="group relative inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/30 ring-1 ring-white/20 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60 active:translate-y-0"
                    title="مدیریت پشتیبانی‌های کاربران"
                >
                    {{-- آیکون پشتیبانی --}}
                    <div class="flex h-6 w-6 items-center justify-center rounded-xl bg-white/15 border border-white/20 shadow-inner">
                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 19a3 3 0 01-3 3h-3"></path>
                        </svg>
                    </div>

                    <span>مدیریت پشتیبانی‌ها</span>

                    {{-- فلش حرکتی --}}
                    <svg class="h-4 w-4 rtl:rotate-180 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                {{-- بج تعداد اشتراک‌ها (استایل مشابه فروشگاه) --}}
                <div class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-2xl border border-gray-800/80 bg-gray-900/80 text-gray-300 text-xs font-semibold shadow-inner">
                    <span class="text-gray-400">تعداد کل اشتراک‌ها:</span>
                    <span class="font-bold text-blue-400 font-mono text-sm">{{ $subscriptions->total() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= پیام موفقیت ================= --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-green-700 bg-green-900/20 text-green-400 text-sm animate-[fadeIn_0.3s_ease]">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ================= پیام خطا ================= --}}
    @if(session('error'))
        <div class="flex items-center gap-3 p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm animate-[fadeIn_0.3s_ease]">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ================= پیام‌های اعتبارسنجی ================= --}}
    @if($errors->any())
        <div class="p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm animate-[fadeIn_0.3s_ease] space-y-1">
            <div class="flex items-center gap-2 font-medium mb-1">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>خطاهای اعتبارسنجی:</span>
            </div>
            <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-300 pr-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- توابع کمکی وضعیت در Blade --}}
    @php
        $getStatusBadge = function($status) {
            return match($status) {
                'active' => 'border-green-700 bg-green-900/20 text-green-400',
                'expired' => 'border-rose-700 bg-rose-900/20 text-rose-400',
                'cancelled' => 'border-gray-700 bg-gray-800/40 text-gray-400',
                'suspended' => 'border-amber-700 bg-amber-900/20 text-amber-400',
                default => 'border-gray-700 bg-gray-800 text-gray-400',
            };
        };

        $getStatusLabel = function($status) {
            return match($status) {
                'active' => 'فعال',
                'expired' => 'منقضی',
                'cancelled' => 'لغو شده',
                'suspended' => 'معلق',
                default => $status ?: '—',
            };
        };
    @endphp

    {{-- ================= کارت اصلی لیست اشتراک‌ها ================= --}}
    <div class="bg-gray-900/70 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">

        {{-- هدر کارت با سرچ و تعداد --}}
        <div class="px-5 py-4 md:px-6 md:py-5 border-b border-gray-800 bg-gradient-to-r from-blue-900/20 to-transparent">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h3 class="text-base md:text-lg font-semibold text-white">
                        لیست اشتراک‌ها
                    </h3>
                    <p class="text-xs md:text-sm text-gray-400 mt-0.5">
                        برای تغییر پلن، تغییر وضعیت، تمدید یا حذف دائم روی دکمه مدیریت (⚙) هر سطر کلیک کنید
                    </p>
                </div>

                {{-- فیلتر جستجو --}}
                <div class="flex items-center gap-3 flex-wrap">
                    <form method="GET" action="{{ route('admin.subscriptions.index') }}" class="flex items-center gap-2">
                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="جستجو نام، ایمیل، شماره تماس..."
                                class="w-56 sm:w-72 rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-xs py-2 px-3 pr-8 focus:border-blue-700 focus:ring-1 focus:ring-blue-700 focus:outline-none transition placeholder-gray-500"
                            >
                            <svg class="w-4 h-4 text-gray-500 absolute right-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <button
                            type="submit"
                            class="px-3.5 py-2 rounded-xl border border-blue-800 bg-blue-900/30 text-blue-300 hover:bg-blue-600 hover:text-white text-xs font-medium transition"
                        >
                            جستجو
                        </button>
                        @if(request('search'))
                            <a
                                href="{{ route('admin.subscriptions.index') }}"
                                class="px-3 py-2 rounded-xl border border-rose-800 bg-rose-900/20 text-rose-300 hover:bg-rose-800 hover:text-white text-xs font-medium transition"
                                title="پاک کردن فیلتر"
                            >
                                حذف فیلتر
                            </a>
                        @endif
                    </form>

                    <div class="text-xs text-gray-500 border-r border-gray-800 pr-3 mr-1 hidden sm:block">
                        نتایج این صفحه: <span class="font-mono text-gray-300">{{ $subscriptions->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if($subscriptions->count() > 0)

            {{-- ================= مخصوص موبایل (کارت‌ها) ================= --}}
            <div class="md:hidden p-4 space-y-4">
                @foreach ($subscriptions as $subscription)
                    @php
                        $subStatus = $subscription->effective_status ?? $subscription->status ?? '—';
                        $subBadge = $getStatusBadge($subStatus);
                        $subLabel = $getStatusLabel($subStatus);

                        $latestSupport = $subscription->latestSupport ?? null;
                        $supportStatus = $latestSupport->status ?? $subscription->support_status ?? '—';
                        $supportBadge = $getStatusBadge($supportStatus);
                        $supportLabel = $getStatusLabel($supportStatus);
                        $supportExpireJalali = $latestSupport?->expires_at_jalali ?? $subscription->support_expires_at_jalali ?? '—';
                    @endphp

                    <div class="rounded-2xl border border-gray-800 bg-black/20 p-4 space-y-3.5">
                        {{-- کاربر و شناسه --}}
                        <div class="flex items-start justify-between gap-3 border-b border-gray-800/80 pb-3">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-white truncate">
                                    {{ $subscription->user->name ?? '—' }}
                                </div>
                                <div class="mt-0.5 text-xs text-gray-400 font-mono">
                                    اشتراک: #{{ $subscription->id }}
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5 shrink-0">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-medium border {{ $subBadge }}">
                                    {{ $subLabel }}
                                </span>
                            </div>
                        </div>

                        {{-- اطلاعات تفصیلی --}}
                        <div class="grid grid-cols-2 gap-2.5 text-xs">
                            <div class="space-y-0.5">
                                <div class="text-[11px] text-gray-500">پلن</div>
                                <div class="text-white font-medium">
                                    {{ $subscription->plan->title ?? $subscription->plan->name ?? '—' }}
                                </div>
                            </div>

                            <div class="space-y-0.5">
                                <div class="text-[11px] text-gray-500">پشتیبانی</div>
                                <div>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-medium border {{ $supportBadge }}">
                                        {{ $supportLabel }}
                                    </span>
                                </div>
                            </div>

                            <div class="space-y-0.5">
                                <div class="text-[11px] text-gray-500">تاریخ شروع</div>
                                <div class="text-gray-300 font-mono text-[11px]">
                                    {{ $subscription->started_at_jalali ?? $subscription->starts_at_jalali ?? '—' }}
                                </div>
                            </div>

                            <div class="space-y-0.5">
                                <div class="text-[11px] text-gray-500">انقضای پشتیبانی</div>
                                <div class="text-gray-300 font-mono text-[11px]">
                                    {{ $supportExpireJalali }}
                                </div>
                            </div>
                        </div>

                        {{-- ایمیل و لایسنس --}}
                        <div class="space-y-1.5 pt-2 border-t border-gray-800/60 text-xs">
                            <div class="flex items-center justify-between text-gray-400">
                                <span class="text-[11px] text-gray-500">ایمیل:</span>
                                <span class="font-mono text-gray-300 truncate max-w-[200px]">{{ $subscription->user->email ?? '—' }}</span>
                            </div>

                            @if($subscription->license)
                                <div class="flex items-center justify-between text-gray-400">
                                    <span class="text-[11px] text-gray-500">لایسنس:</span>
                                    <code class="font-mono text-[11px] text-blue-400 bg-blue-950/40 px-2 py-0.5 rounded border border-blue-900/50">
                                        {{ $subscription->license->license_key }}
                                    </code>
                                </div>
                            @endif
                        </div>

                        {{-- دکمه آکاردئون مدیریت عملیات در موبایل --}}
                        <div class="pt-2 border-t border-gray-800">
                            <button
                                type="button"
                                onclick="toggleActionsMobile({{ $subscription->id }})"
                                class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl border border-gray-700 bg-gray-800/60 hover:bg-gray-800 text-gray-200 text-xs font-semibold transition"
                            >
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>مدیریت و عملیات این اشتراک</span>
                            </button>

                            {{-- پنل فرم‌های عملیاتی موبایل --}}
                            <div id="mobile-actions-{{ $subscription->id }}" class="hidden mt-3 space-y-3.5 pt-3 border-t border-dashed border-gray-800">

                                {{-- فرم تغییر پلن --}}
                                <div class="bg-gray-950/60 p-3 rounded-xl border border-gray-800/80 space-y-2">
                                    <div class="text-[11px] font-semibold text-blue-400 flex items-center gap-1.5">
                                        <span>تغییر پلن</span>
                                    </div>
                                    <form method="POST" action="{{ route('admin.subscriptions.update-plan', $subscription) }}" class="space-y-2">
                                        @csrf
                                        @method('PATCH')
                                        <select
                                            name="plan_id"
                                            class="w-full rounded-xl border border-gray-800 bg-black/50 text-gray-300 text-xs py-2 px-2.5 focus:border-blue-700 focus:outline-none"
                                        >
                                            @foreach($plans as $plan)
                                                <option value="{{ $plan->id }}" class="bg-gray-900 text-gray-300" @selected($subscription->plan_id == $plan->id)>
                                                    {{ $plan->title ?? $plan->name }} ({{ number_format($plan->price) }} ت)
                                                </option>
                                            @endforeach
                                        </select>
                                        <button
                                            type="submit"
                                            class="w-full py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-medium transition"
                                        >
                                            ثبت پلن جدید
                                        </button>
                                    </form>
                                </div>

                                {{-- فرم تغییر وضعیت --}}
                                <div class="bg-gray-950/60 p-3 rounded-xl border border-gray-800/80 space-y-2">
                                    <div class="text-[11px] font-semibold text-blue-400">تغییر وضعیت اشتراک</div>
                                    <form method="POST" action="{{ route('admin.subscriptions.update-status', $subscription) }}" class="space-y-2">
                                        @csrf
                                        @method('PATCH')
                                        <select
                                            name="status"
                                            class="w-full rounded-xl border border-gray-800 bg-black/50 text-gray-300 text-xs py-2 px-2.5 focus:border-blue-700 focus:outline-none"
                                        >
                                            <option value="active" class="bg-gray-900 text-gray-300" @selected($subStatus === 'active')>فعال (active)</option>
                                            <option value="expired" class="bg-gray-900 text-gray-300" @selected($subStatus === 'expired')>منقضی (expired)</option>
                                            <option value="cancelled" class="bg-gray-900 text-gray-300" @selected($subStatus === 'cancelled')>لغو شده (cancelled)</option>
                                            <option value="suspended" class="bg-gray-900 text-gray-300" @selected($subStatus === 'suspended')>معلق (suspended)</option>
                                        </select>
                                        <button
                                            type="submit"
                                            class="w-full py-2 rounded-xl border border-blue-800 bg-blue-900/30 text-blue-300 hover:bg-blue-600 hover:text-white text-xs font-medium transition"
                                        >
                                            بروزرسانی وضعیت
                                        </button>
                                    </form>
                                </div>

                                {{-- فرم تمدید پشتیبانی --}}
                                <div class="bg-gray-950/60 p-3 rounded-xl border border-gray-800/80 space-y-2">
                                    <div class="text-[11px] font-semibold text-emerald-400">تمدید مستقیم پشتیبانی</div>
                                    <form method="POST" action="{{ route('admin.subscriptions.renew', $subscription) }}" class="space-y-2">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            <input
                                                type="number"
                                                name="months"
                                                value="12"
                                                min="1"
                                                max="120"
                                                class="w-24 rounded-xl border border-gray-800 bg-black/50 text-gray-300 text-xs py-2 px-2.5 focus:border-emerald-700 focus:outline-none text-center"
                                                placeholder="تعداد ماه"
                                            >
                                            <span class="text-xs text-gray-400">ماه اضافه شود</span>
                                        </div>
                                        <button
                                            type="submit"
                                            class="w-full py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-medium transition"
                                        >
                                            تمدید پشتیبانی
                                        </button>
                                    </form>
                                </div>

                                {{-- حذف دائم --}}
                                <div class="bg-rose-950/20 p-3 rounded-xl border border-rose-900/40 space-y-2">
                                    <div class="text-[11px] font-semibold text-rose-400">منطقه حساس</div>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.subscriptions.destroy', $subscription) }}"
                                        onsubmit="return confirm('آیا از حذف دائم این اشتراک، لایسنس و تمام داده‌های متصل به آن اطمینان دارید؟ این عملیات غیرقابل بازگشت است.');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="w-full py-2 rounded-xl border border-rose-800 bg-rose-900/30 text-rose-300 hover:bg-rose-800 hover:text-white text-xs font-medium transition"
                                        >
                                            حذف دائم این اشتراک
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ================= مخصوص دسکتاپ (جدول با آکاردئون مدیریت) ================= --}}
            <div class="hidden md:block p-6">
                <div class="rounded-2xl border border-gray-800 overflow-hidden shadow-inner">
                    <table class="w-full table-fixed text-right border-collapse">
                        <thead class="bg-gray-950/70">
                            <tr class="border-b border-gray-800">
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-16 text-center">شناسه</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-44">مشترک</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-36">پلن</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-24 text-center">وضعیت</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-28 text-center">پشتیبانی</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-28 text-center">تاریخ شروع</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-28 text-center">انقضای پشتیبانی</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400">لایسنس</th>
                                <th class="py-4 px-3 text-xs font-semibold text-gray-400 w-24 text-center">عملیات</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800/50">
                            @foreach ($subscriptions as $subscription)
                                @php
                                    $subStatus = $subscription->effective_status ?? $subscription->status ?? '—';
                                    $subBadge = $getStatusBadge($subStatus);
                                    $subLabel = $getStatusLabel($subStatus);

                                    $latestSupport = $subscription->latestSupport ?? null;
                                    $supportStatus = $latestSupport->status ?? $subscription->support_status ?? '—';
                                    $supportBadge = $getStatusBadge($supportStatus);
                                    $supportLabel = $getStatusLabel($supportStatus);
                                    $supportExpireJalali = $latestSupport?->expires_at_jalali ?? $subscription->support_expires_at_jalali ?? '—';
                                @endphp

                                {{-- ردیف اصلی اشتراک --}}
                                <tr class="hover:bg-gray-800/30 transition duration-150 align-middle" id="row-{{ $subscription->id }}">
                                    {{-- شناسه --}}
                                    <td class="py-4 px-3 text-sm font-mono text-gray-400 text-center">
                                        #{{ $subscription->id }}
                                    </td>

                                    {{-- مشترک --}}
                                    <td class="py-4 px-3">
                                        <div class="text-sm font-bold text-white truncate">
                                            {{ $subscription->user->name ?? '—' }}
                                        </div>
                                        <div class="text-xs font-mono text-gray-400 truncate">
                                            {{ $subscription->user->email ?? '—' }}
                                        </div>
                                        @if($subscription->user?->phone_number)
                                            <div class="text-[11px] font-mono text-gray-500">
                                                {{ $subscription->user->phone_number }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- پلن --}}
                                    <td class="py-4 px-3">
                                        <div class="text-sm font-medium text-white truncate">
                                            {{ $subscription->plan->title ?? $subscription->plan->name ?? '—' }}
                                        </div>
                                        <div class="text-[11px] text-emerald-400">
                                            لایسنس مادام‌العمر
                                        </div>
                                    </td>

                                    {{-- وضعیت اشتراک --}}
                                    <td class="py-4 px-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium border {{ $subBadge }}">
                                            {{ $subLabel }}
                                        </span>
                                    </td>

                                    {{-- وضعیت پشتیبانی --}}
                                    <td class="py-4 px-3 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[11px] font-medium border {{ $supportBadge }}">
                                            {{ $supportLabel }}
                                        </span>
                                    </td>

                                    {{-- تاریخ شروع --}}
                                    <td class="py-4 px-3 text-xs text-gray-300 font-mono text-center whitespace-nowrap">
                                        {{ $subscription->started_at_jalali ?? $subscription->starts_at_jalali ?? '—' }}
                                    </td>

                                    {{-- انقضای پشتیبانی --}}
                                    <td class="py-4 px-3 text-xs text-gray-300 font-mono text-center whitespace-nowrap">
                                        {{ $supportExpireJalali }}
                                    </td>

                                    {{-- کلید لایسنس --}}
                                    <td class="py-4 px-3">
                                        @if($subscription->license)
                                            <code class="text-xs font-mono text-blue-400 bg-blue-950/40 px-2 py-1 rounded-md border border-blue-900/60 select-all block truncate" title="{{ $subscription->license->license_key }}">
                                                {{ $subscription->license->license_key }}
                                            </code>
                                        @else
                                            <span class="text-xs text-gray-500">—</span>
                                        @endif
                                    </td>

                                    {{-- دکمه ضامن عملیات --}}
                                    <td class="py-4 px-3 text-center">
                                        <button
                                            type="button"
                                            onclick="toggleActions({{ $subscription->id }})"
                                            class="inline-flex items-center justify-center p-2 rounded-xl border border-gray-700 bg-gray-800/80 text-gray-300 hover:border-blue-600 hover:text-blue-400 hover:bg-gray-800 transition duration-150"
                                            title="مدیریت اشتراک"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                {{-- ردیف آکاردئونی عملیات دسکتاپ --}}
                                <tr id="actions-{{ $subscription->id }}" class="hidden bg-gray-950/80 border-b border-gray-800">
                                    <td colspan="9" class="p-5">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                                            {{-- عملیات ۱: تغییر پلن --}}
                                            <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-4 space-y-3">
                                                <div class="flex items-center gap-2 text-xs font-bold text-white border-b border-gray-800 pb-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                    <span>تغییر پلن کاربر</span>
                                                </div>
                                                <form method="POST" action="{{ route('admin.subscriptions.update-plan', $subscription) }}" class="space-y-3">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div>
                                                        <label class="block text-[11px] text-gray-400 mb-1">پلن جدید:</label>
                                                        <select
                                                            name="plan_id"
                                                            class="w-full rounded-xl border border-gray-800 bg-black/50 text-gray-300 text-xs py-2 px-2.5 focus:border-blue-700 focus:outline-none transition"
                                                        >
                                                            @foreach($plans as $plan)
                                                                <option value="{{ $plan->id }}" class="bg-gray-900 text-gray-300" @selected($subscription->plan_id == $plan->id)>
                                                                    {{ $plan->title ?? $plan->name }} ({{ number_format($plan->price) }} تومان)
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="w-full px-3 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold transition"
                                                    >
                                                        ذخیره پلن جدید
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- عملیات ۲: تغییر وضعیت اشتراک --}}
                                            <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-4 space-y-3">
                                                <div class="flex items-center gap-2 text-xs font-bold text-white border-b border-gray-800 pb-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                                    <span>تغییر وضعیت اشتراک</span>
                                                </div>
                                                <form method="POST" action="{{ route('admin.subscriptions.update-status', $subscription) }}" class="space-y-3">
                                                    @csrf
                                                    @method('PATCH')

                                                    <div>
                                                        <label class="block text-[11px] text-gray-400 mb-1">وضعیت مورد نظر:</label>
                                                        <select
                                                            name="status"
                                                            class="w-full rounded-xl border border-gray-800 bg-black/50 text-gray-300 text-xs py-2 px-2.5 focus:border-blue-700 focus:outline-none transition"
                                                        >
                                                            <option value="active" class="bg-gray-900 text-gray-300" @selected($subStatus === 'active')>فعال (active)</option>
                                                            <option value="expired" class="bg-gray-900 text-gray-300" @selected($subStatus === 'expired')>منقضی (expired)</option>
                                                            <option value="cancelled" class="bg-gray-900 text-gray-300" @selected($subStatus === 'cancelled')>لغو شده (cancelled)</option>
                                                            <option value="suspended" class="bg-gray-900 text-gray-300" @selected($subStatus === 'suspended')>معلق (suspended)</option>
                                                        </select>
                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="w-full px-3 py-2 rounded-xl border border-blue-800 bg-blue-900/30 text-blue-300 hover:bg-blue-600 hover:text-white text-xs font-semibold transition"
                                                    >
                                                        بروزرسانی وضعیت
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- عملیات ۳: تمدید پشتیبانی --}}
                                            <div class="rounded-2xl border border-gray-800 bg-gray-900/60 p-4 space-y-3">
                                                <div class="flex items-center gap-2 text-xs font-bold text-white border-b border-gray-800 pb-2">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                    <span>تمدید پشتیبانی</span>
                                                </div>
                                                <form method="POST" action="{{ route('admin.subscriptions.renew', $subscription) }}" class="space-y-3">
                                                    @csrf

                                                    <div>
                                                        <label class="block text-[11px] text-gray-400 mb-1">مدت زمان تمدید:</label>
                                                        <div class="flex items-center gap-2">
                                                            <input
                                                                type="number"
                                                                name="months"
                                                                value="12"
                                                                min="1"
                                                                max="120"
                                                                class="w-full rounded-xl border border-gray-800 bg-black/50 text-gray-300 text-xs py-2 px-2.5 focus:border-emerald-700 focus:outline-none transition"
                                                            >
                                                            <span class="text-xs text-gray-400 whitespace-nowrap">ماه</span>
                                                        </div>
                                                    </div>

                                                    <button
                                                        type="submit"
                                                        class="w-full px-3 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold transition"
                                                    >
                                                        اعمال تمدید
                                                    </button>
                                                </form>
                                            </div>

                                            {{-- عملیات ۴: حذف دائم --}}
                                            <div class="rounded-2xl border border-rose-900/40 bg-rose-950/20 p-4 space-y-3 flex flex-col justify-between">
                                                <div>
                                                    <div class="flex items-center gap-2 text-xs font-bold text-rose-400 border-b border-rose-900/50 pb-2">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                        <span>منطقه خطر (حذف دائم)</span>
                                                    </div>
                                                    <p class="text-[11px] text-rose-300/80 mt-2 leading-relaxed">
                                                        حذف لایسنس، دستگاه‌های متصل و گزارش‌های مرتبط با این اشتراک به صورت غیرقابل بازگشت.
                                                    </p>
                                                </div>

                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.subscriptions.destroy', $subscription) }}"
                                                    onsubmit="return confirm('هشدار: آیا مطمئن هستید که می‌خواهید این اشتراک، لایسنس اختصاصی و کلیه دسترسی‌های آن را برای همیشه حذف کنید؟');"
                                                >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="w-full px-3 py-2 rounded-xl border border-rose-700 bg-rose-900/30 text-rose-300 hover:bg-rose-700 hover:text-white text-xs font-semibold transition duration-200"
                                                    >
                                                        حذف دائمی اشتراک
                                                    </button>
                                                </form>
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- صفحه‌بندی --}}
            @if ($subscriptions->hasPages())
                <div class="px-5 py-4 md:px-6 border-t border-gray-800 bg-gray-950/40">
                    {{ $subscriptions->links() }}
                </div>
            @endif

        @else
            {{-- در صورت نبود اطلاعات --}}
            <div class="px-6 py-16 text-center">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-gray-800/70 border border-gray-700 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-white mb-2">
                    @if(request('search'))
                        نتیجه‌ای برای «{{ request('search') }}» یافت نشد
                    @else
                        هیچ اشتراکی یافت نشد
                    @endif
                </h3>

                <p class="text-sm text-gray-500 max-w-md mx-auto">
                    @if(request('search'))
                        عبارت جستجو شده را بررسی کرده یا فیلتر را پاک کنید.
                    @else
                        در حال حاضر اشتراکی در سیستم ثبت نشده است. مشترکین جدید پس از تکمیل خرید به این بخش اضافه خواهند شد.
                    @endif
                </p>

                @if(request('search'))
                    <div class="mt-4">
                        <a
                            href="{{ route('admin.subscriptions.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-700 bg-gray-800 text-gray-300 hover:text-white text-xs font-medium transition"
                        >
                            مشاهده تمام اشتراک‌ها
                        </a>
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>

{{-- اسکریپت باز و بسته کردن آکاردئون‌ها --}}
<script>
    function toggleActions(id) {
        const row = document.getElementById('actions-' + id);
        if (!row) return;

        // بستن تمام ردیف‌های باز دیگر برای نظم بیشتر
        document.querySelectorAll('tr[id^="actions-"]').forEach(el => {
            if (el.id !== 'actions-' + id) {
                el.classList.add('hidden');
            }
        });

        row.classList.toggle('hidden');
        if (!row.classList.contains('hidden')) {
            row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function toggleActionsMobile(id) {
        const panel = document.getElementById('mobile-actions-' + id);
        if (!panel) return;

        document.querySelectorAll('div[id^="mobile-actions-"]').forEach(el => {
            if (el.id !== 'mobile-actions-' + id) {
                el.classList.add('hidden');
            }
        });

        panel.classList.toggle('hidden');
    }

    // بستن با کلید Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('tr[id^="actions-"]').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('div[id^="mobile-actions-"]').forEach(el => el.classList.add('hidden'));
        }
    });
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

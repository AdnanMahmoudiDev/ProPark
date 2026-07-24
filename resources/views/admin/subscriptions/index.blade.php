@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- هدر --}}
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

        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 text-xs font-medium">
                تعداد کل اشتراک‌ها: {{ $subscriptions->total() }}
            </div>
        </div>
    </div>

    {{-- پیام موفقیت امیز بودن --}}
    @if(session('success'))
        <div class="flex items-start gap-3 p-4 rounded-2xl border border-green-700 bg-green-900/20 text-green-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- پیام ارور --}}
    @if(session('error'))
        <div class="flex items-start gap-3 p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- خطای اعتبار سنجی --}}
    @if($errors->any())
        <div class="p-4 rounded-2xl border border-rose-700 bg-rose-900/20 text-rose-400 text-sm space-y-2">
            <div class="flex items-center gap-2 font-bold mb-1">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
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

    {{-- کارت اصلی  --}}
    <div class="bg-gray-900/70 border border-gray-800 rounded-3xl overflow-hidden">

        {{-- کارت هدر --}}
        <div class="px-5 py-4 md:px-6 md:py-5 border-b border-gray-800 bg-gradient-to-r from-blue-900/20 to-transparent">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base md:text-lg font-semibold text-white">
                        لیست اشتراک‌ها
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">
                        مشاهده، تمدید، تغییر وضعیت و حذف اشتراک‌های ثبت‌شده
                    </p>
                </div>

                <div class="text-xs text-gray-500">
                    مجموع نتایج این صفحه: {{ $subscriptions->count() }}
                </div>
            </div>
        </div>

        @if($subscriptions->count() > 0)

            {{-- مخصوص موبایل --}}
            
            <div class="md:hidden p-4 space-y-4">
                @foreach($subscriptions as $subscription)
                    @php
                        $statusValue = $subscription->effective_status ?? $subscription->status ?? '—';
                        $statusBadge = $getStatusBadge($statusValue);
                        $statusLabel = $getStatusLabel($statusValue);
                    @endphp

                    <div class="rounded-2xl border border-gray-800 bg-black/20 p-4 space-y-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-white">
                                    {{ $subscription->user->name ?? '—' }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500 font-mono">
                                    شناسه اشتراک: #{{ $subscription->id }}
                                </div>
                            </div>

                            <div class="shrink-0">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium {{ $statusBadge }}">
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3 text-sm">
                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">ایمیل</div>
                                <div class="text-gray-300 font-mono break-all">
                                    {{ $subscription->user->email ?? '—' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <div class="text-[11px] text-gray-500 mb-1">پلن</div>
                                    <div class="text-gray-300 break-words">
                                        {{ $subscription->plan->title ?? $subscription->plan->name ?? '—' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-[11px] text-gray-500 mb-1">لایسنس</div>
                                    <div class="text-blue-400 font-mono break-all">
                                        {{ $subscription->license->license_key ?? '—' }}
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <div class="text-[11px] text-gray-500 mb-1">تاریخ شروع</div>
                                    <div class="text-gray-300 font-mono text-xs">
                                        {{ $subscription->started_at_jalali ?? $subscription->starts_at_jalali ?? '—' }}
                                    </div>
                                </div>

                                <div>
                                    <div class="text-[11px] text-gray-500 mb-1">تاریخ انقضا</div>
                                    <div class="text-gray-300 font-mono text-xs">
                                        {{ $subscription->expires_at_jalali ?? $subscription->ends_at_jalali ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- تغییر وضعیت --}}
                        <div class="pt-2 border-t border-gray-800">
                            <div class="text-[11px] text-gray-500 mb-3">
                                تغییر وضعیت اشتراک
                            </div>

                            <form method="POST" action="{{ route('admin.subscriptions.update-status', $subscription) }}" class="space-y-3">
                                @csrf
                                @method('PATCH')

                                <select
                                    name="status"
                                    class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2.5 px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                >
                                    <option value="active" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'active')>Active</option>
                                    <option value="expired" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'expired')>Expired</option>
                                    <option value="cancelled" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'cancelled')>Cancelled</option>
                                    <option value="suspended" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'suspended')>Suspended</option>
                                </select>

                                <button
                                    type="submit"
                                    class="w-full px-4 py-2.5 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 hover:bg-blue-600 hover:text-white text-sm font-medium transition duration-200"
                                >
                                    ثبت وضعیت
                                </button>
                            </form>
                        </div>

                        {{-- تمدید --}}
                        <div class="pt-2 border-t border-gray-800">
                            <div class="text-[11px] text-gray-500 mb-3">
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
                                    class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2.5 px-3 focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                >

                                <button
                                    type="submit"
                                    class="w-full px-4 py-2.5 rounded-xl border border-emerald-800 bg-emerald-900/20 text-emerald-300 hover:bg-emerald-600 hover:text-white text-sm font-medium transition duration-200"
                                >
                                    تمدید اشتراک
                                </button>
                            </form>
                        </div>

                        {{-- حذف --}}
                        <div class="pt-2 border-t border-gray-800">
                            <div class="text-[11px] text-gray-500 mb-3">
                                عملیات
                            </div>

                            <form
                                method="POST"
                                action="{{ route('admin.subscriptions.destroy', $subscription) }}"
                                onsubmit="return confirm('آیا از حذف مطمئن هستید؟ با این کار تمامی اطلاعات اشتراک، لایسنس و دستگاه‌های متصل به صورت دائم پاک خواهند شد.')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="w-full px-4 py-2.5 rounded-xl border border-rose-900/40 bg-rose-950/20 text-rose-400 hover:bg-rose-900 hover:text-white text-sm font-medium transition duration-200"
                                >
                                    حذف اشتراک
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- قسمت مخصوص دسکتاپ --}}
           
            <div class="hidden md:block p-3 lg:p-4">
                <table class="w-full text-right border-separate border-spacing-0">
                    <thead class="bg-gray-950/60">
                        <tr>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">شناسه</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">کاربر</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">ایمیل</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">پلن</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">وضعیت</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">تاریخ شروع</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">تاریخ انقضا</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">لایسنس</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">تغییر وضعیت</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">تمدید</th>
                            <th class="py-2.5 px-1.5 lg:px-2 text-[10px] font-semibold text-gray-400 border-b border-gray-800 whitespace-nowrap">عملیات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($subscriptions as $subscription)
                            @php
                                $statusValue = $subscription->effective_status ?? $subscription->status ?? '—';
                                $statusBadge = $getStatusBadge($statusValue);
                                $statusLabel = $getStatusLabel($statusValue);
                            @endphp

                            <tr class="hover:bg-gray-800/20 transition">
                                {{-- ایدی --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] font-mono text-gray-300 border-b border-gray-800/70 whitespace-nowrap">
                                    #{{ $subscription->id }}
                                </td>

                                {{-- کاربر --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] font-medium text-white border-b border-gray-800/70 whitespace-nowrap">
                                    <div class="max-w-[90px] lg:max-w-[110px] truncate" title="{{ $subscription->user->name ?? '' }}">
                                        {{ $subscription->user->name ?? '—' }}
                                    </div>
                                </td>

                                {{-- ایمیل --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] font-mono text-gray-400 border-b border-gray-800/70">
                                    <div class="max-w-[105px] lg:max-w-[130px] truncate" title="{{ $subscription->user->email ?? '' }}">
                                        {{ $subscription->user->email ?? '—' }}
                                    </div>
                                </td>

                                {{-- پلن --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] text-gray-300 border-b border-gray-800/70">
                                    <div class="max-w-[75px] lg:max-w-[95px] truncate" title="{{ $subscription->plan->title ?? $subscription->plan->name ?? '' }}">
                                        {{ $subscription->plan->title ?? $subscription->plan->name ?? '—' }}
                                    </div>
                                </td>

                                {{-- وضعیت --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] border-b border-gray-800/70 whitespace-nowrap">
                                    <span class="inline-flex px-1.5 py-0.5 rounded-md text-[9px] font-medium {{ $statusBadge }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                {{-- تاریخ شروع --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] font-mono text-gray-400 border-b border-gray-800/70 whitespace-nowrap">
                                    {{ $subscription->started_at_jalali ?? $subscription->starts_at_jalali ?? '—' }}
                                </td>

                                {{-- تاریخ انقضا --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] font-mono text-gray-400 border-b border-gray-800/70 whitespace-nowrap">
                                    {{ $subscription->expires_at_jalali ?? $subscription->ends_at_jalali ?? '—' }}
                                </td>

                                {{-- لایسنس --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] font-mono text-blue-400 border-b border-gray-800/70">
                                    <div class="max-w-[90px] lg:max-w-[115px] truncate" title="{{ $subscription->license->license_key ?? '' }}">
                                        {{ $subscription->license->license_key ?? '—' }}
                                    </div>
                                </td>

                                {{-- تغییر وضعیت --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] border-b border-gray-800/70">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.subscriptions.update-status', $subscription) }}"
                                        class="flex items-center gap-1"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <select
                                            name="status"
                                            class="w-[78px] lg:w-[88px] rounded-md border border-gray-800 bg-black/40 text-gray-300 text-[10px] py-1.5 px-1.5 focus:border-blue-700 focus:ring-0 focus:outline-none transition"
                                        >
                                            <option value="active" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'active')>Active</option>
                                            <option value="expired" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'expired')>Expired</option>
                                            <option value="cancelled" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'cancelled')>Cancelled</option>
                                            <option value="suspended" class="bg-gray-900 text-gray-300" @selected(($subscription->status ?? null) === 'suspended')>Suspended</option>
                                        </select>

                                        <button
                                            type="submit"
                                            class="px-2 py-1.5 rounded-md border border-blue-800 bg-blue-900/20 text-blue-300 hover:bg-blue-600 hover:text-white text-[10px] font-medium transition whitespace-nowrap"
                                        >
                                            ثبت
                                        </button>
                                    </form>
                                </td>

                                {{-- تمدید --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] border-b border-gray-800/70">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.subscriptions.renew', $subscription) }}"
                                        class="flex items-center gap-1"
                                    >
                                        @csrf

                                        <input
                                            type="number"
                                            name="months"
                                            min="1"
                                            max="120"
                                            placeholder="ماه"
                                            required
                                            class="w-[42px] lg:w-[48px] rounded-md border border-gray-800 bg-black/40 text-gray-300 text-[10px] py-1.5 px-1 text-center focus:border-blue-700 focus:ring-0 focus:outline-none transition [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                                        >

                                        <button
                                            type="submit"
                                            class="px-2 py-1.5 rounded-md border border-emerald-800 bg-emerald-900/20 text-emerald-300 hover:bg-emerald-600 hover:text-white text-[10px] font-medium transition whitespace-nowrap"
                                        >
                                            تمدید
                                        </button>
                                    </form>
                                </td>

                                {{-- حذف --}}
                                <td class="py-2.5 px-1.5 lg:px-2 text-[10px] border-b border-gray-800/70 whitespace-nowrap">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.subscriptions.destroy', $subscription) }}"
                                        onsubmit="return confirm('آیا از حذف مطمئن هستید؟ با این کار تمامی اطلاعات اشتراک، لایسنس و دستگاه‌های متصل به صورت دائم پاک خواهند شد.')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="px-2 py-1.5 rounded-md border border-rose-900/40 bg-rose-950/20 text-rose-400 hover:bg-rose-900 hover:text-white text-[10px] font-medium transition whitespace-nowrap"
                                        >
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- صفحه بندی --}}
            @if ($subscriptions->hasPages())
                <div class="px-5 py-4 md:px-6 border-t border-gray-800 bg-gray-950/20">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        @else
           
            <div class="px-6 py-14 text-center">
                <div class="mx-auto w-14 h-14 rounded-2xl bg-gray-800/70 border border-gray-700 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 17v-2a4 4 0 014-4h6m-6 8h6m-6-8V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h6"/>
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
@endsection

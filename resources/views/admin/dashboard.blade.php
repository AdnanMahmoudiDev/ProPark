@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- هدر --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white leading-tight">
                داشبورد مدیریت
            </h2>
            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                <span>
                    تاریخ امروز:
                    {{ jdate(now())->format('Y/m/d') }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl border border-blue-800 bg-blue-900/20 text-blue-300 text-xs">
                AvaPark Admin Panel
            </div>
        </div>
    </div>

    {{-- باکس خوش امد گویی --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-gray-900 to-gray-950 border border-gray-800 rounded-3xl p-7 shadow-2xl">
        <div class="absolute top-0 right-0 w-72 h-72 bg-blue-700/10 blur-3xl rounded-full"></div>
        <div class="relative z-10">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-blue-600/20 border border-blue-700 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">
                            خوش آمدی، {{ auth()->user()->name }}
                        </h3>
                        <p class="text-sm text-gray-400 mt-1">
                            پنل کنترل و نظارت بر تراکنش‌ها، کاربران و لایسنس‌های AvaPark
                        </p>
                    </div>
                </div>
                <div class="px-4 py-2 rounded-xl border border-blue-700 bg-blue-900/20 text-blue-400 text-xs font-medium">
                    سطح دسترسی: مدیر 
                </div>
            </div>
        </div>
    </div>

    {{-- قسمت کاربران --}}
    <div>
        <div class="flex items-center gap-2 mb-4">
            <span class="w-1.5 h-5 bg-blue-500 rounded-full"></span>
            <h3 class="text-base font-bold text-white">آمار کاربران</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- تمام کاربران --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-6 hover:border-blue-700/50 transition duration-300">
                <div class="absolute top-0 left-0 w-40 h-40 bg-blue-600/10 blur-3xl rounded-full"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">کل کاربران ثبت‌نامی</p>
                        <h3 class="mt-2 text-3xl font-bold text-white">{{ $totalUsers }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-600/20 border border-blue-700 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- کاربر های جدید --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-6 hover:border-blue-700/50 transition duration-300">
                <div class="absolute top-0 left-0 w-40 h-40 bg-blue-600/10 blur-3xl rounded-full"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">کاربران جدید (۷ روز اخیر)</p>
                        <h3 class="mt-2 text-3xl font-bold text-cyan-400">{{ $newUsersLast7Days }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-600/20 border border-cyan-700 flex items-center justify-center">
                        <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- نرخ تبدیل --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-6 hover:border-blue-700/50 transition duration-300">
                <div class="absolute top-0 left-0 w-40 h-40 bg-blue-600/10 blur-3xl rounded-full"></div>
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400">نرخ تبدیل</p>
                        <h3 class="mt-2 text-3xl font-bold text-emerald-400">{{ $conversionRate }}%</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-600/20 border border-emerald-700 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- قسمت اشتراک ها --}}
    <div>
        <div class="flex items-center gap-2 mb-4">
            <span class="w-1.5 h-5 bg-blue-500 rounded-full"></span>
            <h3 class="text-base font-bold text-white">آمار اشتراک‌ها</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            {{-- کل اشتراک ها --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-5 hover:border-blue-700/50 transition duration-300">
                <div class="relative z-10">
                    <p class="text-xs text-gray-400">کل اشتراک‌ها</p>
                    <h3 class="mt-2 text-2xl font-bold text-white">{{ $totalSubscriptions }}</h3>
                </div>
            </div>

            {{-- اشتراک های فعال --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-5 hover:border-blue-700/50 transition duration-300">
                <div class="relative z-10">
                    <p class="text-xs text-gray-400">فعال</p>
                    <h3 class="mt-2 text-2xl font-bold text-emerald-400">{{ $activeSubscriptions }}</h3>
                </div>
            </div>

            {{-- اشتراک های منقضی شده --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-5 hover:border-blue-700/50 transition duration-300">
                <div class="relative z-10">
                    <p class="text-xs text-gray-400">منقضی شده</p>
                    <h3 class="mt-2 text-2xl font-bold text-rose-400">{{ $expiredSubscriptions }}</h3>
                </div>
            </div>

            {{-- اشتراک های جدید --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-5 hover:border-blue-700/50 transition duration-300">
                <div class="relative z-10">
                    <p class="text-xs text-gray-400">جدید (۷ روز اخیر)</p>
                    <h3 class="mt-2 text-2xl font-bold text-cyan-400">{{ $newSubscriptionsLast7Days }}</h3>
                </div>
            </div>

            {{-- در استانه انقضا --}}
            <div class="relative overflow-hidden bg-gray-900/70 border border-gray-800 rounded-3xl p-5 hover:border-blue-700/50 transition duration-300">
                <div class="relative z-10">
                    <p class="text-xs text-gray-400">در آستانه انقضا</p>
                    <h3 class="mt-2 text-2xl font-bold text-amber-400">{{ $expiringSoonSubscriptions }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- اخرین کاربر ها --}}
        <div class="bg-gray-900/70 border border-gray-800 rounded-3xl p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                <h3 class="text-lg font-bold text-white">آخرین کاربران</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="py-3 text-xs font-semibold text-gray-400">شناسه</th>
                            <th class="py-3 text-xs font-semibold text-gray-400">نام</th>
                            <th class="py-3 text-xs font-semibold text-gray-400">ایمیل</th>
                            <th class="py-3 text-xs font-semibold text-gray-400">تاریخ عضویت</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/40">
                        @forelse($latestUsers as $user)
                            <tr class="hover:bg-gray-800/20 transition duration-150">
                                <td class="py-3.5 text-sm font-mono text-gray-300">{{ $user->id }}</td>
                                <td class="py-3.5 text-sm font-medium text-white">{{ $user->name }}</td>
                                <td class="py-3.5 text-sm font-mono text-gray-400 break-all">{{ $user->email }}</td>
                                <td class="py-3.5 text-sm text-gray-400">
                                    {{ jdate($user->created_at)->format('Y/m/d') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-gray-500">
                                    هیچ کاربری ثبت نشده است.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- اخرین اشتراک ها --}}
        <div class="bg-gray-900/70 border border-gray-800 rounded-3xl p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 bg-blue-500 rounded-full"></span>
                <h3 class="text-lg font-bold text-white">آخرین اشتراک‌ها</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="border-b border-gray-800">
                            <th class="py-3 text-xs font-semibold text-gray-400">شناسه</th>
                            <th class="py-3 text-xs font-semibold text-gray-400">کاربر</th>
                            <th class="py-3 text-xs font-semibold text-gray-400">وضعیت</th>
                            <th class="py-3 text-xs font-semibold text-gray-400">تاریخ انقضا</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/40">
                        @forelse($latestSubscriptions as $subscription)
                            @php
                                $status = strtolower($subscription->effective_status ?? '');
                                $statusBadge = 'bg-gray-900/20 border border-gray-800 text-gray-400';
                                
                                if ($status === 'active') {
                                    $statusBadge = 'bg-green-900/20 border border-green-700 text-green-400';
                                } elseif (in_array($status, ['expired', 'inactive'])) {
                                    $statusBadge = 'bg-red-900/20 border border-red-700 text-red-400';
                                } elseif (in_array($status, ['pending', 'soon'])) {
                                    $statusBadge = 'bg-amber-900/20 border border-amber-700 text-amber-400';
                                }
                            @endphp
                            <tr class="hover:bg-gray-800/20 transition duration-150">
                                <td class="py-3.5 text-sm font-mono text-gray-300">#{{ $subscription->id }}</td>
                                <td class="py-3.5 text-sm font-medium text-white">
                                    {{ $subscription->user->name ?? 'کاربر ناشناس' }}
                                </td>
                                <td class="py-3.5 text-sm">
                                    <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $statusBadge }}">
                                        {{ $subscription->effective_status }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-sm font-mono text-gray-400">
                                    {{ $subscription->expires_at_jalali }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-sm text-gray-500">
                                    هیچ اشتراکی ثبت نشده است.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection

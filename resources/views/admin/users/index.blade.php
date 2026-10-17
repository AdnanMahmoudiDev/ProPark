@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- ================= هدر صفحه (هماهنگ با استایل جدید ProPark) ================= --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-5 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
        
        {{-- افکت‌های هاله نوری نئونی در پس‌زمینه --}}
        <div class="pointer-events-none absolute -top-16 left-1/2 -translate-x-1/2 h-32 w-[500px] rounded-full bg-gradient-to-r from-blue-600/20 via-indigo-600/25 to-purple-600/20 blur-[80px] opacity-70"></div>
        <div class="pointer-events-none absolute -top-12 -right-8 h-40 w-40 rounded-full bg-indigo-500/15 blur-[50px] opacity-50"></div>
        <div class="pointer-events-none absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-blue-500/10 blur-[40px] opacity-40"></div>

        <div class="relative flex flex-col md:flex-row md:items-center md:justify-between gap-5">
            <div class="flex items-center gap-4">
                {{-- آیکون هدر --}}
                <div class="hidden sm:flex items-center justify-center w-12 h-12 rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700/50 shadow-lg">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-white tracking-tight flex items-center gap-3">
                        <span>{{ __('مدیریت کاربران') }}</span>
                    </h2>
                    <div class="flex items-center gap-2 mt-2 text-xs text-gray-400 font-normal">
                        <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(59,130,246,0.8)]"></span>
                        <span>{{ __('لیست کلیه کاربران ثبت‌نام شده در پلتفرم AvaPark') }}</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center flex-wrap gap-3">
                {{-- بج تعداد کاربران --}}
                <div class="group relative overflow-hidden inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl border border-gray-800/80 bg-gray-950/40 text-gray-300 shadow-inner backdrop-blur-sm transition-all hover:border-gray-700">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <span class="text-[11px] uppercase tracking-wider text-gray-500 font-bold">{{ __('تعداد کل') }}:</span>
                    <span class="font-bold text-blue-400 font-mono text-base tracking-tighter">{{ number_format($users->total()) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ================= پیام‌های سیستم ================= --}}
    @if (session('success'))
        <div class="relative overflow-hidden flex items-start gap-3 p-4 rounded-2xl border border-green-500/30 bg-green-500/10 text-green-400 text-sm backdrop-blur-md animate-in fade-in slide-in-from-top-2 duration-300">
            <div class="absolute inset-0 bg-gradient-to-r from-green-500/5 to-transparent"></div>
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="relative z-10 font-medium">{{ session('success') }}</div>
        </div>
    @endif

    {{-- ================= کارت اصلی جدول کاربران ================= --}}
    <div class="bg-gray-900/60 border border-gray-800/60 rounded-[2.5rem] overflow-hidden shadow-2xl backdrop-blur-xl">

        {{-- هدر داخلی کارت --}}
        <div class="px-6 py-5 border-b border-gray-800/60 bg-gradient-to-r from-gray-900/80 to-transparent">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base md:text-lg font-bold text-white flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                        {{ __('لیست کاربران') }}
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1 mr-3">
                        {{ __('مشاهده، کنترل و تغییر سطوح دسترسی کاربران سیستم') }}
                    </p>
                </div>

                <div class="inline-flex items-center px-3 py-1 rounded-full bg-gray-950 text-[10px] text-gray-500 font-mono border border-gray-800">
                    {{ __('صفحه جاری') }}: {{ $users->count() }}
                </div>
            </div>
        </div>

        @if ($users->count() > 0)

            {{-- نمایش موبایل (Card-based) --}}
            <div class="md:hidden p-4 space-y-4">
                @foreach ($users as $user)
                    <div class="rounded-3xl border border-gray-800/80 bg-black/30 p-5 space-y-4 relative group transition-all hover:border-gray-700">
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors">
                                    {{ $user->name }}
                                </div>
                                <div class="mt-1 text-[10px] text-gray-500 font-mono bg-gray-900 px-2 py-0.5 rounded-md inline-block">
                                    ID: #{{ $user->id }}
                                </div>
                            </div>

                            <div class="shrink-0">
                                @if ($user->role === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-bold bg-blue-500/10 border border-blue-500/30 text-blue-400">
                                        {{ __('مدیر سیستم') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-bold bg-gray-800 border border-gray-700 text-gray-400">
                                        {{ __('کاربر عادی') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-3 py-3 border-y border-gray-800/50">
                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-500 mb-0.5">{{ __('پست الکترونیک') }}</span>
                                <span class="text-xs text-gray-300 font-mono break-all">{{ $user->email }}</span>
                            </div>

                            <div class="flex flex-col">
                                <span class="text-[10px] text-gray-500 mb-0.5">{{ __('شماره تماس') }}</span>
                                <span class="text-xs text-gray-300 font-mono tracking-widest">{{ $user->phone_number ?? '---' }}</span>
                            </div>
                        </div>

                        {{-- فرم تغییر سطح در موبایل --}}
                        <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="space-y-3 pt-1">
                            @csrf
                            @method('PATCH')
                            <div class="flex gap-2">
                                <select name="role" class="flex-1 rounded-xl border border-gray-800 bg-gray-900 text-gray-300 text-xs py-2.5 px-3 focus:border-blue-600 focus:ring-0 transition">
                                    <option value="user" @selected($user->role === 'user')>{{ __('کاربر عادی') }}</option>
                                    <option value="admin" @selected($user->role === 'admin')>{{ __('مدیر سیستم') }}</option>
                                </select>
                                <button type="submit" class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition-all shadow-lg shadow-blue-600/20">
                                    {{ __('ثبت') }}
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- نمایش دسکتاپ (Table-based) --}}
            <div class="hidden md:block p-6">
                <div class="rounded-[2rem] border border-gray-800/60 overflow-hidden bg-black/20 shadow-inner">
                    <table class="w-full table-fixed text-right border-collapse">
                        <thead>
                            <tr class="bg-gray-950/80 border-b border-gray-800/60">
                                <th class="py-5 px-6 text-[11px] font-black text-gray-500 uppercase tracking-wider w-20">{{ __('ID') }}</th>
                                <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider w-44">{{ __('نام کاربر') }}</th>
                                <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider">{{ __('ایمیل') }}</th>
                                <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider w-40">{{ __('موبایل') }}</th>
                                <th class="py-5 px-4 text-[11px] font-black text-gray-500 uppercase tracking-wider w-36">{{ __('نقش') }}</th>
                                <th class="py-5 px-6 text-[11px] font-black text-gray-500 uppercase tracking-wider w-64 text-left">{{ __('عملیات مدیریت') }}</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800/40">
                            @foreach ($users as $user)
                                <tr class="group hover:bg-blue-500/[0.02] transition-colors duration-200">
                                    <td class="py-5 px-6 text-xs font-mono text-gray-500">
                                        #{{ $user->id }}
                                    </td>

                                    <td class="py-5 px-4">
                                        <div class="text-sm font-bold text-white group-hover:text-blue-400 transition-colors">
                                            {{ $user->name }}
                                        </div>
                                    </td>

                                    <td class="py-5 px-4">
                                        <div class="text-xs font-mono text-gray-400 truncate" title="{{ $user->email }}">
                                            {{ $user->email }}
                                        </div>
                                    </td>

                                    <td class="py-5 px-4">
                                        <span class="text-xs text-gray-300 font-mono tracking-wider">
                                            {{ $user->phone_number ?? '---' }}
                                        </span>
                                    </td>

                                    <td class="py-5 px-4">
                                        @if ($user->role === 'admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-blue-500/10 border border-blue-500/30 text-blue-400">
                                                {{ __('مدیر') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-gray-800/60 border border-gray-700/50 text-gray-500">
                                                {{ __('کاربر') }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-5 px-6">
                                        <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="flex items-center justify-end gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="role" class="rounded-xl border border-gray-800 bg-gray-950/50 text-gray-300 text-[11px] py-1.5 px-3 focus:border-blue-600 focus:ring-0 transition cursor-pointer">
                                                <option value="user" @selected($user->role === 'user')>{{ __('کاربر عادی') }}</option>
                                                <option value="admin" @selected($user->role === 'admin')>{{ __('مدیر سیستم') }}</option>
                                            </select>
                                            <button type="submit" class="px-4 py-1.5 rounded-xl border border-blue-600/50 bg-blue-600/10 text-blue-400 hover:bg-blue-600 hover:text-white text-[11px] font-bold transition-all">
                                                {{ __('بروزرسانی') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- صفحه‌بندی مدرن --}}
            @if ($users->hasPages())
                <div class="px-8 py-6 border-t border-gray-800/60 bg-gray-950/30">
                    {{ $users->links() }}
                </div>
            @endif
        @else
            {{-- حالت خالی --}}
            <div class="px-6 py-20 text-center">
                <div class="relative inline-flex items-center justify-center w-20 h-20 rounded-[2rem] bg-gray-800/40 border border-gray-700/50 mb-6 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-transparent"></div>
                    <svg class="w-10 h-10 text-gray-600 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H11a4 4 0 00-4 4v2m10 0H7m10-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-black text-white mb-2">{{ __('کاربری یافت نشد!') }}</h3>
                <p class="text-sm text-gray-500 max-w-xs mx-auto leading-relaxed">
                    {{ __('در حال حاضر هیچ کاربری در دیتابیس سامانه ثبت نشده است.') }}
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

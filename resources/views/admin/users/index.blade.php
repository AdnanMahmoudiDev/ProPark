@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- هدر --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-white leading-tight">
                مدیریت کاربران
            </h2>

            <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                <span class="w-2 h-2 rounded-full bg-violet-500 animate-pulse"></span>
                <span>لیست کلیه کاربران ثبت‌شده در سامانه ProPark</span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <div class="px-4 py-2 rounded-xl border border-violet-800 bg-violet-900/20 text-violet-300 text-xs font-medium">
                تعداد کل کاربران: {{ $users->total() }}
            </div>
        </div>
    </div>

    {{-- پیام موفقیت امیز بودن --}}
    @if (session('success'))
        <div class="flex items-start gap-3 p-4 rounded-2xl border border-green-700 bg-green-900/20 text-green-400 text-sm">
            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    {{-- کارت اصلی --}}
    <div class="bg-gray-900/70 border border-gray-800 rounded-3xl overflow-hidden">

        {{-- کارت هدر --}}
        <div class="px-5 py-4 md:px-6 md:py-5 border-b border-gray-800 bg-gradient-to-r from-violet-900/20 to-transparent">
            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-base md:text-lg font-semibold text-white">
                        لیست کاربران
                    </h3>
                    <p class="text-xs md:text-sm text-gray-500 mt-1">
                        مشاهده اطلاعات کاربران و مدیریت سطح دسترسی آن‌ها
                    </p>
                </div>

                <div class="text-xs text-gray-500">
                    مجموع نتایج این صفحه: {{ $users->count() }}
                </div>
            </div>
        </div>

        @if ($users->count() > 0)

            {{-- مخصوص موبایل --}}
            <div class="md:hidden p-4 space-y-4">
                @foreach ($users as $user)
                    <div class="rounded-2xl border border-gray-800 bg-black/20 p-4 space-y-4">

                       
                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <div class="text-sm font-bold text-white">
                                    {{ $user->name }}
                                </div>
                                <div class="mt-1 text-xs text-gray-500 font-mono">
                                    شناسه: #{{ $user->id }}
                                </div>
                            </div>

                            <div class="shrink-0">
                                @if ($user->role === 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-violet-900/20 border border-violet-700 text-violet-400">
                                        مدیر سیستم
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-medium bg-gray-800 border border-gray-700 text-gray-400">
                                        کاربر عادی
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- اطلاعات --}}
                        <div class="space-y-3 text-sm">
                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">ایمیل</div>
                                <div class="text-gray-300 font-mono break-all">
                                    {{ $user->email }}
                                </div>
                            </div>

                            <div>
                                <div class="text-[11px] text-gray-500 mb-1">شماره موبایل</div>
                                <div class="text-gray-300 font-mono">
                                    {{ $user->phone_number ?? '—' }}
                                </div>
                            </div>
                        </div>

                        {{-- فرم تعیین سطح کاربر --}}
                        <div class="pt-2 border-t border-gray-800">
                            <div class="text-[11px] text-gray-500 mb-3">
                                تغییر سطح دسترسی
                            </div>

                            <form method="POST" action="{{ route('admin.users.update-role', $user) }}" class="space-y-3">
                                @csrf
                                @method('PATCH')

                                <select
                                    name="role"
                                    class="w-full rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-sm py-2.5 px-3 focus:border-violet-700 focus:ring-violet-700 focus:ring-0 focus:outline-none transition"
                                >
                                    <option value="user" class="bg-gray-900 text-gray-300" @selected($user->role === 'user')>
                                        کاربر عادی
                                    </option>
                                    <option value="admin" class="bg-gray-900 text-gray-300" @selected($user->role === 'admin')>
                                        مدیر سیستم (ادمین)
                                    </option>
                                </select>

                                <button
                                    type="submit"
                                    class="w-full px-4 py-2.5 rounded-xl border border-violet-800 bg-violet-900/20 text-violet-300 hover:bg-violet-600 hover:text-white text-sm font-medium transition duration-200"
                                >
                                    ثبت تغییرات
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- قسمت مخصوص دسکتاپ --}}
            <div class="hidden md:block p-6">
                <div class="rounded-2xl border border-gray-800 overflow-hidden">
                    <table class="w-full table-fixed text-right border-collapse">
                        <thead class="bg-gray-950/60">
                            <tr class="border-b border-gray-800">
                                <th class="py-4 px-4 text-xs font-semibold text-gray-400 w-20">شناسه</th>
                                <th class="py-4 px-4 text-xs font-semibold text-gray-400 w-40">نام</th>
                                <th class="py-4 px-4 text-xs font-semibold text-gray-400">ایمیل</th>
                                <th class="py-4 px-4 text-xs font-semibold text-gray-400 w-40">شماره موبایل</th>
                                <th class="py-4 px-4 text-xs font-semibold text-gray-400 w-36">نقش فعلی</th>
                                <th class="py-4 px-4 text-xs font-semibold text-gray-400 w-64">تغییر سطح دسترسی</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-800/50">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-800/20 transition duration-150 align-middle">
                                    <td class="py-4 px-4 text-sm font-mono text-gray-300 align-top">
                                        #{{ $user->id }}
                                    </td>

                                    <td class="py-4 px-4 text-sm font-medium text-white align-top">
                                        {{ $user->name }}
                                    </td>

                                    <td class="py-4 px-4 text-sm font-mono text-gray-400 break-all align-top">
                                        {{ $user->email }}
                                    </td>

                                    <td class="py-4 px-4 text-sm text-gray-300 font-mono align-top whitespace-nowrap">
                                        {{ $user->phone_number ?? '—' }}
                                    </td>

                                    <td class="py-4 px-4 text-sm align-top">
                                        @if ($user->role === 'admin')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-violet-900/20 border border-violet-700 text-violet-400">
                                                مدیر سیستم
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-800 border border-gray-700 text-gray-400">
                                                کاربر عادی
                                            </span>
                                        @endif
                                    </td>

                                    <td class="py-4 px-4 text-sm align-top">
                                        <form
                                            method="POST"
                                            action="{{ route('admin.users.update-role', $user) }}"
                                            class="flex items-center gap-2"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <select
                                                name="role"
                                                class="rounded-xl border border-gray-800 bg-black/40 text-gray-300 text-xs py-2 px-3 focus:border-violet-700 focus:ring-violet-700 focus:ring-0 focus:outline-none transition"
                                            >
                                                <option value="user" class="bg-gray-900 text-gray-300" @selected($user->role === 'user')>
                                                    کاربر عادی
                                                </option>
                                                <option value="admin" class="bg-gray-900 text-gray-300" @selected($user->role === 'admin')>
                                                    مدیر سیستم (ادمین)
                                                </option>
                                            </select>

                                            <button
                                                type="submit"
                                                class="px-4 py-2 rounded-xl border border-violet-800 bg-violet-900/20 text-violet-300 hover:bg-violet-600 hover:text-white text-xs font-medium transition duration-200 whitespace-nowrap"
                                            >
                                                ثبت
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- صفحه بندی  --}}
            @if ($users->hasPages())
                <div class="px-5 py-4 md:px-6 border-t border-gray-800 bg-gray-950/20">
                    {{ $users->links() }}
                </div>
            @endif
        @else
           
            <div class="px-6 py-14 text-center">
                <div class="mx-auto w-14 h-14 rounded-2xl bg-gray-800/70 border border-gray-700 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-4-4H11a4 4 0 00-4 4v2m10 0H7m10-10a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>

                <h3 class="text-lg font-semibold text-white mb-2">
                    هیچ کاربری یافت نشد
                </h3>

                <p class="text-sm text-gray-500">
                    در حال حاضر هیچ کاربری برای نمایش در این بخش وجود ندارد.
                </p>
            </div>
        @endif
    </div>
</div>
@endsection

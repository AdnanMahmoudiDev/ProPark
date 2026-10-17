@extends('admin.layout.app')

@section('content')
<div class="space-y-8" x-data="supportPageManager()">

    {{-- ================= هدر صفحه (طراحی نئونی تیره) ================= --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-6 sm:p-8 backdrop-blur-2xl shadow-2xl shadow-black/50">
        {{-- افکت نوری پس‌زمینه --}}
        <div class="pointer-events-none absolute -top-12 left-1/2 h-44 w-96 -translate-x-1/2 rounded-full bg-gradient-to-r from-cyan-500/20 via-blue-500/20 to-indigo-500/20 blur-3xl"></div>

        <div class="relative z-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="flex items-center gap-4">
                {{-- باکس آیکون هدر با SVG جدید پشتیبانی --}}
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500/20 to-blue-600/20 border border-cyan-500/30 text-cyan-400 shadow-inner shadow-cyan-500/20">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 18v-6a9 9 0 0118 0v6"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 19a2 2 0 01-2 2h-1a2 2 0 01-2-2v-3a2 2 0 012-2h3zM3 19a2 2 0 002 2h1a2 2 0 002-2v-3a2 2 0 00-2-2H3z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 19a3 3 0 01-3 3h-3"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black tracking-tight text-white sm:text-3xl">
                        {{ __('مدیریت پشتیبانی') }}
                    </h1>
                    <p class="mt-1 text-sm font-medium text-gray-400">
                        {{ __('مشاهده وضعیت اعتبار، تاریخ انقضا و مدیریت تمدید پشتیبانی لایسنس‌ها') }}
                    </p>
                </div>
            </div>

            {{-- فیلتر و دکمه بازگشت هماهنگ --}}
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                {{-- دکمه مدیریت اشتراک‌ها هماهنگ با استایل دکمه مدیریت پشتیبانی‌ها --}}
                <a
                    href="{{ url('admin/subscriptions') }}"
                    class="group relative inline-flex items-center justify-center gap-2.5 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/30 ring-1 ring-white/20 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 hover:ring-white/30 focus:outline-none focus:ring-2 focus:ring-blue-400/60 active:translate-y-0"
                    title="{{ __('مدیریت اشتراک‌های کاربران') }}"
                >
                    <div class="flex h-6 w-6 items-center justify-center rounded-xl bg-white/15 border border-white/20 shadow-inner">
                        <svg class="h-3.5 w-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>

                    <span>{{ __('مدیریت اشتراک‌ها') }}</span>

                    <svg class="h-4 w-4 rtl:rotate-180 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>

                <form method="GET" action="{{ route('admin.supports.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <div class="relative min-w-[240px]">
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-500">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="{{ __('جستجو کاربر، ایمیل یا لایسنس...') }}"
                               class="w-full rounded-2xl border border-gray-800 bg-gray-900/90 py-2.5 pr-11 pl-4 text-sm text-gray-200 placeholder-gray-500 shadow-inner focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 transition-all duration-200">
                    </div>

                    @if(request('search'))
                        <a href="{{ route('admin.supports.index') }}" class="inline-flex items-center justify-center rounded-2xl border border-gray-800 bg-gray-900 px-3.5 py-2.5 text-sm font-medium text-gray-400 hover:text-white hover:bg-gray-800 transition">
                            {{ __('پاکسازی') }}
                        </a>
                    @endif

                    <button type="submit" class="inline-flex items-center justify-center gap-1.5 rounded-2xl bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-cyan-500/25 hover:from-cyan-400 hover:to-blue-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/40 transition-all duration-200">
                        <span>{{ __('جستجو') }}</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ================= پیام‌های سیستم ================= --}}
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm font-medium text-emerald-400 backdrop-blur-md flex items-center gap-3">
            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- ================= جدول لیست پشتیبانی‌ها ================= --}}
    <div class="rounded-3xl border border-gray-800/80 bg-gray-950/70 shadow-2xl shadow-black/40 backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm">
                <thead>
                    <tr class="border-b border-gray-800/80 bg-gray-900/60 text-xs font-bold uppercase tracking-wider text-gray-400">
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">{{ __('کاربر و لایسنس') }}</th>
                        <th class="px-6 py-4">{{ __('شماره تلفن کاربر') }}</th>
                        <th class="px-6 py-4">{{ __('تاریخ شروع') }}</th>
                        <th class="px-6 py-4">{{ __('تاریخ انقضا') }}</th>
                        <th class="px-6 py-4 text-center">{{ __('وضعیت') }}</th>
                        <th class="px-6 py-4 text-left">{{ __('عملیات') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/50">
                    @forelse($supports as $support)
                        @php
                            $user = $support->user;
                            $subscription = $support->subscription;
                            $license = $subscription?->license;
                        @endphp
                        <tr class="hover:bg-gray-900/40 transition-colors">
                            {{-- شناسه --}}
                            <td class="px-6 py-4 font-mono text-xs text-gray-500">
                                #{{ $support->id }}
                            </td>

                            {{-- کاربر و لایسنس --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="font-bold text-gray-100">
                                        {{ $user?->name ?? __('کاربر نامشخص') }}
                                    </span>
                                    <span class="text-xs text-gray-400">
                                        {{ $user?->email ?? '—' }}
                                    </span>
                                    @if($license)
                                        <div class="mt-1 flex items-center gap-1 font-mono text-xs text-cyan-400 bg-cyan-950/40 border border-cyan-800/30 px-2 py-0.5 rounded-lg w-fit">
                                            <span>{{ $license->license_key }}</span>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            {{-- شماره تلفن کاربر --}}
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs font-medium text-gray-200 dir-ltr inline-block">
                                    {{ $user?->phone_number ?? '—' }}
                                </span>
                            </td>

                            {{-- شروع به شمسی --}}
                            <td class="px-6 py-4 font-mono text-xs text-gray-300">
                                {{ $support->starts_at_jalali }}
                            </td>

                            {{-- انقضا به شمسی --}}
                            <td class="px-6 py-4 font-mono text-xs">
                                <span class="{{ $support->is_expired ? 'text-rose-400 font-semibold' : 'text-emerald-400 font-semibold' }}">
                                    {{ $support->expires_at_jalali }}
                                </span>
                            </td>

                            {{-- وضعیت --}}
                            <td class="px-6 py-4 text-center">
                                @if($support->status === \App\Models\SubscriptionSupport::STATUS_ACTIVE && !$support->is_expired)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/30 px-3 py-1 text-xs font-semibold text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                        {{ __('فعال') }}
                                    </span>
                                @elseif($support->status === \App\Models\SubscriptionSupport::STATUS_CANCELLED)
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-800 border border-gray-700 px-3 py-1 text-xs font-semibold text-gray-400">
                                        {{ __('لغو شده') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/10 border border-rose-500/30 px-3 py-1 text-xs font-semibold text-rose-400">
                                        {{ __('منقضی شده') }}
                                    </span>
                                @endif
                            </td>

                            {{-- ستون عملیات مجزا --}}
                            <td class="px-6 py-4 text-left">
                                <div class="flex items-center justify-end gap-2">
                                    
                                    {{-- دکمه تمدید --}}
                                    <button @click.stop="openMenu($event, 'renew', {{ $support->id }}, '{{ route('admin.supports.renew', $support->id) }}')"
                                            type="button"
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-cyan-500/10 border border-cyan-500/30 px-3 py-1.5 text-xs font-semibold text-cyan-300 hover:bg-cyan-500 hover:text-white transition duration-150"
                                            title="{{ __('تمدید مدت پشتیبانی') }}">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        <span>{{ __('تمدید') }}</span>
                                        <svg class="h-3 w-3 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    {{-- دکمه وضعیت --}}
                                    <button @click.stop="openMenu($event, 'status', {{ $support->id }}, '{{ route('admin.supports.update-status', $support->id) }}')"
                                            type="button"
                                            class="inline-flex items-center gap-1.5 rounded-xl bg-indigo-500/10 border border-indigo-500/30 px-3 py-1.5 text-xs font-semibold text-indigo-300 hover:bg-indigo-500 hover:text-white transition duration-150"
                                            title="{{ __('تغییر وضعیت') }}">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <span>{{ __('وضعیت') }}</span>
                                        <svg class="h-3 w-3 opacity-70" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    {{-- دکمه حذف ساده با confirm مرورگر --}}
                                    <form action="{{ route('admin.supports.destroy', $support->id) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('{{ __('آیا از حذف این رکورد پشتیبانی اطمینان دارید؟') }}');"
                                          class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center rounded-xl bg-rose-500/10 border border-rose-500/30 p-1.5 text-rose-400 hover:bg-rose-500 hover:text-white transition duration-150"
                                                title="{{ __('حذف رکورد') }}">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <svg class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-base font-medium">{{ __('هیچ رکورد پشتیبانی یافت نشد.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- صفحه‌بندی --}}
        @if($supports->hasPages())
            <div class="border-t border-gray-800/80 bg-gray-900/40 p-4">
                {{ $supports->links() }}
            </div>
        @endif
    </div>

    {{-- ================= تک منوی شناور عمومی (تنها یک پاپ‌اور در کل DOM وجود دارد) ================= --}}
    <div x-show="activeMenu !== null"
         x-cloak
         @click.outside="closeMenu()"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         :style="`position: fixed; top: ${menuPos.top}px; left: ${menuPos.left}px; width: ${menuPos.width}px; z-index: 9999;`"
         class="rounded-2xl border border-gray-800 bg-gray-900/95 p-2 shadow-2xl backdrop-blur-2xl ring-1 ring-white/10 text-right">
        
        {{-- محتوای منوی تمدید --}}
        <template x-if="activeMenu === 'renew'">
            <div>
                <div class="px-2.5 py-1 text-[11px] font-bold text-cyan-400 border-b border-gray-800/80 mb-1">
                    {{ __('انتخاب مدت تمدید:') }}
                </div>
                
                <form :action="currentActionUrl" method="POST" class="space-y-1">
                    @csrf
                    <button type="submit" name="months" value="1" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-gray-200 hover:bg-cyan-500/15 hover:text-cyan-300 transition">
                        {{ __('۱ ماه') }}
                    </button>
                    <button type="submit" name="months" value="3" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-gray-200 hover:bg-cyan-500/15 hover:text-cyan-300 transition">
                        {{ __('۳ ماه') }}
                    </button>
                    <button type="submit" name="months" value="6" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-gray-200 hover:bg-cyan-500/15 hover:text-cyan-300 transition">
                        {{ __('۶ ماه') }}
                    </button>
                    <button type="submit" name="months" value="12" class="w-full text-right px-3 py-1.5 rounded-xl text-xs font-bold text-cyan-300 hover:bg-cyan-500/20 transition">
                        {{ __('۱۲ ماه (۱ سال)') }}
                    </button>
                    <button type="submit" name="months" value="24" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-gray-200 hover:bg-cyan-500/15 hover:text-cyan-300 transition">
                        {{ __('۲۴ ماه (۲ سال)') }}
                    </button>
                </form>
            </div>
        </template>

        {{-- محتوای منوی وضعیت --}}
        <template x-if="activeMenu === 'status'">
            <div>
                <div class="px-2.5 py-1 text-[11px] font-bold text-indigo-400 border-b border-gray-800/80 mb-1">
                    {{ __('تغییر وضعیت به:') }}
                </div>
                
                <form :action="currentActionUrl" method="POST" class="space-y-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" name="status" value="{{ \App\Models\SubscriptionSupport::STATUS_ACTIVE }}" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-emerald-400 hover:bg-emerald-500/15 transition">
                        {{ __('فعال') }}
                    </button>
                    <button type="submit" name="status" value="{{ \App\Models\SubscriptionSupport::STATUS_EXPIRED }}" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-rose-400 hover:bg-rose-500/15 transition">
                        {{ __('منقضی شده') }}
                    </button>
                    <button type="submit" name="status" value="{{ \App\Models\SubscriptionSupport::STATUS_CANCELLED }}" class="w-full text-right px-3 py-1.5 rounded-xl text-xs text-gray-400 hover:bg-gray-800 transition">
                        {{ __('لغو شده') }}
                    </button>
                </form>
            </div>
        </template>
    </div>

</div>

{{-- اسکریپت کنترل پنجره شناور واحد بدون امکان تداخل فیزیکی در DOM --}}
<script>
    function supportPageManager() {
        return {
            activeMenu: null,     // فقط مقدار 'renew' یا 'status' یا null
            activeId: null,       // شناسه رکورد
            currentActionUrl: '', // اکشن فرم
            menuPos: { top: -9999, left: -9999, width: 180 },

            openMenu(event, menuName, id, actionUrl) {
                // اگر روی همان دکمه کلیک شد، ببند
                if (this.activeMenu === menuName && this.activeId === id) {
                    this.closeMenu();
                    return;
                }

                this.activeMenu = menuName;
                this.activeId = id;
                this.currentActionUrl = actionUrl;

                const rect = event.currentTarget.getBoundingClientRect();
                const width = (menuName === 'renew') ? 180 : 160;
                const estimatedHeight = (menuName === 'renew') ? 220 : 145;

                // محاسبه مختصات دقیق روی محور عمودی
                const spaceBelow = window.innerHeight - rect.bottom;
                let topPos = rect.bottom + 6;
                if (spaceBelow < estimatedHeight && rect.top > estimatedHeight) {
                    topPos = rect.top - estimatedHeight - 6;
                }

                // محاسبه مختصات افقی با توجه به عرض صفحه
                let leftPos = rect.left;
                if (leftPos + width > window.innerWidth) {
                    leftPos = window.innerWidth - width - 16;
                }

                this.menuPos = {
                    top: Math.round(topPos),
                    left: Math.round(leftPos),
                    width: width
                };
            },

            closeMenu() {
                this.activeMenu = null;
                this.activeId = null;
                this.currentActionUrl = '';
                this.menuPos = { top: -9999, left: -9999, width: 180 };
            }
        };
    }
</script>
@endsection

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-100">
                    جزئیات اشتراک
                </h2>
                <p class="mt-1 text-sm text-gray-400">
                    مشاهده اطلاعات کامل اشتراک، پلن، لایسنس و پرداخت
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4 transition duration-300 group-hover:translate-x-1"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <span>بازگشت</span>
            </a>
        </div>
    </x-slot>

    @php
        $status = $subscription->status ?? 'inactive';
        $isActive = $status === 'active';

        $planTitle = $planTitle ?? ($subscription->plan->title ?? 'نامشخص');
        $planPeriodMonths = $planPeriodMonths ?? ($subscription->planPrice->duration_months ?? null);
        $licenseKey = $licenseKey ?? ($subscription->license->license_key ?? 'صادر نشده');

        $connectedDevicesCount = $connectedDevicesCount ?? ($subscription->license ? $subscription->license->devices->count() : 0);
        $maxAllowedDevices = $maxAllowedDevices ?? ($subscription->plan->max_devices ?? null);

        $price = $price ?? ($subscription->planPrice->price ?? 0);

        $subscriptionDurationDays = $subscriptionDurationDays ?? null;
        if ($subscriptionDurationDays === null && $subscription->started_at && $subscription->expires_at) {
            $subscriptionDurationDays = round(
                \Carbon\Carbon::parse($subscription->started_at)
                    ->diffInDays(\Carbon\Carbon::parse($subscription->expires_at))
            );
        }

        $remainingDays = $remainingDays ?? null;
        if ($remainingDays === null && $subscription->expires_at) {
            $remainingDays = round(now()->diffInDays(\Carbon\Carbon::parse($subscription->expires_at), false));
        }
    @endphp

    <div class="min-h-screen bg-[#070913] py-8 text-gray-100 sm:py-10">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl bg-[#0f1420] shadow-lg ring-1 ring-white/5">
                <div class="bg-gradient-to-r from-[#111827] via-[#0f172a] to-[#111827] px-5 py-6 sm:px-8 sm:py-8">
                    <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-500">
                                شناسه اشتراک
                            </p>
                            <h3 class="mt-1 font-mono text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                                #{{ $subscription->id + 1000 }}
                            </h3>
                        </div>

                        <div>
                            <span class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-bold tracking-wider
                                {{ $isActive
                                    ? 'bg-emerald-500/10 text-emerald-400'
                                    : 'bg-red-500/10 text-red-400'
                                }}">
                                <span class="h-2 w-2 rounded-full {{ $isActive ? 'bg-emerald-400' : 'bg-red-400' }}"></span>
                                {{ $isActive ? 'اشتراک فعال' : 'غیرفعال / منقضی' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <div class="space-y-6">
                            <div class="rounded-2xl bg-[#111827] p-5 ring-1 ring-white/5 sm:p-6">
                                <h4 class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500">
                                    اطلاعات پلن
                                </h4>

                                <div class="space-y-4">
                                    @foreach([
                                        ['نام پلن', $planTitle],
                                        ['بازه زمانی پلن', $planPeriodMonths ? $planPeriodMonths . ' ماهه' : 'نامشخص'],
                                        ['مدت زمان اشتراک', $subscriptionDurationDays !== null ? number_format($subscriptionDurationDays) . ' روز' : 'نامشخص'],
                                    ] as $item)
                                        <div class="flex items-center justify-between gap-4 border-t border-white/5 pt-4 first:border-none first:pt-0">
                                            <span class="text-sm text-gray-400">{{ $item[0] }}</span>
                                            <span class="text-left text-sm font-semibold text-white">{{ $item[1] }}</span>
                                        </div>
                                    @endforeach

                                    <div class="flex items-center justify-between gap-4 border-t border-white/5 pt-4">
                                        <span class="text-sm text-gray-400">روزهای باقی‌مانده</span>
                                        <span class="inline-flex items-center rounded-lg px-2.5 py-1 text-sm font-bold
                                            {{ $remainingDays !== null && $remainingDays >= 0 ? 'bg-emerald-500/10 text-emerald-400' : 'bg-red-500/10 text-red-400' }}">
                                            @if($remainingDays === null)
                                                نامشخص
                                            @elseif($remainingDays < 0)
                                                منقضی شده
                                            @else
                                                {{ number_format($remainingDays) }} روز
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-[#111827] p-5 ring-1 ring-white/5 sm:p-6">
                                <h4 class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500">
                                    بازه زمانی اشتراک
                                </h4>

                                <div class="space-y-4">
                                    @foreach([
                                        ['تاریخ شروع', $subscription->started_at],
                                        ['تاریخ انقضا', $subscription->expires_at],
                                        ['تاریخ ثبت اشتراک', $subscription->created_at],
                                    ] as $t)
                                        <div class="flex items-center justify-between gap-4 border-t border-white/5 pt-4 first:border-none first:pt-0">
                                            <span class="text-sm text-gray-400">{{ $t[0] }}</span>
                                            <span class="font-mono text-xs font-semibold text-gray-200">
                                                {{ $t[1] ? jdate($t[1])->format('Y/m/d H:i') : '—' }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="rounded-2xl bg-[#111827] p-5 ring-1 ring-white/5 sm:p-6">
                                <h4 class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500">
                                    اطلاعات لایسنس
                                </h4>

                                <div class="mb-5">
                                    <span class="mb-2 block text-xs text-gray-500">کد لایسنس</span>
                                    <div class="flex items-center justify-center gap-3 rounded-xl bg-[#0b1120] p-4 ring-1 ring-white/5">
                                        <code class="select-all break-all font-mono text-sm tracking-wide text-blue-300">
                                            {{ $licenseKey }}
                                        </code>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    @foreach([
                                        ['تعداد دستگاه‌های متصل', $connectedDevicesCount . ' دستگاه'],
                                        ['تعداد دستگاه‌های مجاز', ($maxAllowedDevices ?? 'نامشخص') . ' دستگاه'],
                                    ] as $li)
                                        <div class="flex items-center justify-between gap-4 border-t border-white/5 pt-4">
                                            <span class="text-sm text-gray-400">{{ $li[0] }}</span>
                                            <span class="text-sm font-semibold text-white">{{ $li[1] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-5">
                                    <a
                                        href="{{ route('user.devices.index') }}"
                                        class="group inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3.5 text-sm font-bold text-white shadow-xl shadow-blue-600/20 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/35 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 transition duration-300 group-hover:scale-110"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 13h16M5 5h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                            />
                                        </svg>
                                        <span>مدیریت دستگاه‌ها</span>
                                    </a>
                                </div>

                                <div class="mt-5 border-t border-white/5 pt-4">
                                    <div class="flex items-start gap-3 rounded-xl bg-blue-500/5 p-4 ring-1 ring-blue-400/10">
                                        <div class="rounded-lg bg-blue-500/10 p-2 text-blue-400">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-5 w-5"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                                />
                                            </svg>
                                        </div>

                                        <div>
                                            <p class="text-xs font-bold text-gray-200">اتصال دستگاه‌ها</p>
                                            <p class="mt-1 text-[11px] leading-5 text-gray-400">
                                                این لایسنس روی
                                                <span class="font-bold text-blue-400">{{ $connectedDevicesCount }}</span>
                                                دستگاه فعال است و تا سقف
                                                <span class="font-bold text-white">{{ $maxAllowedDevices }}</span>
                                                دستگاه را پشتیبانی می‌کند.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl bg-[#111827] p-5 ring-1 ring-white/5 sm:p-6">
                                <h4 class="mb-4 text-xs font-bold uppercase tracking-[0.2em] text-gray-500">
                                    اطلاعات پرداخت
                                </h4>

                                <div class="space-y-4">
                                    @foreach([
                                        ['مبلغ پرداخت‌شده', number_format($price) . ' تومان'],
                                        ['شناسه پرداخت', 'PAY-' . $subscription->id],
                                        ['روش پرداخت', 'پرداخت آنلاین'],
                                    ] as $pay)
                                        <div class="flex items-center justify-between gap-4 border-t border-white/5 pt-4 first:border-none first:pt-0">
                                            <span class="text-sm text-gray-400">{{ $pay[0] }}</span>
                                            <span class="text-sm font-semibold text-gray-200">{{ $pay[1] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl bg-amber-500/5 p-5 ring-1 ring-amber-400/10 sm:mt-8">
                        <div class="flex items-start gap-3.5">
                            <div class="mt-0.5 shrink-0 rounded-lg bg-amber-500/10 p-1.5 text-amber-400">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"
                                    />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-amber-300">نکته مهم</p>
                                <p class="mt-1 text-xs leading-6 text-gray-400">
                                    در صورت مشکل در فعال‌سازی لایسنس، ابتدا تاریخ انقضا و تعداد دستگاه‌ها را بررسی کنید.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3 bg-[#0c111b] px-5 py-5 sm:px-8">
                    @if(!$isActive)
                        <a
                            href="{{ route('shop') }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-6 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                        >
                            تمدید اشتراک
                        </a>
                    @endif

                    <button
                        type="button"
                        onclick="window.print()"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl border border-blue-800/70 bg-blue-900/20 px-6 py-3 text-sm font-bold text-blue-300 shadow-lg shadow-blue-950/10 transition duration-300 hover:-translate-y-0.5 hover:border-blue-700 hover:bg-blue-800/30 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-400/40"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 9V4h12v5M6 18h12v2H6zm-2-8h16a2 2 0 012 2v4H2v-4a2 2 0 012-2z"
                            />
                        </svg>
                        <span>دریافت رسید</span>
                    </button>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    برای پیگیری مسائل فنی از بخش
                    <a href="#" class="text-blue-400 transition-colors hover:text-blue-300 hover:underline">پشتیبانی</a>
                    اقدام کنید.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

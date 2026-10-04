<x-app-layout>

    <div
        x-cloak
        x-data="shopPlans({
            plans: @js($plans),
            upgradePlans: @js($upgradePlans),
            supportPackages: @js($supportPackages ?? []),
            hasSubscription: @js($hasSubscription),
            isTopPlan: @js($isTopPlan),
            currentPlan: @js($currentPlan),
            currentPlanLevel: @js($currentPlanLevel),
            isAuthenticated: @js(auth()->check()),
            loginUrl: @js(route('login')),
            cartStoreUrl: @js(route('user.cart.store')),
            currency: @js(__('shop_currency') ?? 'تومان'),
            errSelectPlan: @js(__('shop_err_select_plan') ?? 'لطفاً یک پلن را انتخاب کنید'),
            errSupportNotAvailable: @js(__('shop_err_support_not_available') ?? 'بسته پشتیبانی در دسترس نیست'),
            errUnknown: @js(__('shop_err_unknown') ?? 'خطایی رخ داد. لطفاً دوباره تلاش کنید.'),
            errCsrf: @js(__('shop_err_csrf') ?? 'نشست شما منقضی شده است. صفحه را رفرش کنید.')
        })"
        class="relative min-h-screen py-6 sm:py-10 overflow-hidden bg-gray-950 font-sans antialiased text-gray-100"
    >
        {{-- افکت‌های نوری محیطی --}}
        <div class="pointer-events-none fixed inset-0 overflow-hidden">
            <div class="absolute -top-40 right-1/4 h-96 w-96 rounded-full bg-blue-600/10 blur-[140px]"></div>
            <div class="absolute top-1/3 -left-20 h-96 w-96 rounded-full bg-sky-500/10 blur-[130px]"></div>
            <div class="absolute bottom-10 right-1/3 h-80 w-80 rounded-full bg-indigo-600/10 blur-[120px]"></div>
        </div>

        <div class="relative mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 space-y-8">
            {{-- باکس هدر --}}
            <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-4 sm:p-6 backdrop-blur-2xl shadow-2xl shadow-black/50">
                <div class="pointer-events-none absolute -top-12 left-1/2 -translate-x-1/2 h-32 w-80 rounded-full bg-blue-500/10 blur-3xl"></div>
                <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    {{-- دکمه بازگشت --}}
                    <div class="flex items-center justify-between sm:justify-start">
                        <a
                            href="{{ auth()->check() ? route('dashboard') : url('/') }}"
                            class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/25 ring-1 ring-white/15 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                        >
                            <svg class="h-4 w-4 rtl:rotate-0 ltr:rotate-180 transition duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>{{ __('shop_back_to_panel') ?? 'بازگشت به پنل' }}</span>
                        </a>

                        {{-- نمایش وضعیت در موبایل --}}
                        <div class="flex items-center gap-1.5 sm:hidden rounded-full border border-blue-500/20 bg-blue-500/10 px-3 py-1 text-[11px] font-medium text-blue-300">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                            </span>
                            <span>{{ __('shop_license_store') ?? 'فروشگاه لایسنس' }}</span>
                        </div>
                    </div>

                    {{-- عنوان و توضیحات --}}
                    <div class="text-start sm:text-center">
                        <div class="hidden sm:inline-flex items-center gap-2 mb-2 rounded-full border border-blue-500/20 bg-blue-500/10 px-3.5 py-1 text-xs font-semibold text-blue-300 shadow-inner">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                            </span>
                            <span>{{ __('shop_tariff_upgrade') ?? 'تعرفه‌ها و خدمات' }}</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-white">
                            {{ __('shop_title') ?? 'خدمات و لایسنس‌های' }}
                            <span class="bg-gradient-to-r from-blue-400 via-sky-300 to-blue-200 bg-clip-text text-transparent">AvaPark</span>
                        </h2>

                        <p class="mt-1.5 text-xs sm:text-sm text-gray-400 font-normal leading-relaxed">
                            {{ __('shop_subtitle') ?? 'پلن لایسنس یا خدمات پشتیبانی نرم‌افزار خود را انتخاب کنید.' }}
                        </p>
                    </div>

                    {{-- المان تضمین و فعال‌سازی فوری --}}
                    <div class="hidden sm:flex items-center justify-end">
                        <div class="inline-flex items-center gap-2.5 rounded-2xl border border-gray-800/80 bg-gray-900/70 px-4 py-2 text-xs text-gray-300 shadow-inner">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>

                            <div class="text-start leading-tight">
                                <p class="font-bold text-white text-[11px]">{{ __('shop_instant_activation') ?? 'فعال‌سازی آنی' }}</p>
                                <p class="text-[10px] text-gray-400">{{ __('shop_cloud_guarantee') ?? 'ضمانت و پشتیبانی رسمی' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- پیام‌های نشست (Session Alerts) --}}
            @if (session('success'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 px-5 py-4 text-xs sm:text-sm font-semibold text-emerald-400 backdrop-blur-xl shadow-lg shadow-emerald-950/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('warning'))
                <div class="flex items-center gap-3 rounded-2xl border border-amber-500/30 bg-amber-500/10 px-5 py-4 text-xs sm:text-sm font-semibold text-amber-400 backdrop-blur-xl shadow-lg shadow-amber-950/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center gap-3 rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-4 text-xs sm:text-sm font-semibold text-rose-400 backdrop-blur-xl shadow-lg shadow-rose-950/20">
                    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- پیام خطای جاوااسکریپت --}}
            <div
                x-show="errorMessage"
                x-transition
                x-text="errorMessage"
                class="rounded-2xl border border-rose-500/30 bg-rose-500/10 px-5 py-4 text-xs sm:text-sm font-bold text-rose-400"
            ></div>

            {{-- اگر کاربر اشتراک فعال دارد: انتخابگر دوگانه (پشتیبانی / ارتقا) --}}
            <template x-if="hasSubscription">
                <div class="space-y-8">
                    {{-- دکمه‌های سوئیچ بین حالت‌ها --}}
                    <div class="flex justify-center">
                        <div class="inline-flex p-1.5 rounded-2xl bg-gray-900/90 border border-gray-800/80 shadow-2xl backdrop-blur-xl gap-2">
                            <button
                                type="button"
                                @click="activeTab = 'support'"
                                :class="activeTab === 'support' ? 'bg-gradient-to-r from-blue-600 to-sky-500 text-white shadow-lg shadow-blue-500/30' : 'text-gray-400 hover:text-white hover:bg-gray-800/50'"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-300"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 0 018 0z" />
                                </svg>
                                <span>تمدید یا خرید پشتیبانی</span>
                            </button>

                            <button
                                type="button"
                                @click="activeTab = 'upgrade'"
                                :class="activeTab === 'upgrade' ? 'bg-gradient-to-r from-blue-600 to-sky-500 text-white shadow-lg shadow-blue-500/30' : 'text-gray-400 hover:text-white hover:bg-gray-800/50'"
                                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all duration-300"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                                <span>ارتقای پلن</span>
                            </button>
                        </div>
                    </div>

                    {{-- پشتیبانی (داینامیک از دیتابیس) --}}
                    <div x-show="activeTab === 'support'" x-transition class="space-y-6">
                        <div class="text-center">
                            <h3 class="text-2xl font-black text-white sm:text-3xl tracking-tight">تمدید و پشتیبانی فنی AvaPark</h3>
                            <p class="mt-2 text-xs sm:text-sm text-gray-400">
                                با تمدید بسته پشتیبانی، از دریافت آخرین آپدیت‌ها و خدمات پشتیبانی اختصاصی بهره‌مند شوید.
                            </p>
                        </div>

                        <template x-if="supportPackages.length === 0">
                            <div class="mx-auto max-w-2xl rounded-3xl border border-amber-500/30 bg-amber-500/10 p-8 text-center backdrop-blur-xl shadow-2xl">
                                <h3 class="text-lg sm:text-xl font-black text-white">در حال حاضر بسته پشتیبانی فعالی وجود ندارد</h3>
                                <p class="mt-2 text-xs sm:text-sm text-gray-300 leading-relaxed">
                                    لطفاً بعداً مراجعه کنید یا با پشتیبانی تماس بگیرید.
                                </p>
                            </div>
                        </template>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto"
                            :class="supportPackages.length === 1 ? 'md:grid-cols-1' : ''"
                        >
                            <template x-for="pkg in supportPackages" :key="pkg.id">
                                <div
                                    class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-900/50 p-7 shadow-xl shadow-black/30 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1.5 hover:border-blue-500/40 hover:bg-gray-900/80 hover:shadow-blue-950/20"
                                >
                                    <div class="pointer-events-none absolute inset-x-0 top-0 h-28 bg-gradient-to-b from-blue-500/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                                    <div>
                                        <div class="flex items-center justify-between gap-4 mb-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-black text-white" x-text="pkg.title"></h4>
                                                    <p class="text-xs text-gray-400">
                                                        <span x-text="toEn(pkg.duration_months)"></span>
                                                        <span> ماه پشتیبانی تخصصی</span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-6 h-px w-full bg-gradient-to-r from-blue-500/20 via-gray-700/60 to-transparent"></div>

                                        <ul class="space-y-3">
                                            <template x-if="Array.isArray(pkg.features) && pkg.features.length">
                                                <template x-for="feature in pkg.features" :key="feature">
                                                    <li class="flex items-start gap-3 text-xs sm:text-sm text-gray-300">
                                                        <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </div>
                                                        <span x-text="feature"></span>
                                                    </li>
                                                </template>
                                            </template>

                                            <template x-if="!Array.isArray(pkg.features) || pkg.features.length === 0">
                                                <li class="text-xs sm:text-sm text-gray-400">
                                                    امکانات این بسته هنوز ثبت نشده است.
                                                </li>
                                            </template>
                                        </ul>
                                    </div>

                                    <div class="mt-8 pt-6 border-t border-gray-800/60 flex flex-col gap-4">
                                        <div class="flex items-baseline justify-between">
                                            <span class="text-[11px] font-medium text-blue-400">
                                                دوره <span x-text="toEn(pkg.duration_months)"></span> ماهه
                                            </span>
                                            <div class="text-xl sm:text-2xl font-black text-white tracking-tight" x-text="formatPrice(pkg.price)"></div>
                                        </div>

                                        <button
                                            type="button"
                                            @click="buySupport(pkg)"
                                            :disabled="isSubmitting"
                                            class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 to-sky-500 px-5 py-3 text-xs sm:text-sm font-bold text-white shadow-lg shadow-blue-600/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 cursor-pointer disabled:opacity-50 text-center whitespace-nowrap"
                                        >
                                            <span x-text="isSubmitting && selectedSupportPackageId === pkg.id ? 'در حال افزودن...' : 'افزودن به سبد خرید'"></span>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- تب ۲: ارتقای پلن --}}
                    <div x-show="activeTab === 'upgrade'" x-transition class="space-y-6">
                        <template x-if="isTopPlan">
                            <div class="mx-auto max-w-2xl rounded-3xl border border-blue-500/30 bg-blue-500/10 p-8 text-center backdrop-blur-xl shadow-2xl">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-500/20 text-blue-400 border border-blue-500/30 mb-4">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-black text-white">پلن شما بالاترین سطح پلن‌های آواپارک است</h3>
                                <p class="mt-2 text-xs sm:text-sm text-gray-300 leading-relaxed">
                                    شما در حال حاضر دارای اشتراک سطح <span class="font-bold text-blue-300" x-text="currentPlan ? currentPlan.title : 'سازمانی'"></span> هستید و تمامی امکانات ویژه و اختصاصی سیستم برای شما فعال است.
                                </p>
                            </div>
                        </template>

                        <template x-if="!isTopPlan">
                            <div>
                                <div class="text-center mb-8">
                                    <h3 class="text-2xl font-black text-white sm:text-3xl tracking-tight">ارتقای سطح کاربری</h3>
                                    <p class="mt-2 text-xs sm:text-sm text-gray-400">
                                        پلن‌های دارای سطح بالاتر نسبت به پلن فعلی شما (<span class="text-blue-400 font-bold" x-text="currentPlan ? currentPlan.title : ''"></span>)
                                    </p>
                                </div>

                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                                    <template x-for="(plan, key) in upgradePlans" :key="plan.id">
                                        <div
                                            class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-900/50 p-7 shadow-xl shadow-black/30 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1.5 hover:border-blue-500/40 hover:bg-gray-900/80 hover:shadow-blue-950/20"
                                        >
                                            <div class="pointer-events-none absolute inset-x-0 top-0 h-28 bg-gradient-to-b from-blue-500/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                                            <template x-if="Number(plan.discount_percent) > 0">
                                                <div class="absolute end-6 top-6 z-10 flex items-center gap-1.5 rounded-xl border border-rose-500/40 bg-gradient-to-r from-rose-500/20 via-rose-600/25 to-orange-500/20 px-3 py-1 text-xs font-black text-rose-300 shadow-lg backdrop-blur-md">
                                                    <span class="flex h-2 w-2 rounded-full bg-rose-400 animate-pulse"></span>
                                                    <span x-text="toEn(plan.discount_percent) + '٪ تخفیف'"></span>
                                                </div>
                                            </template>

                                            <div>
                                                <div class="mb-5 flex items-start justify-between gap-4">
                                                    <div>
                                                        <h3 class="text-xl font-black text-white" x-text="plan.title"></h3>
                                                        <p class="mt-1.5 text-xs sm:text-sm leading-6 text-gray-400 min-h-[48px]" x-text="plan.description"></p>
                                                        
                                                        {{-- بج لایسنس مادام‌العمر دقیقاً پس از توضیحات --}}
                                                        <div class="mt-3">
                                                            <span class="inline-flex items-center gap-1.5 rounded-xl border border-blue-500/20 bg-blue-500/10 px-2.5 py-1 text-[11px] font-bold text-blue-300">
                                                                <svg class="h-3.5 w-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                                </svg>
                                                                <span>{{ __('shop_lifetime_license_badge') ?? 'لایسنس مادام‌العمر' }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-6 h-px w-full bg-gradient-to-r from-blue-500/20 via-gray-700/60 to-transparent"></div>

                                                <ul class="space-y-3">
                                                    <template x-for="facility in plan.facilities" :key="facility">
                                                        <li class="flex items-start gap-3 text-xs sm:text-sm text-gray-300">
                                                            <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            </div>
                                                            <span class="leading-6" x-text="facility"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </div>

                                            <div class="mt-8 pt-6 border-t border-gray-800/60 flex flex-col gap-4">
                                                <div class="flex items-baseline justify-between">
                                                    <span class="text-xs text-gray-400">قیمت نهایی:</span>
                                                    
                                                    {{-- حالت دارای تخفیف --}}
                                                    <template x-if="Number(plan.discount_percent) > 0">
                                                        <div class="flex items-baseline gap-2">
                                                            <div class="text-xl sm:text-2xl font-black text-emerald-400 tracking-tight" x-text="formatPrice(plan.price)"></div>
                                                            <div class="text-xs text-gray-500 line-through" x-text="formatPrice(plan.original_price)"></div>
                                                        </div>
                                                    </template>

                                                    {{-- حالت بدون تخفیف --}}
                                                    <template x-if="Number(plan.discount_percent) == 0">
                                                        <div class="text-xl sm:text-2xl font-black text-white tracking-tight" x-text="formatPrice(plan.price)"></div>
                                                    </template>
                                                </div>

                                                <button
                                                    type="button"
                                                    @click="buyPlan(plan)"
                                                    :disabled="isSubmitting"
                                                    class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-xs sm:text-sm font-bold text-white shadow-lg shadow-blue-600/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 cursor-pointer disabled:opacity-50 text-center whitespace-nowrap"
                                                >
                                                    <span x-text="isSubmitting && selectedPlanId === plan.id ? 'در حال افزودن...' : 'ارتقا به این پلن'"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- اگر کاربر اشتراک ندارد: نمایش تمام کارت‌های پلن اولیه --}}
            <template x-if="!hasSubscription">
                <div>
                    <div class="mb-8 text-center">
                        <h3 class="text-2xl font-black text-white sm:text-3xl tracking-tight">{{ __('shop_choose_plan_heading') ?? 'پلن مناسب خود را انتخاب کنید' }}</h3>
                        <p class="mt-2 text-xs sm:text-sm text-gray-400">
                            {{ __('shop_choose_plan_subheading') ?? 'لایسنس‌های نرم‌افزار آواپارک به صورت مادام‌العمر همراه با ۶ ماه پشتیبانی رایگان عرضه می‌شوند.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                        <template x-for="(plan, key) in plans" :key="plan.id">
                            <div
                                class="group relative flex flex-col justify-between overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-900/50 p-7 shadow-xl shadow-black/30 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1.5 hover:border-blue-500/40 hover:bg-gray-900/80 hover:shadow-blue-950/20"
                            >
                                <div class="pointer-events-none absolute inset-x-0 top-0 h-28 bg-gradient-to-b from-blue-500/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                                <template x-if="Number(plan.discount_percent) > 0">
                                    <div class="absolute end-6 top-6 z-10 flex items-center gap-1.5 rounded-xl border border-rose-500/40 bg-gradient-to-r from-rose-500/20 via-rose-600/25 to-orange-500/20 px-3 py-1 text-xs font-black text-rose-300 shadow-lg backdrop-blur-md">
                                        <span class="flex h-2 w-2 rounded-full bg-rose-400 animate-pulse"></span>
                                        <span x-text="toEn(plan.discount_percent) + '٪ ' + @js(__('shop_discount_off') ?? 'تخفیف')"></span>
                                    </div>
                                </template>

                                <div>
                                    <div class="mb-5 flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="text-xl font-black text-white" x-text="plan.title"></h3>
                                            <p class="mt-1.5 text-xs sm:text-sm leading-6 text-gray-400 min-h-[48px]" x-text="plan.description"></p>
                                            
                                            {{-- بج لایسنس مادام‌العمر دقیقاً پس از توضیحات --}}
                                            <div class="mt-3">
                                                <span class="inline-flex items-center gap-1.5 rounded-xl border border-blue-500/20 bg-blue-500/10 px-2.5 py-1 text-[11px] font-bold text-blue-300">
                                                    <svg class="h-3.5 w-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                    </svg>
                                                    <span>{{ __('shop_lifetime_license_badge') ?? 'لایسنس مادام‌العمر' }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-6 h-px w-full bg-gradient-to-r from-blue-500/20 via-gray-700/60 to-transparent"></div>

                                    <ul class="space-y-3">
                                        <template x-for="facility in plan.facilities" :key="facility">
                                            <li class="flex items-start gap-3 text-xs sm:text-sm text-gray-300">
                                                <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <span class="leading-6" x-text="facility"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>

                                <div class="mt-8 pt-6 border-t border-gray-800/60 flex flex-col gap-4">
                                    <div class="flex items-baseline justify-between">
                                        <span class="text-xs text-gray-400">قیمت نهایی:</span>

                                        {{-- حالت دارای تخفیف --}}
                                        <template x-if="Number(plan.discount_percent) > 0">
                                            <div class="flex items-baseline gap-2">
                                                <div class="text-xl sm:text-2xl font-black text-emerald-400 tracking-tight" x-text="formatPrice(plan.price)"></div>
                                                <div class="text-xs text-gray-500 line-through" x-text="formatPrice(plan.original_price)"></div>
                                            </div>
                                        </template>

                                        {{-- حالت بدون تخفیف --}}
                                        <template x-if="Number(plan.discount_percent) == 0">
                                            <div class="text-xl sm:text-2xl font-black text-white tracking-tight" x-text="formatPrice(plan.price)"></div>
                                        </template>
                                    </div>

                                    <button
                                        type="button"
                                        @click="buyPlan(plan)"
                                        :disabled="isSubmitting"
                                        class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-xs sm:text-sm font-bold text-white shadow-lg shadow-blue-600/30 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-blue-500/50 focus:outline-none focus:ring-2 focus:ring-blue-400/60 cursor-pointer disabled:opacity-50 text-center whitespace-nowrap"
                                    >
                                        <span x-text="isSubmitting && selectedPlanId === plan.id ? @js(__('shop_adding_to_cart') ?? 'در حال افزودن...') : @js(__('shop_select_plan_btn') ?? 'خرید لایسنس')"></span>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        {{-- فرم ارسال داده به روت سبد خرید --}}
        <form x-ref="cartForm" method="POST" :action="cartStoreUrl" class="hidden">
            @csrf
            <input type="hidden" name="type" :value="orderType">
            <input type="hidden" name="plan_id" :value="selectedPlanId">
            <input type="hidden" name="support_package_id" :value="selectedSupportPackageId">
            <input type="hidden" name="duration_months" :value="selectedDuration">
        </form>
    </div>

    <script>
        function shopPlans({
            plans,
            upgradePlans,
            supportPackages,
            hasSubscription,
            isTopPlan,
            currentPlan,
            currentPlanLevel,
            isAuthenticated,
            loginUrl,
            cartStoreUrl,
            currency = 'تومان',
            errSelectPlan = '',
            errSupportNotAvailable = '',
            errUnknown = '',
            errCsrf = ''
        }) {
            return {
                selectedPlanId: null,
                selectedSupportPackageId: null,
                selectedDuration: 0,

                orderType: 'plan',
                activeTab: 'support',

                errorMessage: '',
                isSubmitting: false,

                plans: Array.isArray(plans) ? plans : [],
                upgradePlans: Array.isArray(upgradePlans) ? upgradePlans : [],
                supportPackages: Array.isArray(supportPackages) ? supportPackages : [],

                hasSubscription: Boolean(hasSubscription),
                isTopPlan: Boolean(isTopPlan),
                currentPlan: currentPlan,
                currentPlanLevel: Number(currentPlanLevel) || 0,

                isAuthenticated,
                loginUrl,
                cartStoreUrl,
                currency,
                errSelectPlan,
                errSupportNotAvailable,
                errUnknown,
                errCsrf,

                toEn(str) {
                    return String(str ?? '')
                        .replace(/[۰-۹]/g, d => '0123456789'['۰۱۲۳۴۵۶۷۸۹'.indexOf(d)])
                        .replace(/[٠-٩]/g, d => '0123456789'['٠١٢٣٤٥٦٧٨٩'.indexOf(d)]);
                },

                formatPrice(price) {
                    const value = Number(price);
                    if (!Number.isFinite(value)) return '0 ' + this.currency;
                    return value.toLocaleString('en-US') + ' ' + this.currency;
                },

                async submitCart() {
                    const form = this.$refs.cartForm;
                    const fd = new FormData(form);

                    try {
                        const res = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: fd,
                        });

                        if (res.status === 419) {
                            this.errorMessage = this.errCsrf || 'نشست منقضی شد. صفحه را رفرش کنید.';
                            this.isSubmitting = false;
                            return;
                        }

                        if (!res.ok) {
                            let data = null;
                            try { data = await res.json(); } catch (e) {}

                            if (data?.message) {
                                this.errorMessage = data.message;
                            } else if (data?.errors) {
                                const firstKey = Object.keys(data.errors)[0];
                                this.errorMessage = data.errors[firstKey]?.[0] ?? this.errUnknown;
                            } else {
                                this.errorMessage = this.errUnknown;
                            }

                            this.isSubmitting = false;
                            return;
                        }

                        let data = null;
                        try { data = await res.json(); } catch (e) {}

                        if (data?.redirect) {
                            window.location.href = data.redirect;
                            return;
                        }

                        window.location.href = @js(route('user.cart.index'));
                    } catch (e) {
                        this.errorMessage = this.errUnknown || 'خطای شبکه/سرور';
                        this.isSubmitting = false;
                    }
                },

                buyPlan(plan) {
                    if (this.isSubmitting) return;

                    if (!this.isAuthenticated) {
                        window.location.href = this.loginUrl;
                        return;
                    }

                    if (!plan || !plan.id) {
                        this.errorMessage = this.errSelectPlan;
                        return;
                    }

                    this.errorMessage = '';
                    this.orderType = 'plan';

                    this.selectedPlanId = plan.id;
                    this.selectedSupportPackageId = null;
                    this.selectedDuration = 0;

                    this.isSubmitting = true;

                    this.$nextTick(() => this.submitCart());
                },

                buySupport(pkg) {
                    if (this.isSubmitting) return;

                    if (!this.isAuthenticated) {
                        window.location.href = this.loginUrl;
                        return;
                    }

                    if (!pkg || !pkg.id) {
                        this.errorMessage = this.errSupportNotAvailable;
                        return;
                    }

                    this.errorMessage = '';
                    this.orderType = 'support';

                    this.selectedPlanId = null;
                    this.selectedSupportPackageId = pkg.id;
                    this.selectedDuration = Number(pkg.duration_months) || 0;

                    this.isSubmitting = true;

                    this.$nextTick(() => this.submitCart());
                }
            };
        }
    </script>

</x-app-layout>

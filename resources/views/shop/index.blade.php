<x-app-layout>

    <div
        x-cloak
        x-data="shopPlans({
            plans: @js($plans),
            isAuthenticated: @js(auth()->check()),
            loginUrl: @js(route('login')),
            cartStoreUrl: @js(route('user.cart.store')),
            currency: @js(__('shop_currency')),
            monthsSuffix: @js(__('shop_months')),
            errSelectPlan: @js(__('shop_err_select_plan')),
            errSelectDuration: @js(__('shop_err_select_duration')),
            errInvalidDuration: @js(__('shop_err_invalid_duration'))
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
            {{-- باکس هدر که همراه با اسکرول بالا رفته و مخفی می‌شود --}}
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
                            <span>{{ __('shop_back_to_panel') }}</span>
                        </a>

                        {{-- نمایش وضعیت در موبایل --}}
                        <div class="flex items-center gap-1.5 sm:hidden rounded-full border border-blue-500/20 bg-blue-500/10 px-3 py-1 text-[11px] font-medium text-blue-300">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                            </span>
                            <span>{{ __('shop_license_store') }}</span>
                        </div>
                    </div>

                    {{-- عنوان و توضیحات --}}
                    <div class="text-start sm:text-center">
                        <div class="hidden sm:inline-flex items-center gap-2 mb-2 rounded-full border border-blue-500/20 bg-blue-500/10 px-3.5 py-1 text-xs font-semibold text-blue-300 shadow-inner">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-500"></span>
                            </span>
                            <span>{{ __('shop_tariff_upgrade') }}</span>
                        </div>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight text-white">
                            {{ __('shop_title') }}
                            <span class="bg-gradient-to-r from-blue-400 via-sky-300 to-blue-200 bg-clip-text text-transparent">AvaPark</span>
                        </h2>

                        <p class="mt-1.5 text-xs sm:text-sm text-gray-400 font-normal leading-relaxed">
                            {{ __('shop_subtitle') }}
                        </p>
                    </div>

                    {{-- المان تضمین و اعتبار شیشه‌ای --}}
                    <div class="hidden sm:flex items-center justify-end">
                        <div class="inline-flex items-center gap-2.5 rounded-2xl border border-gray-800/80 bg-gray-900/70 px-4 py-2 text-xs text-gray-300 shadow-inner">
                            <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>

                            <div class="text-start leading-tight">
                                <p class="font-bold text-white text-[11px]">{{ __('shop_instant_activation') }}</p>
                                <p class="text-[10px] text-gray-400">{{ __('shop_cloud_guarantee') }}</p>
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

            {{-- استپر تعاملی مدرن --}}
            <div>
                <div class="mx-auto flex max-w-xl items-center justify-between rounded-3xl border border-gray-800/80 bg-gray-900/60 p-3 sm:p-4 backdrop-blur-2xl shadow-xl shadow-black/40">
                    {{-- مرحله اول --}}
                    <div class="flex items-center gap-3 pe-2 sm:pe-4">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl text-xs font-black transition-all duration-300"
                            :class="step === 1
                                ? 'bg-gradient-to-tr from-blue-600 to-sky-400 text-white shadow-lg shadow-blue-500/30 ring-2 ring-blue-400/30'
                                : 'bg-emerald-500/15 text-emerald-400 border border-emerald-500/30'"
                        >
                            <template x-if="step === 1">
                                <span>1</span>
                            </template>

                            <template x-if="step !== 1">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </template>
                        </div>

                        <div class="text-start">
                            <p class="text-xs sm:text-sm font-bold text-white tracking-tight">{{ __('shop_step1_title') }}</p>
                            <p class="text-[11px] text-gray-400">{{ __('shop_step1_desc') }}</p>
                        </div>
                    </div>

                    {{-- خط متصل‌کننده متحرک --}}
                    <div class="mx-3 sm:mx-6 h-0.5 flex-1 rounded-full overflow-hidden bg-gray-800">
                        <div
                            class="h-full bg-gradient-to-r from-blue-500 to-sky-400 transition-all duration-500"
                            :class="step === 2 ? 'w-full' : 'w-0'"
                        ></div>
                    </div>

                    {{-- مرحله دوم --}}
                    <div class="flex items-center gap-3 ps-2 sm:ps-4">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl text-xs font-black transition-all duration-300"
                            :class="step === 2
                                ? 'bg-gradient-to-tr from-blue-600 to-sky-400 text-white shadow-lg shadow-blue-500/30 ring-2 ring-blue-400/30'
                                : 'bg-gray-800/80 text-gray-400 border border-gray-700/60'"
                        >
                            <span>2</span>
                        </div>

                        <div class="text-start">
                            <p class="text-xs sm:text-sm font-bold" :class="step === 2 ? 'text-white' : 'text-gray-400'">{{ __('shop_step2_title') }}</p>
                            <p class="text-[11px] text-gray-500">{{ __('shop_step2_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- گام ۱: نمایش کارت‌های پلن --}}
            <div
                x-show="step === 1"
                x-transition:leave="transition-opacity ease-out duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-black text-white sm:text-3xl tracking-tight">{{ __('shop_choose_plan_heading') }}</h3>
                    <p class="mt-2 text-xs sm:text-sm text-gray-400">
                        {{ __('shop_choose_plan_subheading') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <template x-for="(plan, key) in plans" :key="plan.id">
                        <div
                            @click="selectPlan(key)"
                            class="group relative flex flex-col justify-between cursor-pointer overflow-hidden rounded-3xl border p-7 shadow-xl shadow-black/30 backdrop-blur-xl transition-all duration-300 hover:-translate-y-1.5"
                            :class="selectedPlan === key
                                ? 'border-blue-500 bg-gradient-to-b from-blue-950/40 via-gray-900/90 to-gray-950 ring-1 ring-blue-500/50 shadow-blue-950/30'
                                : 'border-gray-800/80 bg-gray-900/50 hover:border-blue-500/40 hover:bg-gray-900/80 hover:shadow-blue-950/20'"
                        >
                            {{-- افکت درخشش هاور --}}
                            <div class="pointer-events-none absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-blue-500/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>

                            <div>
                                <div class="mb-5 flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-xl font-black text-white" x-text="plan.title"></h3>
                                        <p class="mt-1.5 text-xs sm:text-sm leading-6 text-gray-400 min-h-[48px]" x-text="plan.description"></p>
                                    </div>

                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-2xl border transition-all duration-300"
                                        :class="selectedPlan === key
                                            ? 'border-blue-400 bg-blue-500/20 text-blue-300 shadow-md shadow-blue-500/20'
                                            : 'border-gray-700/80 bg-gray-800/80 text-gray-400 group-hover:border-blue-500/40 group-hover:text-blue-300'"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="mb-6 h-px w-full bg-gradient-to-r from-blue-500/20 via-gray-700/60 to-transparent"></div>

                                {{-- لیست امکانات --}}
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

                            <div class="mt-8 pt-6 border-t border-gray-800/60 flex items-center justify-between gap-4">
                                <span class="text-xs font-medium text-gray-500">
                                    {{ __('shop_view_prices') }}
                                </span>

                                <span
                                    class="inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-2xl bg-gradient-to-r px-4 py-2.5 text-xs sm:text-sm font-bold text-white shadow-lg transition-all duration-300"
                                    :class="selectedPlan === key
                                        ? 'from-blue-600 via-blue-500 to-sky-500 shadow-blue-600/30'
                                        : 'from-blue-600/90 via-blue-500/90 to-sky-500/90 shadow-blue-900/20 group-hover:shadow-blue-500/30'"
                                >
                                    {{ __('shop_select_plan_btn') }}

                                    <svg class="h-4 w-4 rtl:rotate-0 ltr:rotate-180 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- گام ۲: انتخاب مدت زمان اشتراک --}}
            <div
                x-show="step === 2"
                x-transition:enter="transition-all ease-[cubic-bezier(0.16,1,0.3,1)] duration-500"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="mx-auto max-w-4xl"
            >
                <div class="overflow-hidden rounded-3xl border border-gray-800/90 bg-gray-900/60 backdrop-blur-2xl shadow-2xl shadow-black/40">
                    {{-- هدر باکس گام ۲ --}}
                    <div class="border-b border-gray-800/80 bg-gradient-to-r from-gray-900 via-gray-900/95 to-blue-950/30 px-6 py-6 sm:px-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <span class="inline-block rounded-lg bg-blue-500/10 border border-blue-500/20 px-2.5 py-1 text-[11px] font-bold text-blue-400 mb-2">
                                    {{ __('shop_step2_badge') }}
                                </span>

                                <h3 class="text-xl font-black text-white sm:text-2xl tracking-tight">{{ __('shop_choose_duration_heading') }}</h3>

                                <p class="mt-1 text-xs sm:text-sm text-gray-400">
                                    {{ __('shop_selected_plan_label') }}
                                    <span
                                        class="font-bold text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2 py-0.5 rounded-lg ms-1"
                                        x-text="currentPlan()?.title"
                                    ></span>
                                </p>
                            </div>

                            <button
                                @click="changePlan()"
                                type="button"
                                class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-xl shadow-blue-600/-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19/60 cursor-pointer"
                            >
                                <svg class="h-4 w-4 rtl:rotate-0 ltr:rotate-180 transition duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>

                                <span>{{ __('shop_change_plan_btn') }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- بدنه انتخاب دوره‌ها --}}
                    <div class="px-6 py-6 sm:px-8 sm:py-8">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <template x-for="duration in currentPlan()?.prices || []" :key="duration.id">
                                <button
                                    type="button"
                                    @click="selectDuration(duration.id)"
                                    class="group relative overflow-hidden rounded-3xl border p-6 text-start transition-all duration-300 hover:-translate-y-1 cursor-pointer w-full"
                                    :class="selectedDuration === duration.id
                                        ? 'border-blue-500 bg-gradient-to-br from-blue-600/15 via-gray-900/90 to-gray-950 shadow-xl shadow-blue-950/40 ring-1 ring-blue-500/50'
                                        : 'border-gray-800/80 bg-gray-950/40 hover:border-gray-700 hover:bg-gray-900/80'"
                                >
                                    {{-- تگ تخفیف --}}
                                    <template x-if="duration.discount_percent > 0">
                                        <div class="absolute end-4 top-4 flex items-center gap-1.5 rounded-xl border border-rose-500/40 bg-gradient-to-r from-rose-500/20 via-rose-600/25 to-orange-500/20 px-3 py-1.5 text-xs font-black text-rose-300 shadow-lg shadow-rose-950/40 backdrop-blur-md">
                                            <span class="flex h-2 w-2 rounded-full bg-rose-400 animate-pulse"></span>
                                            <span x-text="toEn(duration.discount_percent) + ' ' + @js(__('shop_discount_off'))"></span>
                                        </div>
                                    </template>

                                    {{-- آیکون تیک انتخاب --}}
                                    <div
                                        class="absolute start-4 top-4 flex h-7 w-7 items-center justify-center rounded-full border transition-all duration-300"
                                        :class="selectedDuration === duration.id
                                            ? 'border-blue-400 bg-blue-500 text-white shadow-md shadow-blue-500/50'
                                            : 'border-gray-700 bg-gray-800 text-transparent group-hover:border-gray-600'"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>

                                    <div class="ps-10">
                                        <h4 class="text-base sm:text-lg font-black text-white" x-text="toEn(duration.duration_months) + ' ' + monthsSuffix"></h4>

                                        <p class="mt-1 text-xs text-gray-400">
                                            {{ __('shop_duration_desc') }}
                                        </p>

                                        {{-- نمایش قیمت‌ها --}}
                                        <div class="mt-5 pt-3 border-t border-gray-800/60">
                                            <template x-if="duration.discount_percent > 0">
                                                <div class="flex items-baseline gap-2">
                                                    <div
                                                        class="text-xl sm:text-2xl font-black text-emerald-400 tracking-tight"
                                                        x-text="formatPrice(getFinalPrice(duration.price, duration.discount_percent))"
                                                    ></div>

                                                    <div
                                                        class="text-xs text-gray-500 line-through"
                                                        x-text="formatPrice(duration.price)"
                                                    ></div>
                                                </div>
                                            </template>

                                            <template x-if="duration.discount_percent == 0">
                                                <div
                                                    class="text-xl sm:text-2xl font-black text-white tracking-tight"
                                                    x-text="formatPrice(duration.price)"
                                                ></div>
                                            </template>
                                        </div>
                                    </div>
                                </button>
                            </template>
                        </div>

                        {{-- بخش اکشن و دکمه پرداخت --}}
                        <div class="mt-8 border-t border-gray-800/80 pt-6">
                            <p
                                x-show="errorMessage"
                                x-transition
                                x-text="errorMessage"
                                class="mb-4 rounded-xl border border-rose-500/30 bg-rose-500/10 px-4 py-3 text-xs sm:text-sm font-bold text-rose-400"
                            ></p>

                            <div class="flex flex-col-reverse gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-xs text-gray-400">
                                    <template x-if="selectedDuration">
                                        <span>
                                            {{ __('shop_selected_period') }}
                                            <strong
                                                class="text-white font-bold"
                                                x-text="' ' + toEn(selectedDurationObject()?.duration_months) + ' ' + monthsSuffix"
                                            ></strong>

                                            &nbsp;|&nbsp;

                                            {{ __('shop_payable_amount') }}

                                            <strong
                                                class="text-emerald-400 text-sm font-black"
                                                x-text="selectedDurationObject() ? formatPrice(getFinalPrice(selectedDurationObject().price, selectedDurationObject().discount_percent)) : '-'"
                                            ></strong>
                                        </span>
                                    </template>

                                    <template x-if="!selectedDuration">
                                        <span>{{ __('shop_select_period_hint') }}</span>
                                    </template>
                                </div>

                                <button
                                    @click="addToCart()"
                                    type="button"
                                    :disabled="isSubmitting"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl px-8 py-3.5 text-xs sm:text-sm font-bold text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400/60 cursor-pointer"
                                    :class="selectedDuration && !isSubmitting
                                        ? 'bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 shadow-xl shadow-blue-600/30 hover:-translate-y-0.5 hover:shadow-blue-500/50'
                                        : 'cursor-not-allowed bg-gray-800 text-gray-500 opacity-60 shadow-none'"
                                >
                                    <svg
                                        x-show="!isSubmitting"
                                        class="h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path>
                                    </svg>

                                    <svg
                                        x-cloak
                                        x-show="isSubmitting"
                                        class="h-4 w-4 animate-spin text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>

                                    <span x-text="isSubmitting ? @js(__('shop_adding_to_cart')) : @js(__('shop_add_to_cart'))"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- فرم ارسال داده به روت سبد خرید --}}
        <form x-ref="cartForm" method="POST" :action="cartStoreUrl" class="hidden">
            @csrf
            <input type="hidden" name="plan_id" :value="selectedPlanId()">
            <input type="hidden" name="duration_months" :value="selectedDurationMonths()">
        </form>
    </div>

    <script>
        function shopPlans({
            plans,
            isAuthenticated,
            loginUrl,
            cartStoreUrl,
            currency = 'تومان',
            monthsSuffix = 'ماهه',
            errSelectPlan = '',
            errSelectDuration = '',
            errInvalidDuration = ''
        }) {
            /*
             * بهینه‌سازی:
             * - ساخت Index برای پلن‌ها
             * - ساخت Map برای durationها
             * - حذف find()های تکراری
             * - Cache کردن پلن و duration انتخاب‌شده
             * - جلوگیری از submit دوباره
             * - اصلاح تبدیل اعداد فارسی و عربی
             */

            const planList = Array.isArray(plans) ? plans : [];

            planList.forEach(plan => {
                const durationMap = Object.create(null);

                if (Array.isArray(plan.prices)) {
                    plan.prices.forEach(duration => {
                        durationMap[String(duration.id)] = duration;
                    });
                }

                plan._durationMap = durationMap;
            });

            return {
                selectedPlan: null,
                selectedDuration: null,
                step: 1,
                errorMessage: '',
                isSubmitting: false,

                plans: planList,
                isAuthenticated,
                loginUrl,
                cartStoreUrl,
                currency,
                monthsSuffix,
                errSelectPlan,
                errSelectDuration,
                errInvalidDuration,

                _currentPlan: null,
                _selectedDurationObject: null,

                toEn(str) {
                    return String(str ?? '')
                        .replace(/[۰-۹]/g, d =>
                            '0123456789'['۰۱۲۳۴۵۶۷۸۹'.indexOf(d)]
                        )
                        .replace(/[٠-٩]/g, d =>
                            '0123456789'['٠١٢٣٤٥٦٧٨٩'.indexOf(d)]
                        );
                },

                formatPrice(price) {
                    const value = Number(price);

                    if (!Number.isFinite(value)) {
                        return '0 ' + this.currency;
                    }

                    return value.toLocaleString('en-US') + ' ' + this.currency;
                },

                getFinalPrice(price, discount) {
                    return Math.round(
                        Number(price) -
                        ((Number(price) * Number(discount)) / 100)
                    );
                },

                currentPlan() {
                    return this._currentPlan;
                },

                selectedPlanId() {
                    return this._currentPlan ? this._currentPlan.id : '';
                },

                selectedDurationObject() {
                    return this._selectedDurationObject;
                },

                selectedDurationMonths() {
                    return this._selectedDurationObject
                        ? this._selectedDurationObject.duration_months
                        : '';
                },

                selectPlan(key) {
                    this.selectedPlan = key;
                    this.selectedDuration = null;
                    this.errorMessage = '';

                    this._currentPlan = this.plans[key] ?? null;
                    this._selectedDurationObject = null;

                    this.step = 2;

                    this.$nextTick(() => {
                        requestAnimationFrame(() => {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        });
                    });
                },

                changePlan() {
                    this.step = 1;
                    this.selectedPlan = null;
                    this.selectedDuration = null;
                    this.errorMessage = '';

                    this._currentPlan = null;
                    this._selectedDurationObject = null;

                    this.$nextTick(() => {
                        requestAnimationFrame(() => {
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        });
                    });
                },

                selectDuration(durationId) {
                    this.selectedDuration = durationId;
                    this.errorMessage = '';

                    const plan = this._currentPlan;

                    this._selectedDurationObject =
                        plan?._durationMap?.[String(durationId)] ?? null;
                },

                addToCart() {
                    if (this.isSubmitting) {
                        return;
                    }

                    if (!this.isAuthenticated) {
                        window.location.href = this.loginUrl;
                        return;
                    }

                    if (!this._currentPlan) {
                        this.errorMessage = this.errSelectPlan;
                        return;
                    }

                    if (!this.selectedDuration) {
                        this.errorMessage = this.errSelectDuration;
                        return;
                    }

                    if (!this._selectedDurationObject) {
                        this.errorMessage = this.errInvalidDuration;
                        return;
                    }

                    this.errorMessage = '';
                    this.isSubmitting = true;

                    this.$nextTick(() => {
                        requestAnimationFrame(() => {
                            this.$refs.cartForm.submit();
                        });
                    });
                }
            };
        }
    </script>

</x-app-layout>

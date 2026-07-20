<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <a
                    href="{{ auth()->check() ? route('dashboard') : url('/') }}"
                    class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                >
                    <svg class="h-4 w-4 transition duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>بازگشت</span>
                </a>
            </div>

            <div class="flex-1 text-center">
                <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                    انتخاب اشتراک ProPark
                </h2>
                <p class="mt-1 text-xs text-gray-400 sm:text-sm">
                    پلن مناسب خود را انتخاب کنید و اشتراک‌تان را فعال کنید
                </p>
            </div>

            <div class="hidden w-[132px] sm:block"></div>
        </div>
    </x-slot>

    <div
        x-data="shopPlans({
            plans: @js($plans),
            isAuthenticated: @js(auth()->check()),
            loginUrl: @js(route('login')),
            cartStoreUrl: @js(route('user.cart.store')),
        })"
        class="min-h-screen py-10 sm:py-12"
        dir="rtl"
    >
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-3 text-sm font-medium text-emerald-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-6 rounded-2xl border border-amber-500/20 bg-amber-500/10 px-4 py-3 text-sm font-medium text-amber-400">
                    {{ session('warning') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm font-medium text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-8 sm:mb-10">
                <div class="mx-auto flex max-w-2xl items-center justify-center gap-3 sm:gap-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border text-sm font-bold transition-all duration-300"
                            :class="step === 1
                                ? 'border-blue-500 bg-blue-500/20 text-blue-300 shadow-lg shadow-blue-900/20'
                                : 'border-green-500/40 bg-green-500/10 text-green-400'"
                        >
                            <template x-if="step === 1">
                                <span>1</span>
                            </template>

                            <template x-if="step !== 1">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </template>
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-white">انتخاب پلن</p>
                            <p class="text-xs text-gray-400">نوع اشتراک را مشخص کنید</p>
                        </div>
                    </div>

                    <div class="h-px w-10 bg-gradient-to-r from-blue-500/30 to-gray-700 sm:w-16"></div>

                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-full border text-sm font-bold transition-all duration-300"
                            :class="step === 2
                                ? 'border-blue-500 bg-blue-500/20 text-blue-300 shadow-lg shadow-blue-900/20'
                                : 'border-gray-700 bg-gray-900 text-gray-400'"
                        >
                            2
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-semibold text-white">انتخاب بازه زمانی</p>
                            <p class="text-xs text-gray-400">مدت اشتراک را تعیین کنید</p>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="step === 1" x-transition.opacity.duration.300ms>
                <div class="mb-8 text-center">
                    <h3 class="text-2xl font-bold text-white">پلن مناسب خود را انتخاب کنید</h3>
                    <p class="mt-2 text-sm text-gray-400">
                        هر پلن بر اساس نیاز شما طراحی شده است. برای ادامه یکی را انتخاب کنید.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    <template x-for="(plan, key) in plans" :key="plan.id">
                        <div
                            @click="selectPlan(key)"
                            class="group relative cursor-pointer overflow-hidden rounded-3xl border bg-gray-900/50 p-7 shadow-xl shadow-black/10 transition-all duration-300 hover:-translate-y-1 hover:border-blue-500/40 hover:bg-gray-900/80 hover:shadow-blue-950/10"
                            :class="selectedPlan === key
                                ? 'border-blue-500 bg-gradient-to-b from-blue-500/10 to-gray-900/90 ring-1 ring-blue-500/30'
                                : 'border-gray-800'"
                        >
                            <div class="pointer-events-none absolute inset-x-0 top-0 h-24 bg-gradient-to-b from-blue-500/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                            <div class="pointer-events-none absolute -bottom-10 -left-10 h-32 w-32 rounded-full bg-blue-500/5 blur-3xl"></div>

                            <div class="relative">
                                <div class="mb-5 flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-white" x-text="plan.title"></h3>
                                        <p class="mt-1 text-sm leading-6 text-gray-400" x-text="plan.description"></p>
                                    </div>

                                    <div
                                        class="flex h-10 w-10 items-center justify-center rounded-2xl border transition-all duration-300"
                                        :class="selectedPlan === key
                                            ? 'border-blue-400 bg-blue-500/20 text-blue-300'
                                            : 'border-gray-700 bg-gray-800 text-gray-400 group-hover:border-blue-500/30 group-hover:text-blue-300'"
                                    >
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>

                                <div class="mb-6 h-px w-full bg-gradient-to-r from-blue-500/20 via-gray-700 to-transparent"></div>

                                <ul class="space-y-3.5">
                                    <template x-for="facility in plan.facilities" :key="facility">
                                        <li class="flex items-start gap-3 text-sm text-gray-300">
                                            <div class="mt-0.5 flex h-5 w-5 items-center justify-center rounded-full bg-blue-500/10 text-blue-400">
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                            <span class="leading-6" x-text="facility"></span>
                                        </li>
                                    </template>
                                </ul>

                                <div class="mt-8 flex items-center justify-between gap-4">
                                    <span class="text-xs font-medium text-gray-500">
                                        برای مشاهده قیمت‌ها کلیک کنید
                                    </span>

                                    <span
                                        class="inline-flex shrink-0 items-center justify-center gap-2 whitespace-nowrap rounded-2xl bg-gradient-to-r px-4 py-3 text-sm font-bold text-white shadow-lg transition-all duration-300"
                                        :class="selectedPlan === key
                                            ? 'from-blue-600 via-blue-500 to-sky-500 shadow-blue-600/30'
                                            : 'from-blue-600/90 via-blue-500/90 to-sky-500/90 shadow-blue-900/20 group-hover:shadow-blue-500/30'"
                                    >
                                        انتخاب پلن
                                        <svg class="h-4 w-4 transition duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div x-show="step === 2" x-transition.opacity.duration.300ms class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/50 shadow-2xl shadow-black/20">
                    <div class="border-b border-gray-800 bg-gradient-to-r from-gray-900 via-gray-900 to-blue-950/20 px-6 py-6 sm:px-8">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-blue-400">
                                    مرحله دوم
                                </p>
                                <h3 class="text-xl font-bold text-white sm:text-2xl">مدت زمان اشتراک را انتخاب کنید</h3>
                                <p class="mt-2 text-sm text-gray-400">
                                    پلن انتخاب‌شده:
                                    <span class="font-bold text-blue-300" x-text="currentPlan()?.title"></span>
                                </p>
                            </div>

                            <button
                                @click="changePlan()"
                                type="button"
                                class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                            >
                                <svg class="h-4 w-4 transition duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span>تغییر پلن</span>
                            </button>
                        </div>
                    </div>

                    <div class="px-6 py-6 sm:px-8 sm:py-8">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <template x-for="duration in currentPlan()?.prices || []" :key="duration.id">
                                <button
                                    type="button"
                                    @click="selectDuration(duration.id)"
                                    class="group relative overflow-hidden rounded-3xl border p-6 text-right transition-all duration-300 hover:-translate-y-0.5"
                                    :class="selectedDuration === duration.id
                                        ? 'border-blue-500 bg-gradient-to-br from-blue-500/10 to-gray-900 shadow-lg shadow-blue-950/20 ring-1 ring-blue-500/20'
                                        : 'border-gray-800 bg-gray-950/40 hover:border-blue-500/30 hover:bg-gray-900/70'"
                                >
                                    <template x-if="duration.discount_percent > 0">
                                        <span class="absolute left-4 top-4 rounded-full border border-red-500/30 bg-red-500/15 px-2.5 py-1 text-[11px] font-bold text-red-400">
                                            <span x-text="duration.discount_percent + '٪ تخفیف'"></span>
                                        </span>
                                    </template>

                                    <div
                                        class="absolute right-4 top-4 flex h-7 w-7 items-center justify-center rounded-full border transition-all duration-300"
                                        :class="selectedDuration === duration.id
                                            ? 'border-blue-400 bg-blue-500/20 text-blue-300'
                                            : 'border-gray-700 bg-gray-800 text-transparent group-hover:border-blue-500/30'"
                                    >
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>

                                    <div class="pr-10">
                                        <h4 class="text-lg font-bold text-white" x-text="duration.duration_months + ' ماهه'"></h4>
                                        <p class="mt-1 text-xs text-gray-500">
                                            مناسب برای فعال‌سازی اشتراک در این بازه زمانی
                                        </p>

                                        <div class="mt-6">
                                            <template x-if="duration.discount_percent > 0">
                                                <div class="space-y-1">
                                                    <div
                                                        class="text-xs text-gray-500 line-through"
                                                        x-text="formatPrice(duration.price)"
                                                    ></div>
                                                    <div
                                                        class="text-2xl font-extrabold text-green-400"
                                                        x-text="formatPrice(getFinalPrice(duration.price, duration.discount_percent))"
                                                    ></div>
                                                </div>
                                            </template>

                                            <template x-if="duration.discount_percent == 0">
                                                <div
                                                    class="text-2xl font-extrabold text-white"
                                                    x-text="formatPrice(duration.price)"
                                                ></div>
                                            </template>
                                        </div>
                                    </div>
                                </button>
                            </template>
                        </div>

                        <div class="mt-8 border-t border-gray-800 pt-6">
                            <p
                                x-show="errorMessage"
                                x-transition
                                x-text="errorMessage"
                                class="mb-4 rounded-xl border border-red-500/20 bg-red-500/10 px-4 py-3 text-sm font-medium text-red-400"
                            ></p>

                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                                <p class="text-xs text-gray-500">
                                    پس از انتخاب بازه زمانی، اشتراک به سبد خرید اضافه خواهد شد.
                                </p>

                                <button
                                    @click="addToCart()"
                                    type="button"
                                    :disabled="isSubmitting"
                                    class="inline-flex items-center justify-center gap-2 rounded-2xl px-8 py-3.5 text-sm font-bold text-white transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-400/60"
                                    :class="selectedDuration && !isSubmitting
                                        ? 'bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 shadow-xl shadow-blue-600/25 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40'
                                        : 'cursor-not-allowed bg-gray-700 text-gray-300 opacity-60 shadow-none'"
                                >
                                    <svg
                                        x-show="!isSubmitting"
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="2"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.5 6h13M7 13L5.4 5M10 21a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"></path>
                                    </svg>

                                    <svg
                                        x-show="isSubmitting"
                                        class="h-5 w-5 animate-spin"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>

                                    <span x-text="isSubmitting ? 'در حال انتقال...' : 'افزودن به سبد خرید'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form x-ref="cartForm" method="POST" :action="cartStoreUrl" class="hidden">
            @csrf
            <input type="hidden" name="plan_id" :value="selectedPlanId()">
            <input type="hidden" name="duration_months" :value="selectedDurationMonths()">
        </form>
    </div>

    <script>
        function shopPlans({ plans, isAuthenticated, loginUrl, cartStoreUrl }) {
            return {
                selectedPlan: null,
                selectedDuration: null,
                step: 1,
                errorMessage: '',
                isSubmitting: false,
                plans,
                isAuthenticated,
                loginUrl,
                cartStoreUrl,

                formatPrice(price) {
                    return Number(price).toLocaleString('fa-IR') + ' تومان';
                },

                getFinalPrice(price, discount) {
                    return Math.round(price - ((price * discount) / 100));
                },

                currentPlan() {
                    if (this.selectedPlan === null || this.selectedPlan === undefined) {
                        return null;
                    }

                    return this.plans[this.selectedPlan] ?? null;
                },

                selectedPlanId() {
                    const plan = this.currentPlan();
                    return plan ? plan.id : '';
                },

                selectedDurationObject() {
                    const plan = this.currentPlan();

                    if (!plan || !plan.prices) {
                        return null;
                    }

                    return plan.prices.find(price => Number(price.id) === Number(this.selectedDuration)) ?? null;
                },

                selectedDurationMonths() {
                    const duration = this.selectedDurationObject();
                    return duration ? duration.duration_months : '';
                },

                selectPlan(key) {
                    this.selectedPlan = key;
                    this.selectedDuration = null;
                    this.errorMessage = '';
                    this.step = 2;

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                changePlan() {
                    this.step = 1;
                    this.selectedPlan = null;
                    this.selectedDuration = null;
                    this.errorMessage = '';

                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                },

                selectDuration(durationId) {
                    this.selectedDuration = durationId;
                    this.errorMessage = '';
                },

                addToCart() {
                    if (!this.isAuthenticated) {
                        window.location.href = this.loginUrl;
                        return;
                    }

                    if (!this.currentPlan()) {
                        this.errorMessage = 'ابتدا باید یک پلن را انتخاب کنید.';
                        return;
                    }

                    if (!this.selectedDuration) {
                        this.errorMessage = 'باید بازه زمانی پلن خود را انتخاب کنید.';
                        return;
                    }

                    this.errorMessage = '';
                    this.isSubmitting = true;

                    this.$nextTick(() => {
                        this.$refs.cartForm.submit();
                    });
                }
            }
        }
    </script>
</x-app-layout>

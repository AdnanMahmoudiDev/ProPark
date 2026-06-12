<x-app-layout>
    <div x-data="{
        selectedPlan: null,
        selectedDuration: null,
        step: 1,
        errorMessage: '',
        plans: @js($plans),

        formatPrice(price) {
            return Number(price).toLocaleString() + ' تومان';
        },

        getFinalPrice(price, discount) {
            return Math.round(price - (price * discount / 100));
        },

        selectPlan(key) {
            this.selectedPlan = key;
            this.selectedDuration = null;
            this.errorMessage = '';
            this.step = 2;
        },

        changePlan() {
            this.step = 1;
            this.selectedPlan = null;
            this.selectedDuration = null;
            this.errorMessage = '';
        },

        selectDuration(durationId) {
            this.selectedDuration = durationId;
            this.errorMessage = '';
        },

        addToCart() {
            if (!this.selectedDuration) {
                this.errorMessage = 'باید بازه زمانی پلن خود را انتخاب کنید';
                return;
            }

            this.errorMessage = '';
            console.log('افزودن به سبد: ', this.selectedDuration);
        }
    }" class="py-12 min-h-screen">

        {{-- هدر --}}
        <x-slot name="header">
            <div class="relative flex items-center">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 z-10">
                    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}"
                       class="flex items-center gap-1 px-4 py-2 bg-gradient-to-br from-gray-800/60 to-gray-800/60 border border-gray-700/70 text-white rounded-xl hover:border-violet-400 shadow-lg transition-all duration-300 font-medium text-sm">
                        <span>بازگشت</span>
                    </a>
                </div>

                <div class="text-center w-full">
                    <h2 class="text-xl font-bold text-white tracking-tight">انتخاب اشتراک ProPark</h2>
                </div>
            </div>
        </x-slot>

        <div class="max-w-5xl mx-auto px-6">
            {{-- فاز 1: انتخاب پلن --}}
            <div x-show="step === 1">
                <div class="grid md:grid-cols-3 gap-6">
                    <template x-for="(plan, key) in plans" :key="plan.id">
                        <div @click="selectPlan(key)"
                             class="group cursor-pointer p-8 rounded-3xl border transition-all duration-300"
                             :class="selectedPlan === key ? 'bg-gray-800/50 border-violet-500' : 'bg-gray-900/30 border-gray-800'">

                            <h3 class="text-xl font-bold text-white mb-1" x-text="plan.title"></h3>
                            <p class="text-xs text-gray-400 mb-6" x-text="plan.description"></p>

                            {{-- نمایش امکانات پلن --}}
                            <ul class="space-y-4 mb-8">
                                <template x-for="facility in plan.facilities" :key="facility">
                                    <li class="flex items-center gap-3 text-sm text-gray-300">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span x-text="facility"></span>
                                    </li>
                                </template>
                            </ul>

                            <div class="text-sm font-bold text-violet-400">انتخاب پلن →</div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- فاز 2: انتخاب مدت زمان --}}
            <div x-show="step === 2" class="max-w-2xl mx-auto">
                <div class="bg-gray-900/30 border border-gray-800/40 rounded-3xl p-8 shadow-2xl">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-white">مدت زمان اشتراک</h3>
                            <p class="text-sm text-gray-400">
                                پلن:
                                <span class="text-violet-400 font-bold" x-text="plans[selectedPlan]?.title"></span>
                            </p>
                        </div>

                        <button @click="changePlan()"
                                class="text-xs text-white bg-gray-700 px-3 py-1.5 rounded-lg">
                            تغییر پلن
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <template x-for="duration in plans[selectedPlan].prices" :key="duration.id">
                            <button @click="selectDuration(duration.id)"
                                    class="group relative flex flex-col p-6 rounded-3xl border transition-all duration-300"
                                    :class="selectedDuration === duration.id ? 'bg-gray-800/30 border-violet-500' : 'bg-gray-900/30 border-gray-800'">

                                {{-- نمایش برچسب تخفیف --}}
                                <template x-if="duration.discount_percent > 0">
                                    <span class="absolute top-3 left-3 text-[10px] px-2 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30 font-bold">
                                        <span x-text="duration.discount_percent + '% تخفیف'"></span>
                                    </span>
                                </template>

                                <span class="text-base font-bold text-white"
                                      x-text="duration.duration_months + ' ماهه'"></span>

                                {{-- نمایش قیمت --}}
                                <div class="mt-2">
                                    <template x-if="duration.discount_percent > 0">
                                        <div>
                                            <span class="text-xs text-gray-500 line-through"
                                                  x-text="formatPrice(duration.price)"></span>
                                            <br>
                                            <span class="text-lg font-bold text-green-400"
                                                  x-text="formatPrice(getFinalPrice(duration.price, duration.discount_percent))"></span>
                                        </div>
                                    </template>

                                    <template x-if="duration.discount_percent === 0">
                                        <span class="text-lg font-bold text-white"
                                              x-text="formatPrice(duration.price)"></span>
                                    </template>
                                </div>
                            </button>
                        </template>
                    </div>

                    {{-- پیام خطا برای دکمه افزودن به سبد خرید --}}
                    <div class="mt-8 pt-6 border-t border-gray-800">
                        <p x-show="errorMessage"
                           x-text="errorMessage"
                           class="text-red-400 text-sm font-medium mb-4 animate-pulse"></p>

                        <div class="flex justify-end">
                            <button @click="addToCart()"
                                    class="bg-violet-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-violet-900/20 transition-all"
                                    :class="selectedDuration ? 'hover:scale-105' : 'opacity-50 cursor-not-allowed'">
                                افزودن به سبد خرید
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

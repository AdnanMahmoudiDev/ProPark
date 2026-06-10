<x-app-layout>
<div x-data="{ 
    selectedPlan: null, 
    selectedDuration: null,
    step: 1,

    plans: {
        eco: { 
            title: 'پلن اکو',
            subtitle: 'برای شروع کسب‌وکار',
            features: ['10 رزرو پارکینگ','پشتیبانی معمولی','اعتبار 30 روزه'],

            durations: [
                { label: '1 ماهه', price: '100,000', discount: null },
                { label: '3 ماهه', price: '270,000', discount: '10٪ تخفیف' },
                { label: '6 ماهه', price: '500,000', discount: '20٪ تخفیف' },
                { label: '1 ساله', price: '900,000', discount: '30٪ تخفیف' }
            ]
        },

        pro: { 
            title: 'پلن پرو',
            subtitle: 'بهترین برای حرفه‌ای‌ها',
            features: ['100 رزرو پارکینگ','پشتیبانی VIP','اعتبار 90 روزه'],

            durations: [
                { label: '1 ماهه', price: '250,000', discount: null },
                { label: '3 ماهه', price: '700,000', discount: '10٪ تخفیف' },
                { label: '6 ماهه', price: '1,300,000', discount: '20٪ تخفیف' },
                { label: '1 ساله', price: '2,400,000', discount: '30٪ تخفیف' }
            ]
        },

        sazmani: { 
            title: 'پلن سازمانی',
            subtitle: 'راهکار اختصاصی',
            features: ['رزرو نامحدود','پشتیبانی اختصاصی','اعتبار 365 روزه'],

            durations: [
                { label: '1 ماهه', price: '500,000', discount: null },
                { label: '3 ماهه', price: '1,350,000', discount: '10٪ تخفیف' },
                { label: '6 ماهه', price: '2,500,000', discount: '20٪ تخفیف' },
                { label: '1 ساله', price: '4,500,000', discount: '30٪ تخفیف' }
            ]
        }
    }

}" class="py-12 min-h-screen">


        {{-- هدر --}}
        <x-slot name="header">
            <div class="relative flex items-center">
                {{-- دکمه بازگشت --}}
<div class="absolute left-3 top-1/2 -translate-y-1/2 z-10"> {{-- موقعیت‌یابی دقیق‌تر --}}
    <a href="{{ auth()->check() ? route('dashboard') : url('/') }}"
       class="flex items-center gap-1 px-4 py-2
              bg-gradient-to-br from-gray-800/60 via-gray-800/40 to-gray-800/60
              border border-gray-700/70
              text-white rounded-xl
              hover:from-violet-500/70 hover:via-violet-500/50 hover:to-violet-500/70 hover:border-violet-400
              shadow-lg shadow-gray-900/40
              backdrop-filter backdrop-blur-lg
              transition-all duration-300 ease-out font-medium text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        <span>بازگشت</span>
    </a>
</div>


                <div class=" text-center">
                    <h2 class="text-xl font-bold text-white tracking-tight">انتخاب اشتراک ProPark</h2>
                    <div class="flex justify-center gap-2 mt-2">
                        <span class="h-1 w-12 rounded-full" :class="step === 1 ? 'bg-violet-500' : 'bg-gray-700'"></span>
                        <span class="h-1 w-12 rounded-full" :class="step === 2 ? 'bg-violet-500' : 'bg-gray-700'"></span>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="max-w-5xl mx-auto px-6">

            {{-- فاز ۱: انتخاب پلن --}}
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid md:grid-cols-3 gap-6">

                    <template x-for="(plan, key) in plans" :key="key">
                        <div @click="selectedPlan = key; step = 2" 
                             class="group cursor-pointer p-8 rounded-3xl border transition-all duration-300"
                             :class="selectedPlan === key ? 'bg-gray-800/50 border-violet-500 shadow-[0_0_20px_-5px_rgba(139,92,246,0.3)]' : 'bg-gray-900/30 border-gray-800 hover:border-gray-600'">

                            <h3 class="text-xl font-bold text-white mb-1" x-text="plan.title"></h3>
                            <p class="text-xs text-gray-400 mb-6" x-text="plan.subtitle"></p>

                            <ul class="space-y-4 mb-8">
                                <template x-for="feat in plan.features">
                                    <li class="flex items-center gap-3 text-sm text-gray-300">
                                        <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span x-text="feat"></span>
                                    </li>
                                </template>
                            </ul>

                            <div class="text-sm font-bold text-violet-400 group-hover:translate-x-1 transition-transform">
                                انتخاب پلن →
                            </div>
                        </div>
                    </template>

                </div>
            </div>

            {{-- فاز ۲: انتخاب مدت زمان --}}
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="max-w-2xl mx-auto">

                <div class="bg-gray-900/40 border border-gray-800/40 rounded-3xl p-8 shadow-2xl">

                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-xl font-bold text-white">مدت زمان اشتراک</h3>
                            <p class="text-sm text-gray-400">
                                پلن انتخاب شده:
                                <span class="text-violet-400 font-bold" x-text="plans[selectedPlan]?.title"></span>
                            </p>
                        </div>

                        <button 
                            @click="step = 1; selectedPlan = null"
                            class="group flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-white transition-all duration-200 hover:bg-gray-100 hover:text-gray-800 active:scale-95"
                            >
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                             تغییر پلن
                        </button>

                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <template x-for="duration in plans[selectedPlan].durations" :key="duration.label">
                        <button @click="selectedDuration = duration.label"
                            class="group relative flex flex-col p-6 rounded-3xl border transition-all duration-300"
                            :class="selectedDuration === duration.label 
                                ? 'bg-gray-800/30 border-violet-500 shadow-[0_0_20px_-5px_rgba(139,92,246,0.3)]'
                                : 'bg-gray-900/30 border-gray-800 hover:border-gray-600'">

                            <template x-if="duration.discount">
                                <span class="absolute top-3 left-3 text-[10px] px-2 py-1 rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                    <span x-text="duration.discount"></span>
                                </span>
                            </template>

                            <span class="text-base font-bold text-white" x-text="duration.label"></span>

                            <span class="text-xs font-mono text-gray-400 mt-1"
                                  x-text="duration.price + ' تومان'"></span>

                        </button>
                    </template>

                    </div>


                    <div class="mt-8 pt-6 border-t border-gray-800 flex justify-end">
                        <button class="bg-violet-600 hover:bg-violet-700 text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-violet-900/20 transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50"
                                :disabled="!selectedDuration">
                            افزودن به سبد خرید
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>

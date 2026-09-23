<x-app-layout>
    <div class="min-h-screen bg-gray-950 text-gray-100 py-16 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        {{-- جلوه‌های نورپردازی پس‌زمینه --}}
        <div class="absolute top-0 right-1/2 translate-x-1/2 w-[600px] h-[350px] bg-blue-600/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-1/3 right-0 w-80 h-80 bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none"></div>
        <div class="absolute bottom-10 left-0 w-96 h-96 bg-blue-500/10 rounded-full blur-[130px] pointer-events-none"></div>

        <div class="max-w-6xl mx-auto space-y-16 relative z-10">

            {{-- ۱. بخش Hero --}}
            <div class="reveal-on-scroll text-center space-y-4 max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border border-blue-500/30 bg-blue-500/10 text-blue-400 text-xs font-semibold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                    {{ __('contact_badge') }}
                </div>
                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight">
                    {{ __('How can we') }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-300 to-blue-500">{{ __('help you?') }}</span>
                </h1>
                <p class="text-sm sm:text-base text-gray-400 leading-relaxed">
                    {{ __('contact_hero_desc') }}
                </p>
            </div>

            {{-- ۲. کارت‌های دسترسی و تماس سریع --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- پشتیبانی تلفنی مستقیم --}}
                <div class="reveal-on-scroll reveal-delay-1 bg-gradient-to-b from-gray-900/80 to-gray-950/80 border border-blue-500/30 rounded-3xl p-6 relative overflow-hidden shadow-xl shadow-blue-950/20 group hover:border-blue-500/60 transition-all duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400 mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-400">{{ __('Direct & Immediate Call') }}</span>
                    <h3 class="text-lg font-bold text-white mt-1 mb-2">{{ __('AvaPark Phone Specialist') }}</h3>
                    <p class="text-xs text-gray-400 leading-relaxed mb-6">
                        {{ __('contact_card_phone_desc') }}
                    </p>
                    <a href="tel:09145106455" dir="ltr" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-mono font-bold text-sm tracking-wider transition-all duration-200 shadow-lg shadow-blue-600/30">
                        0914 510 6455
                    </a>
                </div>

                {{-- سیستم ثبت تیکت --}}
                <div class="reveal-on-scroll reveal-delay-2 bg-gray-900/40 border border-gray-800 hover:border-gray-700 rounded-3xl p-6 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center text-indigo-400 mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-indigo-400">{{ __('User Panel') }}</span>
                        <h3 class="text-lg font-bold text-white mt-1 mb-2">{{ __('Submit Technical Ticket') }}</h3>
                        <p class="text-xs text-gray-400 leading-relaxed mb-6">
                            {{ __('contact_card_ticket_desc') }}
                        </p>
                    </div>
                    <a href="#" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 font-medium text-xs transition duration-200 border border-gray-700">
                        {{ __('Coming Soon') }}
                    </a>
                </div>

                {{-- مکاتبات سازمانی و ایمیل --}}
                <div class="reveal-on-scroll reveal-delay-3 bg-gray-900/40 border border-gray-800 hover:border-gray-700 rounded-3xl p-6 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 mb-5">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-emerald-400">{{ __('Official Correspondence') }}</span>
                        <h3 class="text-lg font-bold text-white mt-1 mb-2">{{ __('Inquiries & Contracts') }}</h3>
                        <p class="text-xs text-gray-400 leading-relaxed mb-6">
                            {{ __('contact_card_email_desc') }}
                        </p>
                    </div>
                    <a href="mailto:support@avapark.ir" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 font-medium text-xs transition duration-200 border border-gray-700">
                        support@avapark.ir
                    </a>
                </div>

            </div>

            {{-- ۳. بخش پرسش‌های متداول (FAQ) --}}
            <div class="reveal-on-scroll space-y-6">
                <div class="text-center max-w-xl mx-auto space-y-2">
                    <h2 class="text-2xl font-black text-white">{{ __('Frequently Asked Questions (FAQ)') }}</h2>
                    <p class="text-xs text-gray-400 leading-relaxed">
                        {{ __('contact_faq_desc') }}
                    </p>
                </div>

                <div class="space-y-4 max-w-4xl mx-auto">
                    
                    {{-- سوال ۱ --}}
                    <div class="border border-gray-800 bg-gray-900/50 rounded-2xl p-5 hover:border-gray-700 transition">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            {{ __('faq_q1') }}
                        </h4>
                        <p class="text-xs text-gray-300 mt-2.5 leading-relaxed pr-3.5">
                            {{ __('faq_a1') }}
                        </p>
                    </div>

                    {{-- سوال ۲ --}}
                    <div class="border border-gray-800 bg-gray-900/50 rounded-2xl p-5 hover:border-gray-700 transition">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            {{ __('faq_q2') }}
                        </h4>
                        <p class="text-xs text-gray-300 mt-2.5 leading-relaxed pr-3.5">
                            {{ __('faq_a2') }}
                        </p>
                    </div>

                    {{-- سوال ۳ --}}
                    <div class="border border-gray-800 bg-gray-900/50 rounded-2xl p-5 hover:border-gray-700 transition">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            {{ __('faq_q3') }}
                        </h4>
                        <p class="text-xs text-gray-300 mt-2.5 leading-relaxed pr-3.5">
                            {{ __('faq_a3') }}
                        </p>
                    </div>

                    {{-- سوال ۴ --}}
                    <div class="border border-gray-800 bg-gray-900/50 rounded-2xl p-5 hover:border-gray-700 transition">
                        <h4 class="text-sm font-bold text-white flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                            {{ __('faq_q4') }}
                        </h4>
                        <p class="text-xs text-gray-300 mt-2.5 leading-relaxed pr-3.5">
                            {{ __('faq_a4') }}
                        </p>
                    </div>

                </div>
            </div>

            {{-- ۴. باکس تکمیلی تماس اضطراری --}}
            <div class="reveal-on-scroll rounded-3xl border border-gray-800 bg-gradient-to-r from-blue-950/30 via-gray-900/80 to-blue-950/30 p-8 text-center space-y-3">
                <h3 class="text-lg font-bold text-white">{{ __("Didn't find your answer?") }}</h3>
                <p class="text-xs text-gray-400 max-w-lg mx-auto leading-relaxed">
                    {{ __('contact_footer_desc') }}
                </p>
                <div class="pt-2">
                    <a href="tel:09145106455" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow-lg shadow-blue-600/30">
                        <span>{{ __('Call AvaPark Specialist:') }}</span>
                        <span dir="ltr" class="font-mono">0914 510 6455</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

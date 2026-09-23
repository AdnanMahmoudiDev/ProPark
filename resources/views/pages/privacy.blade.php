<x-app-layout>
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
        
        {{-- هدر صفحه با انیمیشن ورود --}}
        <div class="text-center mb-12" data-reveal>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-medium mb-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <span>{{ __('Data Security & Protection') }}</span>
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">
                {{ __('AvaPark Privacy Policy') }}
            </h1>
            <p class="mt-3 text-sm sm:text-base text-gray-400 max-w-2xl mx-auto leading-relaxed">
                {{ __('privacy_hero_desc') }}
            </p>
            <div class="mt-4 text-xs text-gray-500">
                {{ __('Revision Date:') }} {{ date('Y/m/d') }}
            </div>
        </div>

        {{-- کانتینر کارت‌های حریم خصوصی --}}
        <div class="space-y-6">

            {{-- بخش ۱: اطلاعات ذخیره‌شده --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">{{ __('1. Collected Data & Information') }}</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify mb-4">
                    {{ __('privacy_p1_intro') }}
                </p>
                <ul class="text-sm text-gray-300 space-y-2.5 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <span class="text-blue-400 mt-1">•</span>
                        <span><strong>{{ __('Account Identity Information:') }}</strong> {{ __('privacy_p1_item1') }}</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-blue-400 mt-1">•</span>
                        <span><strong>{{ __('Device Specifications & License:') }}</strong> {{ __('privacy_p1_item2') }}</span>
                    </li>
                </ul>
            </div>

            {{-- بخش ۲: اهداف استفاده (اصلاح شده دقیق بر اساس منطق شما) --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">{{ __('2. Purpose of Using Information') }}</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify">
                    {{ __('privacy_p2_desc') }}
                </p>
            </div>

            {{-- بخش ۳: تدابیر امنیتی و رمزنگاری (شفاف و متناسب با فریم‌ورک) --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">{{ __('3. Security & Password Protection') }}</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify">
                    {{ __('privacy_p3_desc') }}
                </p>
            </div>

            {{-- بخش ۴: عدم اشتراک‌گذاری داده‌ها --}}
            <div class="bg-gray-900/80 backdrop-blur-sm border border-gray-800/80 rounded-2xl p-6 sm:p-8 hover:border-blue-500/30 transition-colors" data-reveal>
                <div class="flex items-center gap-3 mb-4">
                    <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                    </span>
                    <h2 class="text-lg sm:text-xl font-bold text-white">{{ __('4. No Sharing with Third Parties') }}</h2>
                </div>
                <p class="text-sm text-gray-300 leading-relaxed text-justify">
                    {{ __('privacy_p4_desc') }}
                </p>
            </div>

        </div>

        {{-- دکمه بازگشت --}}
        <div class="mt-10 text-center" data-reveal>
            <a href="{{ url()->previous() ?: route('login') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-200 text-sm font-medium border border-gray-700 transition">
                <svg class="w-4 h-4 rtl:rotate-0 ltr:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                <span>{{ __('Back to Previous Page') }}</span>
            </a>
        </div>

    </div>
</x-app-layout>

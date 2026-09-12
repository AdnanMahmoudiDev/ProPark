<x-guest-layout>
    <div class="w-full max-w-5xl bg-gray-900 border border-gray-800/90 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
        {{-- ستون برندینگ و مشخصات سامانه --}}
        <div class="lg:col-span-5 bg-gradient-to-br from-gray-950 via-gray-900 to-blue-950/40 p-6 sm:p-8 lg:p-10 flex flex-col justify-between border-b lg:border-b-0 lg:border-l border-gray-800/80">
            <div>
                {{-- لوگو و نام سایت به عنوان لینک بازگشت به صفحه اصلی --}}
                <a href="{{ url('/') }}" class="group inline-flex items-center gap-3 mb-6 transition focus:outline-none">
                    <div class="h-11 w-11 rounded-2xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-500 shadow-inner transition-transform duration-200 group-hover:scale-105 group-hover:border-blue-500/40">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>
                    <div>
                        <span class="text-base font-black tracking-wide text-white block transition-colors duration-200 group-hover:text-blue-400">AvaPark</span>
                    </div>
                </a>

                <h2 class="text-xl sm:text-2xl font-black text-white leading-snug mb-3">
                    بازیابی دسترسی <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">به پنل مدیریت</span>
                </h2>
                <p class="text-xs text-gray-400 leading-relaxed">
                    با وارد کردن ایمیل، لینک بازنشانی رمز عبور را دریافت کنید.
                </p>
            </div>

            {{-- ویژگی‌ها (برای حفظ یکپارچگی ظاهری) --}}
            <div class="space-y-3.5 my-6">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-900/90 border border-gray-800">
                    <div class="h-8 w-8 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-200">امنیت احراز هویت</p>
                        <p class="text-[10px] text-gray-500">لینک بازیابی اختصاصی و یک‌بار مصرف</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-800/80 flex items-center justify-between text-[11px] text-gray-500">
                <span class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    سرور آماده پردازش
                </span>
            </div>
        </div>

        {{-- ستون فرم بازیابی --}}
        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-center bg-gray-900">
            <div class="mb-6">
                <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">فراموشی رمز عبور</h3>
                <p class="text-xs text-gray-400 mt-2">
                    {{ __('رمز عبور خود را فراموش کرده‌اید؟ مشکلی نیست. ایمیل خود را وارد کنید تا لینک بازنشانی رمز عبور را برایتان ارسال کنیم.') }}
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-xs" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                {{-- ایمیل --}}
                <div>
                    <x-input-label for="email" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('ایمیل ثبت‌نامی')" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <x-text-input id="email" 
                                    class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-left text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                    dir="ltr"
                                    type="email" 
                                    name="email" 
                                    :value="old('email')" 
                                    required 
                                    autofocus 
                                    placeholder="name@domain.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
                </div>

                {{-- اکشن‌ها --}}
                <div class="flex items-center justify-between pt-3 border-t border-gray-800">
                    <a class="text-xs text-gray-400 hover:text-blue-400 transition-colors duration-200" href="{{ route('login') }}">
                        {{ __('بازگشت به صفحه ورود') }}
                    </a>

                    <x-primary-button class="bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 rounded-xl px-7 py-2.5 text-xs font-bold transition-all duration-200 shadow-lg shadow-blue-600/25">
                        {{ __('ارسال لینک بازیابی') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

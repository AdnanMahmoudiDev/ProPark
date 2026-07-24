<x-guest-layout>
    <div class="flex w-full flex-col items-center">
        {{-- لوگوی پروژه پروپارک --}}
        <div class="mb-4">
            <x-application-logo class="h-20 w-20 fill-current text-blue-500" />
        </div>

        {{-- عنوان صفحه با استایل مدرن --}}
        <h2 class="mb-2 text-2xl font-bold text-white">ثبت‌نام در AvaPark</h2>
        <p class="mb-8 text-sm text-gray-500">اطلاعات خود را برای ایجاد حساب کاربری وارد کنید</p>

        {{-- کارت فرم ثبت‌ نام --}}
        <div class="w-full overflow-hidden px-6 py-8 sm:max-w-md sm:rounded-2xl bg-gray-900/50 border border-gray-800 backdrop-blur-sm shadow-2xl">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- نام و نام خانوادگی --}}
                <div class="mb-4">
                    <x-input-label for="name" class="text-gray-300 text-xs mb-2" :value="__('نام و نام خانوادگی')" />
                    <x-text-input id="name" 
                                class="block w-full rounded-xl border-gray-800 bg-gray-950 text-sm text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                placeholder="مثال: عدنان ..."
                                required 
                                autofocus 
                                autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- ایمیل --}}
                <div class="mb-4">
                    <x-input-label for="email" class="text-gray-300 text-xs mb-2" :value="__('ایمیل')" />
                    <x-text-input id="email" 
                                class="block w-full rounded-xl border-gray-800 bg-gray-950 text-sm text-left text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" 
                                dir="ltr"
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                placeholder="name@example.com"
                                required 
                                autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- شماره موبایل (اصلاح شده بر اساس اعتبارسنجی جدید) --}}
                <div class="mb-4">
                    <x-input-label for="phone_number" class="text-gray-300 text-xs mb-2" :value="__('شماره موبایل')" />
                    <x-text-input id="phone_number" 
                                class="block w-full rounded-xl border-gray-800 bg-gray-950 text-sm text-left text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" 
                                dir="ltr"
                                type="text" 
                                name="phone_number" 
                                :value="old('phone_number')" 
                                placeholder="مثال : 09123456789"
                                inputmode="numeric"
                                maxlength="11"
                                pattern="09[0-9]{9}"
                                autocomplete="tel"
                                required 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" />
                    
                    <p class="mt-2 text-[10px] text-gray-500 flex items-center gap-1">
                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        باید ۱۱ رقم و با ۰۹ شروع شود.
                    </p>
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-1 text-xs text-red-400" />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    {{-- رمز عبور --}}
                    <div>
                        <x-input-label for="password" class="text-gray-300 text-xs mb-2" :value="__('رمز عبور')" />
                        <x-text-input id="password" 
                                    class="block w-full rounded-xl border-gray-800 bg-gray-950 text-sm text-white focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" 
                                    type="password" 
                                    name="password" 
                                    required 
                                    autocomplete="new-password" />
                    </div>

                    {{-- تایید رمز عبور --}}
                    <div>
                        <x-input-label for="password_confirmation" class="text-gray-300 text-xs mb-2" :value="__('تکرار رمز')" />
                        <x-text-input id="password_confirmation" 
                                    class="block w-full rounded-xl border-gray-800 bg-gray-950 text-sm text-white focus:border-blue-500 focus:ring-blue-500 transition-all duration-200" 
                                    type="password" 
                                    name="password_confirmation" 
                                    required 
                                    autocomplete="new-password" />
                    </div>
                </div>

                {{-- راهنمای پسورد قوی با طراحی ظریف --}}
                <div class="mb-6 p-3 bg-blue-500/5 rounded-lg border border-blue-500/10">
                    <p class="text-[10px] text-gray-400 leading-relaxed">
                        <span class="text-blue-400 font-bold">امنیت حساب:</span>
                        رمز عبور باید شامل <span class="text-gray-200">حروف بزرگ و کوچک</span>، <span class="text-gray-200">عدد</span> و <span class="text-gray-200">نماد (!@#)</span> باشد.
                    </p>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs text-red-400" />
                </div>

                {{-- دکمه‌ها و لینک ورود --}}
                <div class="flex items-center justify-between mt-8">
                    <a class="text-xs text-gray-500 hover:text-blue-400 transition-colors duration-200" href="{{ route('login') }}">
                        {{ __('قبلاً ثبت‌نام کرده‌اید؟ ورود') }}
                    </a>

                    <x-primary-button class="bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 rounded-xl px-8 py-2.5 text-xs font-bold transition-all duration-200 shadow-lg shadow-blue-600/20">
                        {{ __('ثبت‌نام نهایی') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

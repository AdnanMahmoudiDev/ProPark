<x-guest-layout>
    
    <div class="flex flex-col items-center w-full">
        
        <!-- لوگو -->
        <div class="mb-4">
            <x-application-logo class="w-20 h-20 fill-current text-violet-500" />
        </div>

        <!-- عنوان صفحه -->
        <h2 class="text-2xl font-bold text-white mb-6">ثبت‌نام در ProPark</h2>

        <!-- کارت اصلی ثبت‌نام -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-gray-900 border border-gray-800 shadow-xl overflow-hidden sm:rounded-2xl">
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- نام و نام خانوادگی -->
                <div>
                    <x-input-label for="name" class="text-gray-300" :value="__('نام و نام خانوادگی')" />
                    <x-text-input id="name" 
                                  class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl" 
                                  type="text" 
                                  name="name" 
                                  :value="old('name')" 
                                  required 
                                  autofocus 
                                  autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
                </div>

                <!-- ایمیل -->
                <div class="mt-4">
                    <x-input-label for="email" class="text-gray-300" :value="__('ایمیل')" />
                    <x-text-input id="email" 
                                  class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl" 
                                  type="email" 
                                  name="email" 
                                  :value="old('email')" 
                                  required 
                                  autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <!-- شماره تلفن (اختصاصی ProPark) -->
                <div class="mt-4">
                    <x-input-label for="phone_number" class="text-gray-300" :value="__('شماره موبایل')" />
                    <x-text-input id="phone_number" 
                                  class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl placeholder-gray-600 text-left" 
                                  dir="ltr"
                                  type="text" 
                                  name="phone_number" 
                                  :value="old('phone_number')" 
                                  placeholder="09123456789" 
                                  required />
                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2 text-red-400" />
                </div>

                <!-- رمز عبور -->
                <div class="mt-4">
                    <x-input-label for="password" class="text-gray-300" :value="__('رمز عبور')" />
                    <x-text-input id="password" 
                                  class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl" 
                                  type="password" 
                                  name="password" 
                                  required 
                                  autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <!-- تایید رمز عبور -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" class="text-gray-300" :value="__('تکرار رمز عبور')" />
                    <x-text-input id="password_confirmation" 
                                  class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl" 
                                  type="password" 
                                  name="password_confirmation" 
                                  required 
                                  autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                </div>

                <!-- دکمه‌ها -->
                <div class="flex items-center justify-between mt-8">
                    <a class="text-sm text-gray-500 hover:text-violet-400 transition" href="{{ route('login') }}">
                        {{ __('حساب دارید؟ ورود') }}
                    </a>

                    <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2 shadow-lg shadow-violet-900/20 transition-all duration-200">
                        {{ __('ثبت‌نام') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

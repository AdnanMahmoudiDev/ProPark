<x-guest-layout>
    
    <div class="flex flex-col items-center w-full">
        <!-- لوگو -->
        <div class="mb-4">
            <x-application-logo class="w-20 h-20 fill-current text-violet-500" />
        </div>
        <h2 class="text-2xl font-bold text-white">ورود به ProPark</h2>
        <br>

        <!-- کارت اصلی صفحه -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-gray-900 border border-gray-800 shadow-xl overflow-hidden sm:rounded-2xl">
            <div class="mb-6 text-sm text-gray-400 leading-relaxed">
                {{ __('رمز عبور خود را فراموش کرده‌اید؟ مشکلی نیست. ایمیل خود را وارد کنید تا لینک بازنشانی رمز عبور را برایتان ارسال کنیم.') }}
            </div>

            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- ایمیل -->
                <div>
                    <x-input-label for="email" :value="__('ایمیل')" class="text-gray-300" />
                    <x-text-input 
                        id="email" 
                        class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2 shadow-lg shadow-violet-900/20 transition-all duration-200">
                        {{ __('ارسال لینک بازیابی') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

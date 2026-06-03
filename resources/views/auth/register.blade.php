<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-white">ثبت‌نام در ProPark</h2>
        <p class="text-gray-400 mt-2 text-sm">برای شروع، اطلاعات خود را وارد کنید.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- نام -->
        <div class="mt-4">
            <x-input-label for="name" class="text-gray-300" :value="__('نام و نام خانوادگی')" />
            <x-text-input id="name" class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl" type="text" name="name" :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- ایمیل -->
        <div class="mt-4">
            <x-input-label for="email" class="text-gray-300" :value="__('ایمیل')" />
            <x-text-input id="email" class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- شماره تلفن -->
        <div class="mt-4">
            <x-input-label for="phone_number" class="text-gray-300" :value="__('شماره موبایل')" />
    
            <x-text-input 
                id="phone_number" 
                class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl placeholder-gray-500" 
                type="text" 
                name="phone_number" 
                :value="old('phone_number')" 
                placeholder="مثال 09123456789" 
                required 
            />
    
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>


        <!-- پسورد -->
        <div class="mt-4">
            <x-input-label for="password" class="text-gray-300" :value="__('رمز عبور')" />
            <x-text-input id="password" class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- تایید پسورد -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" class="text-gray-300" :value="__('تکرار رمز عبور')" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-gray-500 hover:text-violet-400 transition" href="{{ route('login') }}">
                {{ __('حساب دارید؟ ورود') }}
            </a>

            <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2">
                {{ __('ثبت‌نام') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

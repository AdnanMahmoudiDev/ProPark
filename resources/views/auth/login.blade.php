<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-white">ورود به ProPark</h2>
        <p class="text-gray-400 mt-2 text-sm">خوش آمدید، لطفا اطلاعات خود را وارد کنید.</p>
    </div>

    
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- ایمیل -->
        <div>
            <x-input-label for="email" class="text-gray-300" :value="__('ایمیل')" />
            <x-text-input id="email" 
                          class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl placeholder-gray-500" 
                          type="email" 
                          name="email" 
                          :value="old('email')" 
                          placeholder="example@domain.com" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- پسورد -->
        <div class="mt-4">
            <x-input-label for="password" class="text-gray-300" :value="__('رمز عبور')" />

            <x-text-input id="password" 
                          class="block mt-2 w-full bg-gray-800 border-gray-700 focus:border-violet-500 focus:ring-violet-500 rounded-xl"
                          type="password"
                          name="password"
                          required 
                          autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- مرا به خاطر بسپار -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-800 border-gray-700 text-violet-600 shadow-sm focus:ring-violet-500" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('مرا به خاطر بسپار') }}</span>
            </label>
        </div>

        <!-- دکمه ی فراموشی رمز و دکمه ی لاگین -->
        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-500 hover:text-violet-400 transition" href="{{ route('password.request') }}">
                    {{ __('رمز عبور خود را فراموش کرده‌اید؟') }}
                </a>
            @endif

            <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2">
                {{ __('ورود') }}
            </x-primary-button>
        </div>

        <!-- دکمه ی ساخت حساب جدید -->
        <div class="mt-6 text-center text-sm text-gray-400">
            {{ __('حساب کاربری ندارید؟') }}
            <a href="{{ route('register') }}" class="text-violet-400 hover:text-violet-300 font-semibold transition">
                {{ __('ساخت حساب کاربری') }}
            </a>
        </div>

    </form>
</x-guest-layout>

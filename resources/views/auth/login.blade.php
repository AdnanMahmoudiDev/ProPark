<x-guest-layout>
    <div class="flex flex-col items-center w-full">
        {{-- لوگو --}}
        <div class="mb-4">
            <x-application-logo class="w-20 h-20 fill-current text-blue-500" />
        </div>

        {{-- عنوان --}}
        <h2 class="text-2xl font-bold text-white mb-2">ورود به ProPark</h2>
        <p class="text-sm text-gray-400 mb-6 text-center">
            برای ورود به حساب کاربری، اطلاعات خود را وارد کنید.
        </p>

        {{-- کارت اصلی --}}
        <div class="w-full sm:max-w-md px-6 py-8 overflow-hidden sm:rounded-2xl bg-gray-900/60 border border-gray-800 shadow-xl backdrop-blur-sm">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
                @csrf

                {{-- ایمیل --}}
                <div>
                    <x-input-label for="email" class="text-gray-300" :value="__('ایمیل')" />

                    <x-text-input
                        id="email"
                        class="block mt-2 w-full bg-gray-950 border-gray-800 text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 rounded-xl"
                        type="email"
                        name="email"
                        :value="old('email')"
                        placeholder="example@domain.com"
                        required
                        autofocus
                        autocomplete="username"
                        dir="ltr"
                    />

                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-sm" />
                </div>

                {{-- رمز عبور --}}
                <div class="mt-4">
                    <x-input-label for="password" class="text-gray-300" :value="__('رمز عبور')" />

                    <div class="relative mt-2">
                        <x-text-input
                            id="password"
                            class="block w-full bg-gray-950 border-gray-800 text-white focus:border-blue-500 focus:ring-blue-500 rounded-xl ps-10"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            name="password"
                            required
                            autocomplete="current-password"
                            dir="ltr"
                        />

                        <button
                            type="button"
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 left-0 flex items-center px-3 text-gray-400 hover:text-blue-400 transition"
                            tabindex="-1"
                        >
                            {{-- چشم باز --}}
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>

                            {{-- چشم بسته --}}
                            <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.325-2.11A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M15 12a3 3 0 00-3-3m0 0a3 3 0 00-2.12.88M12 9l-9 9"/>
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-sm" />
                </div>

                {{-- مرا به خاطر بسپار --}}
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input
                            id="remember_me"
                            type="checkbox"
                            class="rounded bg-gray-950 border-gray-800 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-offset-gray-900"
                            name="remember"
                        >
                        <span class="ms-2 text-sm text-gray-400">{{ __('مرا به خاطر بسپار') }}</span>
                    </label>
                </div>

                {{-- دکمه‌ها --}}
                <div class="flex items-center justify-between mt-8 gap-4">
                    @if (Route::has('password.request'))
                        <a
                            class="text-sm text-gray-500 hover:text-blue-400 transition"
                            href="{{ route('password.request') }}"
                        >
                            {{ __('رمز عبور خود را فراموش کرده‌اید؟') }}
                        </a>
                    @endif

                    <x-primary-button class="bg-blue-600 hover:bg-blue-500 rounded-xl px-6 py-2.5 shadow-lg shadow-blue-900/20 transition-all duration-200">
                        {{ __('ورود') }}
                    </x-primary-button>
                </div>

                {{-- ساخت حساب --}}
                <div class="mt-8 pt-6 border-t border-gray-800 text-center text-sm text-gray-400">
                    {{ __('حساب کاربری ندارید؟') }}
                    <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition">
                        {{ __('ساخت حساب کاربری') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

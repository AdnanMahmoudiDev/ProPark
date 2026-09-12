<x-guest-layout>
    <div class="w-full max-w-5xl my-auto">
        <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[580px]">
            
            {{-- ستون سمت راست: برندینگ و ویژگی‌ها (در موبایل مخفی / در دسکتاپ نمایش داده می‌شود) --}}
            <div class="hidden lg:flex lg:col-span-5 bg-gradient-to-br from-gray-950 via-gray-900 to-blue-950/40 p-10 flex-col justify-between border-b lg:border-b-0 lg:border-l border-gray-800">
                <div>
                    {{-- لوگو و نام سایت دسکتاپ به عنوان لینک به صفحه اصلی --}}
                    <a href="{{ url('/') }}" class="group inline-flex items-center gap-3 mb-8 transition focus:outline-none">
                        <x-application-logo class="w-10 h-10 fill-current text-blue-500 transition-transform duration-200 group-hover:scale-105" />
                        <span class="text-xl font-bold tracking-wider text-white transition-colors duration-200 group-hover:text-blue-400">AvaPark</span>
                    </a>
                    
                    <h1 class="text-2xl font-extrabold text-white leading-snug mb-4">
                        سامانه هوشمند مدیریت پارکینگ
                    </h1>
                    <p class="text-gray-400 text-sm leading-relaxed mb-8">
                        دسترسی به پنل مانیتورینگ متمرکز، مدیریت دستگاه‌ها و گزارش‌گیری بلادرنگ ترددها.
                    </p>

                    {{-- لیست ویژگی‌ها --}}
                    <div class="space-y-4 text-sm text-gray-300">
                        <div class="flex items-center gap-3 bg-gray-950/60 p-3 rounded-xl border border-gray-800/80">
                            <span class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </span>
                            <span>احراز هویت امن و کنترل دسترسی</span>
                        </div>

                        <div class="flex items-center gap-3 bg-gray-950/60 p-3 rounded-xl border border-gray-800/80">
                            <span class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </span>
                            <span>مدیریت و پایش بلادرنگ دیوایس‌ها</span>
                        </div>

                        <div class="flex items-center gap-3 bg-gray-950/60 p-3 rounded-xl border border-gray-800/80">
                            <span class="p-2 rounded-lg bg-blue-500/10 text-blue-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </span>
                            <span>داشبورد آماری و تحلیل دقیق داده‌ها</span>
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

            {{-- ستون سمت چپ: فرم ورود --}}
            <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center bg-gray-900">
                <div class="max-w-md w-full mx-auto">
                    
                    {{-- هدر موبایل به عنوان لینک به صفحه اصلی --}}
                    <div class="lg:hidden mb-6">
                        <a href="{{ url('/') }}" class="group inline-flex items-center gap-3 transition focus:outline-none">
                            <x-application-logo class="w-8 h-8 fill-current text-blue-500 transition-transform duration-200 group-hover:scale-105" />
                            <span class="text-lg font-bold text-white transition-colors duration-200 group-hover:text-blue-400">AvaPark</span>
                        </a>
                    </div>

                    <h2 class="text-2xl font-bold text-white tracking-tight">ورود به حساب کاربری</h2>
                    <p class="text-sm text-gray-400 mt-1.5 mb-8">
                        برای دسترسی به پنل مدیریت، مشخصات کاربری خود را وارد نمایید.
                    </p>

                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
                        @csrf

                        {{-- ایمیل --}}
                        <div>
                            <x-input-label for="email" class="text-gray-300 font-medium text-xs" :value="__('آدرس ایمیل')" />

                            <x-text-input
                                id="email"
                                class="block mt-2 w-full bg-gray-950 border border-gray-800 text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 px-3.5 text-sm transition"
                                type="email"
                                name="email"
                                :value="old('email')"
                                placeholder="name@company.com"
                                required
                                autofocus
                                autocomplete="username"
                                dir="ltr"
                            />

                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        {{-- رمز عبور --}}
                        <div class="mt-5">
                            <div class="flex items-center justify-between">
                                <x-input-label for="password" class="text-gray-300 font-medium text-xs" :value="__('رمز عبور')" />
                                
                                @if (Route::has('password.request'))
                                    <a class="text-xs text-blue-400 hover:text-blue-300 transition" href="{{ route('password.request') }}">
                                        {{ __('رمز عبور را فراموش کرده‌اید؟') }}
                                    </a>
                                @endif
                            </div>

                            <div class="relative mt-2">
                                <x-text-input
                                    id="password"
                                    class="block w-full bg-gray-950 border border-gray-800 text-white placeholder-gray-600 focus:border-blue-500 focus:ring-blue-500 rounded-xl py-2.5 ps-10 pe-3.5 text-sm transition"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    name="password"
                                    placeholder="••••••••"
                                    required
                                    autocomplete="current-password"
                                    dir="ltr"
                                />

                                <button
                                    type="button"
                                    @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 left-0 flex items-center px-3 text-gray-400 hover:text-blue-400 transition"
                                    tabindex="-1"
                                    :title="showPassword ? 'مخفی کردن رمز عبور' : 'نمایش رمز عبور'"
                                >
                                    {{-- آیکون چشم بسته --}}
                                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.325-2.11A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.97 9.97 0 01-4.132 5.411M15 12a3 3 0 00-3-3m0 0a3 3 0 00-2.12.88M3 3l18 18"/>
                                    </svg>

                                    {{-- آیکون چشم باز --}}
                                    <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>

                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400 text-xs" />
                        </div>

                        {{-- مرا به خاطر بسپار --}}
                        <div class="flex items-center mt-5">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded bg-gray-950 border-gray-800 text-blue-600 shadow-sm focus:ring-blue-500 focus:ring-offset-gray-900 cursor-pointer"
                                    name="remember"
                                >
                                <span class="ms-2 text-xs text-gray-400">{{ __('مرا به خاطر بسپار') }}</span>
                            </label>
                        </div>

                        {{-- دکمه ارسال فرم --}}
                        <div class="mt-6">
                            <x-primary-button class="w-full justify-center bg-blue-600 hover:bg-blue-500 text-white font-medium rounded-xl py-2.5 px-4 shadow-lg shadow-blue-900/30 transition-all duration-200">
                                {{ __('ورود به حساب') }}
                            </x-primary-button>
                        </div>

                        {{-- لینک ثبت‌نام --}}
                        <div class="mt-8 pt-6 border-t border-gray-800/80 text-center text-xs text-gray-400">
                            {{ __('حساب کاربری ندارید؟') }}
                            <a href="{{ route('register') }}" class="text-blue-400 hover:text-blue-300 font-semibold transition ms-1">
                                {{ __('ثبت‌نام در سامانه') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-guest-layout>

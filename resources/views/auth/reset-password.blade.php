<x-guest-layout>
    <div class="w-full max-w-5xl bg-gray-900 border border-gray-800/90 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
        {{-- ستون برندینگ و مشخصات سامانه --}}
        <div class="lg:col-span-5 bg-gradient-to-br from-gray-950 via-gray-900 to-blue-950/40 p-6 sm:p-8 lg:p-10 flex flex-col justify-between border-b lg:border-b-0 lg:border-l border-gray-800/80">
            <div>
                {{-- لوگو و نام برند AvaPark متصل به صفحه اصلی --}}
                <a href="{{ url('/') }}" class="group inline-flex items-center gap-3 mb-6 transition focus:outline-none">
                    <div class="h-11 w-11 rounded-2xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-500 shadow-inner transition-transform duration-200 group-hover:scale-105 group-hover:border-blue-500/40">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>
                    <div>
                        <span class="text-base font-black tracking-wide text-white block transition-colors duration-200 group-hover:text-blue-400">AvaPark</span>
                    </div>
                </a>

                <h2 class="text-xl sm:text-2xl font-black text-white leading-snug mb-3">
                    تنظیم مجدد <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">رمز عبور جدید</span>
                </h2>
                <p class="text-xs text-gray-400 leading-relaxed">
                    برای حفظ امنیت حسابتان، لطفاً یک رمز عبور قدرتمند و جدید انتخاب فرمایید.
                </p>
            </div>

            {{-- بخش ویژگی امنیتی --}}
            <div class="space-y-3.5 my-6">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-900/90 border border-gray-800">
                    <div class="h-8 w-8 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-200">امنیت احراز هویت</p>
                        <p class="text-[10px] text-gray-500">رمز عبور با الگوریتم‌های استاندارد هش و ذخیره می‌شود</p>
                    </div>
                </div>
            </div>

            {{-- نشانگر وضعیت --}}
            <div class="pt-4 border-t border-gray-800/80 flex items-center justify-between text-[11px] text-gray-500">
                <span class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    درگاه رمزنگاری امن فعال است
                </span>
            </div>
        </div>

        {{-- ستون فرم تغییر رمز --}}
        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-center bg-gray-900">
            <div class="mb-6">
                <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">تعیین رمز عبور تازه</h3>
                <p class="text-xs text-gray-400 mt-1">مشخصات خواسته شده را تکمیل نمایید</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                {{-- ایمیل --}}
                <div>
                    <x-input-label for="email" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('پست الکترونیک')" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <x-text-input id="email" 
                                      class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-left text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                      dir="ltr"
                                      type="email" 
                                      name="email" 
                                      :value="old('email', $request->email)" 
                                      required 
                                      autofocus 
                                      autocomplete="username" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
                </div>

                {{-- رمز جدید --}}
                <div>
                    <x-input-label for="password" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('رمز عبور جدید')" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <x-text-input id="password" 
                                      class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                      dir="ltr"
                                      type="password" 
                                      name="password" 
                                      placeholder="••••••••"
                                      required 
                                      autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />
                </div>

                {{-- تایید رمز --}}
                <div>
                    <x-input-label for="password_confirmation" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('تکرار رمز عبور')" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <x-text-input id="password_confirmation" 
                                      class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                      dir="ltr"
                                      type="password" 
                                      name="password_confirmation" 
                                      placeholder="••••••••"
                                      required 
                                      autocomplete="new-password" />
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-400" />
                </div>

                {{-- دکمه ذخیره و ورود --}}
                <div class="flex items-center justify-between pt-4 border-t border-gray-800">
                    <a class="text-xs text-gray-400 hover:text-blue-400 transition-colors duration-200" href="{{ route('login') }}">
                        {{ __('بازگشت به ورود') }}
                    </a>

                    <x-primary-button class="bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 rounded-xl px-7 py-2.5 text-xs font-bold transition-all duration-200 shadow-lg shadow-blue-600/25">
                        {{ __('ذخیره و ورود') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

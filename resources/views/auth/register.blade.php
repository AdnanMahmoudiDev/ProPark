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
                    مدیریت هوشمند <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">زیرساخت‌های پارکینگ</span>
                </h2>
                <p class="text-xs text-gray-400 leading-relaxed">
                    سامانه هوشمند سازی پارکینگ.
                </p>
            </div>

            {{-- ویژگی‌ها --}}
            <div class="space-y-3.5 my-6">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-900/90 border border-gray-800">
                    <div class="h-8 w-8 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-200">ایجاد سریع حساب کاربری</p>
                        <p class="text-[10px] text-gray-500">پایش و مدیریت هوشمند پارکینگ در چند لحظه</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-900/90 border border-gray-800">
                    <div class="h-8 w-8 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-200">حفاظت و امنیت اطلاعات</p>
                        <p class="text-[10px] text-gray-500">رمزنگاری داده‌ها و دسترسی امن به پنل مدیریت</p>
                    </div>
                </div>
            </div>

            {{-- وضعیت اتصال سرور --}}
            <div class="pt-4 border-t border-gray-800/80 flex items-center justify-between text-[11px] text-gray-500">
                <span class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    سرور آماده پردازش
                </span>
            </div>
        </div>

        {{-- ستون فرم ثبت‌نام --}}
        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-center bg-gray-900" 
             x-data="{
                name: {{ json_encode(old('name', '')) }},
                password: '',
                get hasPersian() {
                    return /[\u0600-\u06FF]/.test(this.name || '');
                },
                get isMinLength() {
                    return (this.password || '').length >= 8;
                },
                get hasUpperCase() {
                    return /[A-Z]/.test(this.password || '');
                },
                get hasNumber() {
                    return /[0-9]/.test(this.password || '');
                }
             }">

            <div class="mb-5">
                <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">فرم ثبت‌نام حساب کاربری</h3>
                <p class="text-xs text-gray-400 mt-1">اطلاعات حساب خود را با دقت وارد فرمایید</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- نام و نام خانوادگی --}}
                <div>
                    <x-input-label for="name" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('نام و نام خانوادگی (انگلیسی)')" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <x-text-input id="name" 
                                    class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-left text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                    x-bind:class="hasPersian ? '!border-red-500 focus:!ring-red-500' : ''"
                                    type="text" 
                                    name="name" 
                                    x-model="name"
                                    dir="ltr"
                                    placeholder="e.g. Adnan Mahmoudi"
                                    pattern="^[A-Za-z\s]+$"
                                    title="لطفاً نام را به انگلیسی وارد کنید"
                                    required 
                                    autofocus 
                                    autocomplete="name" />
                    </div>

                    {{-- هشدار زنده نام فارسی --}}
                    <div x-show="hasPersian" 
                         x-cloak 
                         style="display: none !important;" 
                         class="mt-2 flex items-center gap-1.5 text-xs text-amber-400 bg-amber-950/40 border border-amber-500/30 px-3 py-1.5 rounded-xl">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>لطفاً نام و نام خانوادگی را فقط با <strong>حروف انگلیسی</strong> بنویسید.</span>
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-400" />
                </div>

                {{-- ایمیل و موبایل --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                                        :value="old('email')" 
                                        placeholder="name@domain.com"
                                        required 
                                        autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-400" />
                    </div>

                    <div>
                        <x-input-label for="phone_number" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('شماره موبایل')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </div>
                            <x-text-input id="phone_number" 
                                        class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-left text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                        dir="ltr"
                                        type="text" 
                                        name="phone_number" 
                                        :value="old('phone_number')" 
                                        placeholder="09123456789"
                                        inputmode="numeric"
                                        maxlength="11"
                                        pattern="09[0-9]{9}"
                                        autocomplete="tel"
                                        required 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)" />
                        </div>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-1 text-xs text-red-400" />
                    </div>
                </div>

                {{-- رمز عبور و تکرار --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="password" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('رمز عبور')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <x-text-input id="password" 
                                        class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                        dir="ltr"
                                        type="password" 
                                        name="password" 
                                        x-model="password"
                                        placeholder="••••••••"
                                        required 
                                        autocomplete="new-password" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" class="text-gray-300 text-xs font-semibold mb-1.5" :value="__('تکرار رمز عبور')" />
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <x-text-input id="password_confirmation" 
                                        class="block w-full pl-10 pr-3.5 py-2.5 rounded-xl border-gray-800 bg-gray-950 text-sm text-white placeholder-gray-600 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200" 
                                        dir="ltr"
                                        type="password" 
                                        name="password_confirmation" 
                                        placeholder="••••••••"
                                        required 
                                        autocomplete="new-password" />
                        </div>
                    </div>
                </div>

                {{-- ایندیکاتور زنده الزامات رمز عبور --}}
                <div class="p-3 bg-gray-950 rounded-xl border border-gray-800">
                    <p class="text-[11px] text-gray-400 font-medium mb-1.5">الزامات رمز عبور:</p>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs">
                        <span class="flex items-center gap-1 transition-colors" x-bind:class="isMinLength ? 'text-emerald-400 font-medium' : 'text-gray-500'">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            حداقل ۸ کاراکتر
                        </span>
                        <span class="flex items-center gap-0.5 transition-colors" x-bind:class="hasUpperCase ? 'text-emerald-400 font-medium' : 'text-gray-500'">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            حداقل یک حرف بزرگ انگلیسی
                        </span>
                        <span class="flex items-center gap-1 transition-colors" x-bind:class="hasNumber ? 'text-emerald-400 font-medium' : 'text-gray-500'">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            حداقل یک عدد
                        </span>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-400" />

                {{-- اکشن‌ها --}}
                <div class="flex flex-col-reverse sm:flex-row items-center justify-between gap-3 pt-3 border-t border-gray-800">
                    <a class="text-xs text-gray-400 hover:text-blue-400 transition-colors duration-200" href="{{ route('login') }}">
                        {{ __('ورود به حساب کاربری') }}
                    </a>

                    <x-primary-button class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 rounded-xl px-7 py-2.5 text-xs font-bold transition-all duration-200 shadow-lg shadow-blue-600/25">
                        {{ __('ایجاد حساب و ورود') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

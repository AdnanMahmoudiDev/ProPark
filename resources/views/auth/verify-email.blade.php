<x-guest-layout>
    <div class="w-full max-w-5xl bg-gray-900 border border-gray-800/90 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
        {{-- ستون برندینگ و وضعیت سامانه --}}
        <div class="lg:col-span-5 bg-gradient-to-br from-gray-950 via-gray-900 to-blue-950/40 p-6 sm:p-8 lg:p-10 flex flex-col justify-between border-b lg:border-b-0 lg:border-l border-gray-800/80">
            <div>
                {{-- لوگو و نام برند AvaPark به عنوان لینک بازگشت به صفحه اصلی --}}
                <a href="{{ url('/') }}" class="group inline-flex items-center gap-3 mb-6 transition focus:outline-none">
                    <div class="h-11 w-11 rounded-2xl bg-blue-600/10 border border-blue-500/20 flex items-center justify-center text-blue-500 shadow-inner transition-transform duration-200 group-hover:scale-105 group-hover:border-blue-500/40">
                        <x-application-logo class="h-6 w-6 fill-current" />
                    </div>
                    <div>
                        <span class="text-base font-black tracking-wide text-white block transition-colors duration-200 group-hover:text-blue-400">AvaPark</span>
                    </div>
                </a>

                <h2 class="text-xl sm:text-2xl font-black text-white leading-snug mb-3">
                    تأیید حساب کاربری <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">یک گام تا ورود به پنل</span>
                </h2>
                <p class="text-xs text-gray-400 leading-relaxed">
                    جهت فعال‌سازی کامل امکانات و ارتقای امنیت حساب کاربری، لطفاً نشانی ایمیل خود را تأیید نمایید.
                </p>
            </div>

            {{-- بخش وضعیت امنیتی --}}
            <div class="space-y-3.5 my-6">
                <div class="flex items-center gap-3 p-3.5 rounded-2xl bg-gray-900/90 border border-gray-800">
                    <div class="h-8 w-8 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-200">صندوق ایمیل خود را بررسی کنید</p>
                        <p class="text-[10px] text-gray-500">پوشه Spam/Junk را نیز در صورت عدم دریافت چک کنید</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-gray-800/80 flex items-center justify-between text-[11px] text-gray-500">
                <span class="flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    سیستم ایمیل فعال است
                </span>
            </div>
        </div>

        {{-- ستون فرم و اکشن‌های تأیید ایمیل --}}
        <div class="lg:col-span-7 p-6 sm:p-8 lg:p-10 flex flex-col justify-center bg-gray-900">
            <div class="mb-6">
                <h3 class="text-lg sm:text-xl font-bold text-white tracking-tight">بررسی و فعال‌سازی ایمیل</h3>
                <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                    {{ __('با تشکر از ثبت‌نام شما! قبل از ادامه، لطفاً ایمیل خود را با کلیک بر روی لینکی که برایتان ارسال کردیم تأیید کنید. اگر ایمیلی دریافت نکردید، می‌توانید درخواست ارسال مجدد ثبت کنید.') }}
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-3.5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs flex items-center gap-2.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ __('یک لینک تأیید جدید به آدرس ایمیل شما ارسال شد.') }}</span>
                </div>
            @endif

            <div class="pt-4 border-t border-gray-800 flex items-center justify-between gap-4">
                {{-- فرم ارسال مجدد ایمیل --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="bg-blue-600 hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 rounded-xl px-6 py-2.5 text-xs font-bold transition-all duration-200 shadow-lg shadow-blue-600/25">
                        {{ __('ارسال مجدد ایمیل تأیید') }}
                    </x-primary-button>
                </form>

                {{-- دکمه خروج امن --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-400 hover:text-red-400 transition-colors duration-200">
                        {{ __('خروج از حساب') }}
                    </button>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>

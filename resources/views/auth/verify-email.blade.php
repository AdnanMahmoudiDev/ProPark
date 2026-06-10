<x-guest-layout>
    <div class="flex flex-col items-center w-full">
         {{-- لوگو  --}}
        <div class="mb-4">
            <x-application-logo class="w-20 h-20 fill-current text-violet-500" />
        </div>

        <h2 class="text-2xl font-bold text-white mb-6">تایید ایمیل</h2>

         {{-- کارت اصلی  --}}
        <div class="w-full sm:max-w-md px-6 py-8 bg-gray-900 border border-gray-800 shadow-xl overflow-hidden sm:rounded-2xl">
            
            <div class="mb-6 text-sm text-gray-400 leading-relaxed">
                {{ __('با تشکر از ثبت‌نام شما! قبل از ادامه، لطفاً ایمیل خود را با کلیک بر روی لینکی که برایتان ارسال کردیم تایید کنید. اگر ایمیلی دریافت نکردید، با کمال میل لینک دیگری برایتان ارسال می‌کنیم.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 font-medium text-sm text-green-400 bg-green-900/20 p-4 rounded-xl border border-green-900/50">
                    {{ __('یک لینک تایید جدید به آدرس ایمیلی که هنگام ثبت‌نام وارد کردید، ارسال شد.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                 {{-- فرم ارسال مجدد  --}}
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2 shadow-lg shadow-violet-900/20 transition-all duration-200">
                        {{ __('ارسال مجدد ایمیل تایید') }}
                    </x-primary-button>
                </form>

                 {{-- دکمه خروج  --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-gray-500 hover:text-violet-400 transition underline decoration-gray-600 hover:decoration-violet-400 underline-offset-4">
                        {{ __('خروج از حساب') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>

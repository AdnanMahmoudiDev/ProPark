<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- الزام مرورگر به ارسال هدر رفرر کامل به درگاه شاپرک --}}
    <meta name="referrer" content="unsafe-url">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ __('در حال انتقال به درگاه بانکی...') }}</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-950 text-gray-100 flex items-center justify-center min-h-screen px-4 font-sans select-none">
    
    <div class="max-w-md w-full bg-gray-900/90 border border-gray-800 rounded-2xl p-8 text-center shadow-2xl relative overflow-hidden">
        {{-- هاله نوری ملایم --}}
        <div class="absolute -top-24 -left-24 w-48 h-48 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-indigo-600/20 rounded-full blur-3xl pointer-events-none"></div>

        {{-- اسپینر و آیکون امنیتی --}}
        <div class="flex justify-center mb-6">
            <div class="relative flex items-center justify-center">
                <div class="w-16 h-16 border-4 border-blue-500/20 border-t-blue-500 rounded-full animate-spin"></div>
                <svg class="w-7 h-7 text-blue-400 absolute" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
        </div>

        <h1 class="text-xl font-bold text-white mb-2">{{ __('در حال اتصال به شاپرک (درگاه سپ)') }}</h1>
        <p class="text-sm text-gray-400 mb-6 leading-relaxed">
            {{ __('لطفاً چند لحظه شکیبا باشید؛ شما به صورت خودکار به درگاه امن پرداخت منتقل می‌شوید...') }}
        </p>

        {{-- فرم انتقال امن شاپرک --}}
        <form id="gatewayForm" action="{{ $action }}" method="{{ $method }}">
            @foreach($inputs as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <noscript>
                <div class="mt-4">
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors">
                        {{ __('کلیک جهت انتقال به درگاه پرداخت') }}
                    </button>
                </div>
            </noscript>
        </form>

        <div class="text-xs text-gray-500 mt-6 border-t border-gray-800/80 pt-4 flex items-center justify-center gap-1.5">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            {{ __('اتصال امن SSL شاپرک (سپ)') }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('gatewayForm');
            if (form) {
                form.submit();
            }
        });
    </script>
</body>
</html>

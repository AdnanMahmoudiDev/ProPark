<!DOCTYPE html>
<html lang="fa" dir="rtl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>503 - در دست تعمیر | Service Unavailable - {{ config('app.name', 'AvaPark') }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-950 text-slate-100 font-sans antialiased overflow-x-hidden relative flex flex-col justify-between selection:bg-blue-600 selection:text-white">

    {{-- پس‌زمینه نئونی و گرید هماهنگ با Welcome --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 opacity-35 [background-size:28px_28px] bg-[radial-gradient(#1e293b_1px,transparent_1px)]"></div>
    <div aria-hidden="true" class="pointer-events-none absolute left-1/2 top-0 h-[350px] w-[700px] -translate-x-1/2 rounded-full bg-blue-600/15 blur-[90px] md:h-[500px] md:w-[1200px] md:blur-[140px]"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -right-40 top-1/3 h-[400px] w-[400px] rounded-full bg-indigo-600/10 blur-[100px] md:blur-[130px]"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -left-40 bottom-1/4 h-[400px] w-[400px] rounded-full bg-sky-600/10 blur-[100px] md:blur-[130px]"></div>

    {{-- هدر مینیمال بدون کادر دور لوگو --}}
    <header class="relative z-10 w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
        <a href="{{ url('/') }}" class="flex items-center gap-3 group">
            <div class="h-10 flex items-center justify-center transition-transform group-hover:scale-105">
                <img
                    src="{{ asset('images/ProPark.png') }}"
                    alt="{{ config('app.name', 'AvaPark') }}"
                    class="h-10 w-auto object-contain filter brightness-200"
                    onerror="this.onerror=null; this.src='{{ asset('images/logo.png') }}'; if(!this.complete) this.style.display='none';"
                >
            </div>
            <span class="text-lg font-bold tracking-tight text-white group-hover:text-blue-400 transition-colors">
                {{ config('app.name', 'AvaPark') }}
            </span>
        </a>

        <div class="flex items-center gap-2">
            <span class="text-xs font-mono text-gray-400 bg-gray-900/80 border border-gray-800 px-3.5 py-1.5 rounded-xl backdrop-blur shadow-inner">
                STATUS: <span class="text-blue-400 font-bold">503_MAINTENANCE</span>
            </span>
        </div>
    </header>

    {{-- محتوا --}}
    <main class="relative z-10 flex-grow flex items-center justify-center px-5 py-10">
        <div class="w-full max-w-2xl relative">

            <div class="relative overflow-hidden rounded-[2.2rem] border border-gray-800/90 bg-gradient-to-b from-gray-900/85 via-gray-950/90 to-gray-950/95 p-8 md:p-12 shadow-2xl backdrop-blur-2xl text-center group">

                {{-- هاله‌های نوری کارت --}}
                <div aria-hidden="true" class="pointer-events-none absolute -right-24 -top-24 h-48 w-48 rounded-full bg-blue-600/20 blur-3xl transition-all duration-500 group-hover:bg-blue-600/30"></div>
                <div aria-hidden="true" class="pointer-events-none absolute -left-24 -bottom-24 h-48 w-48 rounded-full bg-indigo-600/10 blur-3xl"></div>

                {{-- کد بزرگ --}}
                <div class="relative inline-flex mb-4">
                    <span class="font-mono font-black text-7xl md:text-9xl tracking-tight bg-gradient-to-r from-blue-400 via-sky-300 to-indigo-400 bg-clip-text text-transparent select-none drop-shadow-sm">
                        503
                    </span>
                </div>

                {{-- بج دوزبانه --}}
                <div class="mb-6 flex items-center justify-center">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-xl text-xs font-bold font-mono uppercase bg-blue-500/10 text-blue-400 border border-blue-500/20 shadow-sm">
                        <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                        در دست تعمیر و نگهداری / Maintenance Mode
                    </span>
                </div>

                {{-- تیترها --}}
                <h1 class="text-2xl md:text-3xl font-black text-white tracking-tight mb-2 leading-snug">
                    سامانه موقتاً در حال بروزرسانی است
                </h1>
                <h2 dir="ltr" class="text-base md:text-lg font-bold text-gray-300 tracking-normal mb-5 font-mono">
                    Service is temporarily unavailable for maintenance
                </h2>

                {{-- توضیحات دوزبانه --}}
                <div class="space-y-3 mb-9 max-w-lg mx-auto">
                    <p class="text-sm md:text-base text-gray-400 leading-relaxed">
                        برای ارتقای کیفیت خدمات و ارائه امکانات جدید، سیستم در حال بروزرسانی است. لطفاً پس از دقایقی دیگر مراجعه فرمایید.
                    </p>

                    <p dir="ltr" class="text-xs md:text-sm text-gray-500 leading-relaxed border-t border-gray-800/70 pt-3">
                        We are performing scheduled maintenance. Please check back soon.
                    </p>
                </div>

                {{-- اکشن‌ها --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5">
                    <a href="javascript:location.reload();" class="w-full sm:w-auto inline-flex items-center justify-center px-7 py-3.5 text-sm font-bold text-white bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 hover:from-blue-500 hover:to-sky-400 rounded-2xl transition-all shadow-xl shadow-blue-600/25 active:scale-[0.98]">
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        بررسی مجدد / Check Again
                    </a>
                </div>

                {{-- متادیتا انتهای کارت --}}
                <div class="mt-10 pt-6 border-t border-gray-800/80 flex items-center justify-center gap-2 text-xs font-mono text-gray-500">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                        AvaPark Maintenance Gate
                    </span>
                </div>

            </div>

        </div>
    </main>

    {{-- فوتر دوزبانه --}}
    <footer class="relative z-10 w-full text-center py-6 text-xs text-gray-500 border-t border-gray-900/80">
        &copy; {{ date('Y') }} {{ config('app.name', 'AvaPark') }}. کلیه حقوق محفوظ است / All rights reserved.
    </footer>

</body>
</html>

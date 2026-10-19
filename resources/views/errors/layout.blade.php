<!DOCTYPE html>
<html lang="fa" dir="rtl" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'AvaPark'))</title>

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
                STATUS: <span class="text-blue-400 font-bold">@yield('code', 'ERROR')</span>
            </span>
        </div>
    </header>

    {{-- محتوای اصلی صفحه خطا --}}
    <main class="relative z-10 flex-grow flex items-center justify-center px-5 py-10">
        <div class="w-full max-w-2xl relative">
            <div class="relative overflow-hidden rounded-[2.2rem] border border-gray-800/90 bg-gradient-to-b from-gray-900/85 via-gray-950/90 to-gray-950/95 p-8 md:p-12 shadow-2xl backdrop-blur-2xl text-center group">

                {{-- هاله‌های نوری کارت --}}
                <div aria-hidden="true" class="pointer-events-none absolute -right-24 -top-24 h-48 w-48 rounded-full bg-blue-600/20 blur-3xl transition-all duration-500 group-hover:bg-blue-600/30"></div>
                <div aria-hidden="true" class="pointer-events-none absolute -left-24 -bottom-24 h-48 w-48 rounded-full bg-indigo-600/10 blur-3xl"></div>

                @yield('content')

            </div>
        </div>
    </main>

    {{-- فوتر دوزبانه --}}
    <footer class="relative z-10 w-full text-center py-6 text-xs text-gray-500 border-t border-gray-900/80">
        &copy; {{ date('Y') }} {{ config('app.name', 'AvaPark') }}. کلیه حقوق محفوظ است / All rights reserved.
    </footer>

</body>
</html>

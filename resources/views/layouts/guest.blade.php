<!DOCTYPE html>
<html lang="fa" dir="rtl" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AvaPark') }}</title>

        <!-- Scripts & Styles via Vite (Local) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            [x-cloak] {
                display: none !important;
            }

            /* انیمیشن نرم ورود محتوا منحصراً برای دسکتاپ */
            @media (min-width: 768px) {
                main {
                    animation: guestDesktopFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                }

                @keyframes guestDesktopFadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
            }

            /* موبایل: لود مستقیم بدون انیمیشن و سبک */
            @media (max-width: 767px) {
                main {
                    opacity: 1 !important;
                    transform: none !important;
                    animation: none !important;
                }
            }

            @media (prefers-reduced-motion: reduce) {
                main {
                    animation: none !important;
                    opacity: 1 !important;
                    transform: none !important;
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-100 antialiased bg-gradient-to-br from-blue-950 via-gray-950 to-gray-950 min-h-screen relative overflow-x-hidden selection:bg-blue-600 selection:text-white">
        
        <!-- هاله‌ها و افکت‌های نوری پس‌زمینه هماهنگ با پروژه -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden" aria-hidden="true">
            <div class="absolute inset-0 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:28px_28px] opacity-20"></div>
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] md:w-[1000px] h-[300px] md:h-[400px] bg-blue-600/20 rounded-full blur-[100px] md:blur-[140px]"></div>
            <div class="absolute bottom-1/4 -left-40 w-[350px] h-[350px] bg-sky-600/15 rounded-full blur-[120px]"></div>
        </div>

        <!-- بدنه محتوا -->
        <main class="relative z-10 min-h-screen w-full flex flex-col justify-center items-center py-6 px-4 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </body>
</html>

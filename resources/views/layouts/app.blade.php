<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AvaPark') }}</title>

    <!-- Scripts & Tailwind Vite (کلیه اسکریپت‌ها از جمله Alpine.js و استایل‌ها به صورت محلی لود می‌شوند) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- استایل‌ها: انیمیشن‌ها اختصاصاً فقط برای دسکتاپ (min-width: 768px) -->
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* انیمیشن‌ها و ترنزیشن‌ها منحصراً در دسکتاپ فعال هستند */
        @media (min-width: 768px) {
            main {
                animation: desktopParentFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }

            @keyframes desktopParentFadeIn {
                from {
                    opacity: 0;
                    transform: translateY(6px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            [data-reveal] {
                opacity: 0;
                transform: translateY(24px);
                transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
                transition-delay: var(--reveal-delay, 0ms);
            }

            [data-reveal].is-revealed {
                opacity: 1;
                transform: translateY(0);
            }

            .auto-reveal-item {
                opacity: 0;
                transform: translateY(20px);
                transition: opacity 0.6s cubic-bezier(0.16, 1, 0.3, 1), transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
            }

            .auto-reveal-item.is-revealed {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* موبایل (زیر ۷۶۸ پیکسل): کاملاً استاتیک، صفر انیمیشن و سبک‌ترین حالت ممکن */
        @media (max-width: 767px) {
            main,
            [data-reveal],
            .auto-reveal-item {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
                animation: none !important;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            main, [data-reveal], .auto-reveal-item {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-100 min-h-screen bg-gradient-to-br from-blue-900 via-gray-950 to-gray-950 selection:bg-blue-600 selection:text-white relative overflow-x-hidden">
    
    <!-- لایه شبکه نقطه‌ای و هاله‌های نوری پس‌زمینه -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden" aria-hidden="true">
        <div class="absolute inset-0 bg-[radial-gradient(#3b82f6_1px,transparent_1px)] [background-size:28px_28px] opacity-20"></div>
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] md:w-[1100px] h-[300px] md:h-[450px] bg-blue-600/20 rounded-full blur-[100px] md:blur-[140px]"></div>
        <div class="absolute top-1/3 -right-40 w-[350px] h-[350px] bg-indigo-600/15 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 -left-40 w-[400px] h-[400px] bg-sky-600/15 rounded-full blur-[130px]"></div>
    </div>

    <!-- کانتینر محتوا -->
    <div class="relative z-10 min-h-screen flex flex-col justify-between">
        <div>
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-gray-900/50 border-b border-gray-800 backdrop-blur-sm sticky top-0 z-30">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-grow">
                {{ $slot }}
            </main>
        </div>

        @if (view()->exists('layouts.footer'))
            @include('layouts.footer')
        @endif
    </div>

    <!-- اسکریپت رصدگر اسکرول (فقط روی دسکتاپ اجرا می‌شود) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // گارد قاطع موبایل: روی دستگاه‌های زیر 768px هیچ کدی اجرا نمی‌شود
            if (window.innerWidth < 768) {
                return;
            }

            const setupObserver = (elements, isAutoMode) => {
                if (!elements.length) return;

                if (!('IntersectionObserver' in window)) {
                    elements.forEach(el => el.classList.add('is-revealed'));
                    return;
                }

                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;
                        entry.target.classList.add('is-revealed');
                        obs.unobserve(entry.target);
                    });
                }, {
                    threshold: 0.08,
                    rootMargin: '0px 0px 50px 0px'
                });

                elements.forEach((el, index) => {
                    if (isAutoMode) {
                        el.classList.add('auto-reveal-item');
                        el.style.transitionDelay = `${(index % 4) * 90}ms`;
                    } else {
                        const delay = parseInt(el.getAttribute('data-reveal-delay') || '0', 10);
                        if (delay > 0) {
                            el.style.setProperty('--reveal-delay', delay + 'ms');
                        }
                    }
                    observer.observe(el);
                });
            };

            setupObserver(document.querySelectorAll('[data-reveal]'), false);
            setupObserver(document.querySelectorAll('main .grid > div, main .space-y-6 > div:not(.grid)'), true);
        });
    </script>
</body>
</html>

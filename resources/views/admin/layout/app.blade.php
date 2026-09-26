<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AvaPark') }} | Admin</title>

    {{-- این کلاس قبل از نمایش صفحه اضافه می‌شود تا از پرش محتوا جلوگیری شود --}}
    <script>
        document.documentElement.classList.add('js');
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /*
         * انیمیشن ورود محتوای صفحات ادمین
         * فقط در تبلت و دسکتاپ اجرا می‌شود.
         */
        @media (min-width: 768px) {
            html.js .admin-page-reveal {
                opacity: 0;
                transform: translateY(18px);
                filter: blur(3px);
                transition:
                    opacity 650ms cubic-bezier(0.16, 1, 0.3, 1),
                    transform 650ms cubic-bezier(0.16, 1, 0.3, 1),
                    filter 500ms ease;
                will-change: opacity, transform, filter;
            }

            html.js .admin-page-reveal.is-visible {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        /*
         * در موبایل محتوا بدون انیمیشن نمایش داده می‌شود
         * تا عملکرد و سرعت اسکرول حفظ شود.
         */
        @media (max-width: 767px) {
            html.js .admin-page-reveal {
                opacity: 1;
                transform: none;
                filter: none;
            }
        }

        /*
         * احترام به تنظیم کاهش حرکت سیستم‌عامل کاربر
         */
        @media (prefers-reduced-motion: reduce) {
            html.js .admin-page-reveal {
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
                transition: none !important;
            }
        }

        /*
         * جلوگیری از نمایش لحظه‌ای عناصر Alpine قبل از آماده‌شدن آن
         */
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body
    class="font-sans antialiased text-gray-100"
    x-data="{ mobileMenu: false }"
    @keydown.escape.window="mobileMenu = false"
>
    <div class="min-h-screen bg-gradient-to-br from-blue-950 via-gray-950 to-gray-950">

        {{-- فراخوانی نوار ناوبری و منوی موبایل --}}
        @include('admin.layout.navigation')

        {{-- محتوای اصلی --}}
        <main class="py-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                {{--
                    تمام محتوای صفحات ادمین داخل این عنصر قرار می‌گیرد؛
                    بنابراین انیمیشن به‌صورت خودکار روی همه صفحات اجرا خواهد شد.
                --}}
                <div
                    id="admin-page-content"
                    class="admin-page-reveal"
                >
                    @yield('content')
                </div>

            </div>
        </main>

    </div>

    {{-- اجرای انیمیشن ورود صفحه --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const content = document.getElementById('admin-page-content');

            if (!content) {
                return;
            }

            const isDesktop = window.matchMedia('(min-width: 768px)').matches;
            const reduceMotion = window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

            /*
             * در موبایل یا در صورت فعال‌بودن کاهش حرکت،
             * محتوا بلافاصله نمایش داده می‌شود.
             */
            if (!isDesktop || reduceMotion) {
                content.classList.add('is-visible');
                return;
            }

            /*
             * دو فریم صبر می‌کنیم تا مرورگر ابتدا حالت مخفی را رسم کند
             * و سپس transition ورود اجرا شود.
             */
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    content.classList.add('is-visible');
                });
            });
        });
    </script>
</body>
</html>

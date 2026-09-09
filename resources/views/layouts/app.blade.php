<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProPark') }}</title>

        {{-- استایل‌های کامپایل‌شده --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        {{-- استایل ضروری x-cloak برای مخفی نگه داشتن منوها قبل از لود جاوااسکریپت --}}
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        {{-- اسکریپت Alpine.js برای مدیریت عملکرد کلیک، دراپ‌داون و منوی همبرگری --}}
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased text-gray-100">
        <div class="min-h-screen bg-gradient-to-br from-blue-900 via-gray-950 to-gray-950 flex flex-col justify-between">

            <div>
                @include('layouts.navigation')

                {{-- هدر --}}
                @isset($header)
                    <header class="bg-gray-900/50 border-b border-gray-800 backdrop-blur-sm">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                {{-- کانتنت سایت --}}
                <main>
                    {{ $slot }}
                </main>
            </div>

            {{-- فوتر --}}
            @include('layouts.footer')

        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ProPark') }}</title>

        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-100">
        <div class="min-h-screen bg-gradient-to-br from-blue-900 via-gray-950 to-gray-950">

            @include('layouts.navigation')

             {{-- هدر  --}}
            @isset($header)
                <header class="bg-gray-900/50 border-b border-gray-800 backdrop-blur-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{--  کانتنت سایت  --}}
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

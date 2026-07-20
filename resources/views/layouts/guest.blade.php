<!DOCTYPE html>
<html lang="fa" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-100 antialiased bg-gradient-to-br from-blue-900 via-gray-950 to-gray-950">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
            <div class="w-full sm:max-w-md mt-6 px-8 py-8  shadow-xl overflow-hidden rounded-3xl ">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>

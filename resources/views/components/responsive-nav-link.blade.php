@props(['active', 'color' => 'gray'])

@php
    // رنگ‌ها را بر اساس متغیر color تنظیم کن
    $colorClasses = ($color === 'red') 
        ? 'text-red-500 hover:text-red-400 hover:bg-red-950/30' 
        : 'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50';
    
    // ... بقیه کدهای کلاس (مثل بوردرها و ...)
@endphp

<a {{ $attributes->merge(['class' => 'block ... ' . $colorClasses]) }}>
    {{ $slot }}
</a>

@extends('admin.layout.app')

@section('title', 'مدیریت دسته‌بندی‌ها')

@section('content')
@php
    $totalCategories = method_exists($categories, 'total')
        ? $categories->total()
        : $categories->count();
@endphp

<div class="space-y-6">

    {{-- هدر صفحه با هاله نوری و استایل یکپارچه --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-gray-900 via-gray-900/90 to-gray-950 p-6 md:p-8 border border-gray-800/80 shadow-2xl backdrop-blur-xl">
        {{-- هاله‌های نور پس‌زمینه نئونی --}}
        <div class="absolute -top-16 -left-16 w-56 h-56 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-48 h-48 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-2xl text-blue-400 border border-blue-500/30 shadow-inner">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M4 5a2 2 0 012-2h4l2 3h6a2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-white tracking-tight">
                        مدیریت دسته‌بندی‌ها
                    </h1>
                    <p class="text-xs md:text-sm text-gray-400 mt-1">
                        دسته‌بندی‌های وبلاگ را ایجاد، سازمان‌دهی و مدیریت کنید.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.posts.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-800/80 px-4 py-2.5 text-xs font-medium text-gray-300 transition hover:border-blue-500/40 hover:bg-gray-800 hover:text-white backdrop-blur-md">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    بازگشت به مقالات
                </a>
            </div>
        </div>
    </div>

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-400 backdrop-blur-md">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-emerald-500/20 bg-emerald-500/10 text-emerald-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="pt-1">
                <p class="font-semibold">عملیات موفق</p>
                <p class="mt-1 text-emerald-400/90">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- خطاهای اعتبارسنجی --}}
    @if($errors->any())
        <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-400 backdrop-blur-md">
            <div class="mb-2 flex items-center gap-2 font-semibold">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z"/>
                </svg>
                لطفاً خطاهای زیر را بررسی کنید.
            </div>

            <ul class="list-inside list-disc space-y-1 text-rose-300/90">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- کارت آمار --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/60 backdrop-blur-md p-5 shadow-lg group hover:border-blue-500/40 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400">تعداد کل دسته‌بندی‌ها</p>
                    <p class="mt-3 text-3xl font-bold text-white font-mono">
                        {{ number_format($totalCategories) }}
                    </p>
                    <p class="mt-1 text-[11px] text-gray-500">مجموع دسته‌بندی‌های ثبت‌شده</p>
                </div>

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5a2 2 0 012-2h4l2 3h6a2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-2xl border border-gray-800 bg-gray-900/60 backdrop-blur-md p-5 shadow-lg group hover:border-cyan-500/40 transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium text-gray-400">دسترسی سریع</p>
                    <p class="mt-3 text-lg font-bold text-white">مقالات وبلاگ</p>
                    <p class="mt-1 text-[11px] text-gray-500">مدیریت محتوای منتشرشده و پیش‌نویس‌ها</p>
                </div>

                <a href="{{ route('admin.posts.index') }}"
                   aria-label="رفتن به مقالات وبلاگ"
                   class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-400 border border-cyan-500/20 transition hover:bg-cyan-500/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.5H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2v-10a2 2 0 00-2-2h-7m0 0V3m0 3l-3-3m3 3l3-3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- فرم و جدول --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- افزودن دسته‌بندی --}}
        <section class="h-fit overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg">
            <div class="border-b border-gray-800 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-white text-sm">دسته‌بندی جدید</h2>
                        <p class="mt-0.5 text-xs text-gray-500">اطلاعات دسته‌بندی را وارد کنید.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.categories.store') }}"
                  method="POST"
                  class="space-y-4 p-5 sm:p-6">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-xs font-medium text-gray-300">
                        نام دسته‌بندی
                        <span class="text-rose-400">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        id="name"
                        required
                        maxlength="255"
                        value="{{ old('name') }}"
                        placeholder="مثلاً: آموزش سئو"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2 block text-xs font-medium text-gray-300">
                        نامک (Slug)
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        value="{{ old('slug') }}"
                        dir="ltr"
                        placeholder="seo-training"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-left text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    <p class="mt-1.5 text-[11px] leading-relaxed text-gray-500">
                        در صورت خالی گذاشتن، به‌صورت خودکار ساخته می‌شود.
                    </p>

                    @error('slug')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="mb-2 block text-xs font-medium text-gray-300">
                        توضیحات
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="3"
                        placeholder="توضیح کوتاهی درباره این دسته‌بندی..."
                        class="w-full resize-y rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm leading-relaxed text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-500 px-4 py-3 text-sm font-medium text-white shadow-lg shadow-blue-600/20 transition active:scale-[0.98]"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                    </svg>
                    <span>افزودن دسته‌بندی</span>
                </button>
            </form>
        </section>

        {{-- لیست دسته‌بندی‌ها --}}
        <section class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg xl:col-span-2">

            <div class="flex flex-col gap-3 border-b border-gray-800 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div>
                    <h2 class="font-bold text-white text-sm">لیست دسته‌بندی‌ها</h2>
                    <p class="mt-0.5 text-xs text-gray-500">مدیریت و ویرایش دسته‌بندی‌های وبلاگ</p>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-xl border border-gray-800 bg-gray-950/60 px-3 py-1.5 text-xs font-mono text-gray-300">
                    مجموع: <strong class="font-bold text-white">{{ number_format($totalCategories) }}</strong>
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-right text-sm">
                    <thead class="border-b border-gray-800 bg-gray-950/60 text-gray-400 text-xs uppercase font-medium">
                        <tr>
                            <th class="px-6 py-3.5">دسته‌بندی</th>
                            <th class="px-6 py-3.5">نامک</th>
                            <th class="px-6 py-3.5 text-center">مقالات</th>
                            <th class="px-6 py-3.5 text-center">عملیات</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800/60">
                        @forelse($categories as $category)
                            <tr class="transition duration-150 hover:bg-gray-800/40">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-800 bg-gray-800/70 text-sm font-bold text-blue-400 font-mono">
                                            {{ mb_substr($category->name, 0, 1) }}
                                        </div>

                                        <div class="min-w-0">
                                            <p class="font-medium text-white text-sm">
                                                {{ $category->name }}
                                            </p>
                                            @if($category->description)
                                                <p class="mt-0.5 max-w-xs truncate text-xs text-gray-500"
                                                   title="{{ $category->description }}">
                                                    {{ $category->description }}
                                                </p>
                                            @else
                                                <p class="mt-0.5 text-xs text-gray-600">بدون توضیحات</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span dir="ltr" class="inline-block max-w-44 truncate rounded-lg border border-gray-800 bg-gray-950/80 px-2.5 py-1 font-mono text-xs text-gray-400">
                                        {{ $category->slug }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex min-w-8 items-center justify-center rounded-lg border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-mono font-medium text-cyan-400">
                                        {{ $category->posts_count ?? $category->posts()->count() }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-blue-500/30 bg-blue-600/10 px-3 py-2 text-xs font-medium text-blue-400 transition hover:bg-blue-600 hover:text-white"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            ویرایش
                                        </a>

                                        <form
                                            action="{{ route('admin.categories.destroy', $category) }}"
                                            method="POST"
                                            class="inline"
                                            onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 py-2 text-xs font-medium text-rose-400 transition hover:bg-rose-600 hover:text-white"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 7h12m-10 0V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0l-1 13H7L6 7m4 4v5m4-5v5"/>
                                                </svg>
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-gray-800 bg-gray-800/70 text-gray-500">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a2 2 0 012-2h4l2 3h6a2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                                        </svg>
                                    </div>

                                    <p class="mt-4 font-semibold text-gray-300 text-sm">
                                        هنوز دسته‌بندی‌ای ایجاد نشده است.
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        از فرم کنار صفحه برای ایجاد اولین دسته‌بندی استفاده کنید.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($categories, 'hasPages') && $categories->hasPages())
                <div class="border-t border-gray-800 bg-gray-950/40 p-4 sm:p-5">
                    {{ $categories->links() }}
                </div>
            @endif
        </section>

    </div>
</div>
@endsection


@extends('admin.layout.app')

@section('title', 'مدیریت دسته‌بندی‌ها')

@section('content')
@php
    $totalCategories = method_exists($categories, 'total')
        ? $categories->total()
        : $categories->count();
@endphp

<div class="space-y-8">

    {{-- هدر صفحه --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="h-1.5 w-7 rounded-full bg-blue-500"></span>
                <span class="text-xs font-medium text-blue-400">مدیریت محتوا</span>
            </div>

            <h1 class="text-2xl font-bold text-white">
                مدیریت دسته‌بندی‌ها
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                دسته‌بندی‌های وبلاگ را ایجاد، سازمان‌دهی و مدیریت کنید.
            </p>
        </div>

        <a href="{{ route('admin.posts.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-900/70 px-4 py-2.5 text-sm font-medium text-gray-300 transition hover:border-blue-700 hover:bg-gray-800 hover:text-white">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            بازگشت به مقالات
        </a>
    </div>

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-800/70 bg-emerald-950/30 p-4 text-sm text-emerald-300">
            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-emerald-800 bg-emerald-900/30">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="pt-1">
                <p class="font-semibold">عملیات موفق</p>
                <p class="mt-1 text-emerald-300/80">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- خطاهای اعتبارسنجی --}}
    @if($errors->any())
        <div class="rounded-2xl border border-rose-800/70 bg-rose-950/30 p-4 text-sm text-rose-300">
            <div class="mb-2 flex items-center gap-2 font-semibold">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z"/>
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
        <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 p-5 transition duration-300 hover:border-blue-700/50">
            <div class="absolute -left-8 -top-10 h-32 w-32 rounded-full bg-blue-600/10 blur-3xl"></div>

            <div class="relative flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-400">تعداد کل دسته‌بندی‌ها</p>
                    <p class="mt-3 text-3xl font-bold text-white">
                        {{ number_format($totalCategories) }}
                    </p>
                    <p class="mt-2 text-xs text-gray-500">مجموع دسته‌بندی‌های ثبت‌شده</p>
                </div>

                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-blue-700/60 bg-blue-600/15 text-blue-400">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.7" d="M4 5a2 2 0 012-2h4l2 3h6a2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 p-5 transition duration-300 hover:border-cyan-700/50">
            <div class="absolute -left-8 -top-10 h-32 w-32 rounded-full bg-cyan-600/10 blur-3xl"></div>

            <div class="relative flex items-center justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-400">دسترسی سریع</p>
                    <p class="mt-3 text-lg font-bold text-white">مقالات وبلاگ</p>
                    <p class="mt-2 text-xs text-gray-500">مدیریت محتوای منتشرشده و پیش‌نویس‌ها</p>
                </div>

                <a href="{{ route('admin.posts.index') }}"
                   aria-label="رفتن به مقالات وبلاگ"
                   class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border border-cyan-700/60 bg-cyan-600/15 text-cyan-400 transition hover:bg-cyan-600/25">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="1.7" d="M12 6.5H5a2 2 0 00-2 2v10a2 2 0 002 2h14a2 2 0 002-2v-10a2 2 0 00-2-2h-7m0 0V3m0 3l-3-3m3 3l3-3"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    {{-- فرم و جدول --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- افزودن دسته‌بندی --}}
        <section class="h-fit overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-xl shadow-black/10">
            <div class="border-b border-gray-800 bg-gray-900/60 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-blue-700/50 bg-blue-600/15 text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M12 5v14m-7-7h14"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-white">دسته‌بندی جدید</h2>
                        <p class="mt-1 text-xs text-gray-500">اطلاعات دسته‌بندی را وارد کنید.</p>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.categories.store') }}"
                  method="POST"
                  class="space-y-5 p-5 sm:p-6">
                @csrf

                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-gray-300">
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
                        class="w-full rounded-xl border border-gray-700 bg-gray-950/70 px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    @error('name')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="mb-2 block text-sm font-medium text-gray-300">
                        نامک (Slug)
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        value="{{ old('slug') }}"
                        dir="ltr"
                        placeholder="seo-training"
                        class="w-full rounded-xl border border-gray-700 bg-gray-950/70 px-4 py-3 text-left text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        در صورت پشتیبانی بک‌اند، نامک خالی به‌صورت خودکار ساخته می‌شود.
                    </p>

                    @error('slug')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-300">
                        توضیحات
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        placeholder="توضیح کوتاهی درباره این دسته‌بندی بنویسید..."
                        class="w-full resize-y rounded-xl border border-gray-700 bg-gray-950/70 px-4 py-3 text-sm leading-6 text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-blue-500/30 bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-950/20 transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/40"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2" d="M12 5v14m-7-7h14"/>
                    </svg>
                    افزودن دسته‌بندی
                </button>
            </form>
        </section>

        {{-- لیست دسته‌بندی‌ها --}}
        <section class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-xl shadow-black/10 xl:col-span-2">

            <div class="flex flex-col gap-3 border-b border-gray-800 bg-gray-900/60 p-5 sm:flex-row sm:items-center sm:justify-between sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="h-7 w-1.5 rounded-full bg-blue-500"></span>

                    <div>
                        <h2 class="font-bold text-white">لیست دسته‌بندی‌ها</h2>
                        <p class="mt-1 text-xs text-gray-500">مدیریت و ویرایش دسته‌بندی‌های وبلاگ</p>
                    </div>
                </div>

                <span class="inline-flex w-fit items-center gap-2 rounded-xl border border-gray-700 bg-gray-950/60 px-3 py-2 text-xs text-gray-300">
                    <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                    مجموع:
                    <strong class="font-bold text-white">{{ number_format($totalCategories) }}</strong>
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-right text-sm">
                    <thead class="border-b border-gray-800 bg-gray-950/50">
                        <tr class="text-xs font-semibold text-gray-400">
                            <th class="whitespace-nowrap px-5 py-4">دسته‌بندی</th>
                            <th class="whitespace-nowrap px-5 py-4">نامک</th>
                            <th class="whitespace-nowrap px-5 py-4 text-center">مقالات</th>
                            <th class="whitespace-nowrap px-5 py-4 text-center">عملیات</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800/80">
                        @forelse($categories as $category)
                            <tr class="transition duration-200 hover:bg-gray-800/30">
                                <td class="min-w-44 px-5 py-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-blue-800/50 bg-blue-950/50 text-xs font-bold text-blue-400">
                                            {{ mb_substr($category->name, 0, 1) }}
                                        </div>

                                        <div class="min-w-0 pt-0.5">
                                            <p class="font-semibold text-gray-100">
                                                {{ $category->name }}
                                            </p>

                                            @if($category->description)
                                                <p class="mt-1 max-w-xs truncate text-xs text-gray-500"
                                                   title="{{ $category->description }}">
                                                    {{ $category->description }}
                                                </p>
                                            @else
                                                <p class="mt-1 text-xs text-gray-600">بدون توضیحات</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    <span dir="ltr" class="inline-block max-w-44 truncate rounded-lg border border-gray-800 bg-gray-950/60 px-2.5 py-1.5 font-mono text-xs text-gray-400">
                                        {{ $category->slug }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex min-w-9 items-center justify-center rounded-lg border border-cyan-800/50 bg-cyan-950/40 px-2.5 py-1.5 text-xs font-semibold text-cyan-300">
                                        {{ $category->posts_count ?? $category->posts()->count() }}
                                    </span>
                                </td>

                                <td class="px-5 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a
                                            href="{{ route('admin.categories.edit', $category) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-blue-800/60 bg-blue-950/40 px-3 py-2 text-xs font-medium text-blue-300 transition hover:border-blue-600 hover:bg-blue-900/50 hover:text-blue-200"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
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
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-800/60 bg-rose-950/30 px-3 py-2 text-xs font-medium text-rose-300 transition hover:border-rose-600 hover:bg-rose-900/40 hover:text-rose-200"
                                            >
                                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M6 7h12m-10 0V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0l-1 13H7L6 7m4 4v5m4-5v5"/>
                                                </svg>
                                                حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-16 text-center">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl border border-gray-700 bg-gray-800/60 text-gray-500">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="1.5" d="M4 5a2 2 0 012-2h4l2 3h6a2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5z"/>
                                        </svg>
                                    </div>

                                    <p class="mt-4 font-semibold text-gray-300">
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
                <div class="border-t border-gray-800 bg-gray-900/40 p-4 sm:p-5">
                    {{ $categories->links() }}
                </div>
            @endif
        </section>

    </div>
</div>
@endsection

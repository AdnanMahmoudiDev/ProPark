
@extends('admin.layout.app')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
<div class="space-y-8">

    {{-- هدر صفحه --}}
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2">
                <span class="h-1.5 w-7 rounded-full bg-blue-500"></span>
                <span class="text-xs font-medium text-blue-400">مدیریت محتوا</span>
            </div>

            <h1 class="text-2xl font-bold text-white">
                ویرایش دسته‌بندی
            </h1>

            <p class="mt-2 text-sm text-gray-400">
                اطلاعات دسته‌بندی را تغییر دهید و تغییرات را ذخیره کنید.
            </p>
        </div>

        <a
            href="{{ route('admin.categories.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-900/70 px-4 py-2.5 text-sm font-medium text-gray-300 transition hover:border-blue-700 hover:bg-gray-800 hover:text-white"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            بازگشت به دسته‌بندی‌ها
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
                لطفاً اطلاعات واردشده را بررسی کنید.
            </div>

            <ul class="list-inside list-disc space-y-1 text-rose-300/90">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- فرم ویرایش --}}
        <section class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-xl shadow-black/10 xl:col-span-2">

            <div class="border-b border-gray-800 bg-gray-900/60 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-blue-700/50 bg-blue-600/15 text-blue-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-white">اطلاعات دسته‌بندی</h2>
                        <p class="mt-1 text-xs text-gray-500">
                            فیلدهای موردنظر را ویرایش کنید.
                        </p>
                    </div>
                </div>
            </div>

            <form
                action="{{ route('admin.categories.update', $category) }}"
                method="POST"
                class="space-y-6 p-5 sm:p-7"
            >
                @csrf
                @method('PUT')

                {{-- نام دسته‌بندی --}}
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
                        value="{{ old('name', $category->name) }}"
                        placeholder="مثلاً: آموزش سئو"
                        class="w-full rounded-xl border border-gray-700 bg-gray-950/70 px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    @error('name')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- نامک --}}
                <div>
                    <label for="slug" class="mb-2 block text-sm font-medium text-gray-300">
                        نامک (Slug)
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        value="{{ old('slug', $category->slug) }}"
                        dir="ltr"
                        placeholder="seo-training"
                        class="w-full rounded-xl border border-gray-700 bg-gray-950/70 px-4 py-3 text-left text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        نامک معمولاً در آدرس صفحه استفاده می‌شود؛ پس از تغییر آن، سازوکار تولید نامک در بک‌اند را در نظر بگیرید.
                    </p>

                    @error('slug')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- توضیحات --}}
                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-gray-300">
                        توضیحات
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="5"
                        placeholder="توضیح کوتاهی درباره این دسته‌بندی بنویسید..."
                        class="w-full resize-y rounded-xl border border-gray-700 bg-gray-950/70 px-4 py-3 text-sm leading-7 text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <p class="mt-2 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- عملیات فرم --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-800 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-700 bg-gray-950/50 px-5 py-3 text-sm font-medium text-gray-300 transition hover:border-gray-600 hover:bg-gray-800 hover:text-white"
                    >
                        انصراف
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-blue-500/30 bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-blue-950/20 transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/40"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </section>

        {{-- پنل اطلاعات دسته‌بندی --}}
        <aside class="space-y-6">

            <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 p-5 sm:p-6">
                <div class="absolute -left-10 -top-10 h-36 w-36 rounded-full bg-blue-600/10 blur-3xl"></div>

                <div class="relative">
                    <div class="mb-5 flex items-center gap-2">
                        <span class="h-6 w-1.5 rounded-full bg-blue-500"></span>
                        <h3 class="font-bold text-white">نمای کلی</h3>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-gray-800 bg-gray-950/50 p-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl border border-blue-800/50 bg-blue-950/50 text-lg font-bold text-blue-400">
                            {{ mb_substr($category->name, 0, 1) }}
                        </div>

                        <div class="min-w-0">
                            <p class="truncate font-semibold text-gray-100">
                                {{ $category->name }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                دسته‌بندی انتخاب‌شده
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between gap-3 border-b border-gray-800/80 pb-3">
                            <span class="text-sm text-gray-400">شناسه</span>
                            <span class="rounded-lg border border-gray-700 bg-gray-950/60 px-2.5 py-1 font-mono text-xs text-gray-300">
                                #{{ $category->id }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-3 border-b border-gray-800/80 pb-3">
                            <span class="text-sm text-gray-400">تعداد مقالات</span>
                            <span class="rounded-lg border border-cyan-800/50 bg-cyan-950/40 px-2.5 py-1 text-xs font-semibold text-cyan-300">
                                {{ $category->posts_count ?? $category->posts()->count() }}
                            </span>
                        </div>

                        <div class="space-y-2">
                            <span class="block text-sm text-gray-400">نامک فعلی</span>
                            <p dir="ltr" class="break-all rounded-xl border border-gray-800 bg-gray-950/60 p-3 text-left font-mono text-xs leading-6 text-gray-400">
                                {{ $category->slug }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- راهنما --}}
            <div class="rounded-3xl border border-cyan-900/50 bg-cyan-950/20 p-5 sm:p-6">
                <div class="flex items-start gap-3">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-cyan-800/60 bg-cyan-900/30 text-cyan-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="M12 18h.01M12 14a4 4 0 10-4-4m4 4V9"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-semibold text-cyan-300">نکات ویرایش</h3>

                        <ul class="mt-3 space-y-2 text-xs leading-6 text-gray-400">
                            <li>• نام دسته‌بندی را واضح و قابل فهم انتخاب کنید.</li>
                            <li>• برای نامک از حروف انگلیسی، اعداد و خط تیره استفاده کنید.</li>
                            <li>• پیش از ذخیره، تغییرات را بررسی کنید.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- بازگشت به فهرست --}}
            <a
                href="{{ route('admin.categories.index') }}"
                class="flex items-center justify-between rounded-2xl border border-gray-800 bg-gray-900/50 p-4 text-sm text-gray-300 transition hover:border-blue-800/60 hover:bg-gray-900 hover:text-white"
            >
                <span>مشاهده همه دسته‌بندی‌ها</span>

                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

        </aside>
    </div>
</div>
@endsection

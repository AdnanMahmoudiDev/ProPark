@extends('admin.layout.app')

@section('title', 'ویرایش دسته‌بندی')

@section('content')
<div class="space-y-6">

    {{-- هدر صفحه با هاله نوری و استایل یکپارچه نئونی --}}
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
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-white tracking-tight">
                        ویرایش دسته‌بندی
                    </h1>
                    <p class="text-xs md:text-sm text-gray-400 mt-1">
                        اطلاعات دسته‌بندی را تغییر دهید و تغییرات را ذخیره کنید.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-800/80 px-4 py-2.5 text-xs font-medium text-gray-300 transition hover:border-blue-500/40 hover:bg-gray-800 hover:text-white backdrop-blur-md"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    بازگشت به دسته‌بندی‌ها
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

        {{-- فرم ویرایش دسته‌بندی --}}
        <section class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg xl:col-span-2">

            <div class="border-b border-gray-800 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 p-5 sm:p-6">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-bold text-white text-sm">اطلاعات دسته‌بندی</h2>
                        <p class="mt-0.5 text-xs text-gray-500">
                            فیلدهای موردنظر را ویرایش کنید.
                        </p>
                    </div>
                </div>
            </div>

            <form
                action="{{ route('admin.categories.update', $category) }}"
                method="POST"
                class="space-y-5 p-5 sm:p-7"
            >
                @csrf
                @method('PUT')

                {{-- نام دسته‌بندی --}}
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
                        value="{{ old('name', $category->name) }}"
                        placeholder="مثلاً: آموزش سئو"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    @error('name')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- نامک (Slug) --}}
                <div>
                    <label for="slug" class="mb-2 block text-xs font-medium text-gray-300">
                        نامک (Slug)
                    </label>

                    <input
                        type="text"
                        name="slug"
                        id="slug"
                        value="{{ old('slug', $category->slug) }}"
                        dir="ltr"
                        placeholder="seo-training"
                        class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-left text-sm text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >

                    <p class="mt-1.5 text-[11px] leading-relaxed text-gray-500">
                        نامک معمولاً در آدرس صفحه استفاده می‌شود؛ پس از تغییر آن، ساختار پیوندها را در نظر داشته باشید.
                    </p>

                    @error('slug')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- توضیحات --}}
                <div>
                    <label for="description" class="mb-2 block text-xs font-medium text-gray-300">
                        توضیحات
                    </label>

                    <textarea
                        name="description"
                        id="description"
                        rows="4"
                        placeholder="توضیح کوتاهی درباره این دسته‌بندی بنویسید..."
                        class="w-full resize-y rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm leading-relaxed text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                    >{{ old('description', $category->description) }}</textarea>

                    @error('description')
                        <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- عملیات فرم --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-800/80 pt-5 sm:flex-row sm:items-center sm:justify-between">
                    <a
                        href="{{ route('admin.categories.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-gray-800 bg-gray-950 px-5 py-2.5 text-xs font-medium text-gray-400 transition hover:border-gray-700 hover:bg-gray-900 hover:text-white"
                    >
                        انصراف
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-500 px-5 py-2.5 text-xs font-medium text-white shadow-lg shadow-blue-600/20 transition active:scale-[0.98]"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </section>

        {{-- پنل سایدبار اطلاعات دسته‌بندی --}}
        <aside class="space-y-6">

            <div class="relative overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md p-5 sm:p-6 shadow-lg">
                <div class="absolute -left-10 -top-10 h-36 w-36 rounded-full bg-blue-600/10 blur-3xl pointer-events-none"></div>

                <div class="relative">
                    <div class="mb-5 flex items-center gap-2">
                        <span class="h-5 w-1.5 rounded-full bg-blue-500"></span>
                        <h3 class="font-bold text-white text-sm">نمای کلی</h3>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-gray-800 bg-gray-950/70 p-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-blue-500/20 bg-blue-500/10 text-base font-bold text-blue-400 font-mono">
                            {{ mb_substr($category->name, 0, 1) }}
                        </div>

                        <div class="min-w-0">
                            <p class="truncate font-semibold text-white text-sm">
                                {{ $category->name }}
                            </p>
                            <p class="mt-0.5 text-xs text-gray-500">
                                دسته‌بندی انتخاب‌شده
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <div class="flex items-center justify-between gap-3 border-b border-gray-800/80 pb-3">
                            <span class="text-xs text-gray-400">شناسه</span>
                            <span class="rounded-lg border border-gray-800 bg-gray-950 px-2.5 py-1 font-mono text-xs text-gray-300">
                                #{{ $category->id }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-3 border-b border-gray-800/80 pb-3">
                            <span class="text-xs text-gray-400">تعداد مقالات مرتبط</span>
                            <span class="rounded-lg border border-cyan-500/20 bg-cyan-500/10 px-2.5 py-1 text-xs font-mono font-medium text-cyan-400">
                                {{ $category->posts_count ?? $category->posts()->count() }}
                            </span>
                        </div>

                        <div class="space-y-1.5">
                            <span class="block text-xs text-gray-400">نامک فعلی</span>
                            <p dir="ltr" class="break-all rounded-xl border border-gray-800 bg-gray-950 px-3 py-2 text-left font-mono text-xs text-gray-400">
                                {{ $category->slug }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- باکس راهنما --}}
            <div class="rounded-3xl border border-cyan-500/20 bg-cyan-500/5 backdrop-blur-md p-5 sm:p-6 shadow-lg">
                <div class="flex items-start gap-3">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-cyan-500/20 bg-cyan-500/10 text-cyan-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M12 14a4 4 0 10-4-4m4 4V9"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-semibold text-cyan-300 text-xs">نکات ویرایش</h3>

                        <ul class="mt-2.5 space-y-1.5 text-xs text-gray-400 leading-relaxed">
                            <li>• نام دسته‌بندی را رسا و واضح انتخاب کنید.</li>
                            <li>• برای نامک بهتر است از حروف انگلیسی، اعداد و خط تیره استفاده شود.</li>
                            <li>• پیش از ذخیره، صحت اطلاعات را بازبینی فرمایید.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- بازگشت به فهرست --}}
            <a
                href="{{ route('admin.categories.index') }}"
                class="flex items-center justify-between rounded-2xl border border-gray-800 bg-gray-900/60 p-4 text-xs font-medium text-gray-300 transition hover:border-blue-500/40 hover:bg-gray-800/80 hover:text-white backdrop-blur-md"
            >
                <span>مشاهده همه دسته‌بندی‌ها</span>

                <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

        </aside>
    </div>
</div>
@endsection

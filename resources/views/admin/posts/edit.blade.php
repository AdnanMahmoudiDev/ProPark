@extends('admin.layout.app')

@section('title', 'ویرایش مقاله: ' . $post->title)

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
                <div class="p-3 bg-gradient-to-br from-amber-500/20 to-orange-500/20 rounded-2xl text-amber-400 border border-amber-500/30 shadow-inner">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-white tracking-tight">
                        ویرایش مقاله: {{ $post->title }}
                    </h1>
                    <p class="text-xs md:text-sm text-gray-400 mt-1">
                        در حال ویرایش محتوا، متادیتای سئو و تنظیمات انتشار مقاله هستید.
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.posts.index') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-800/80 px-4 py-2.5 text-xs font-medium text-gray-300 transition hover:border-blue-500/40 hover:bg-gray-800 hover:text-white backdrop-blur-md">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    بازگشت به لیست مقالات
                </a>
            </div>
        </div>
    </div>

    {{-- پیام‌های خطای اعتبارسنجی --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-400 backdrop-blur-md">
            <div class="mb-2 flex items-center gap-2 font-semibold">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.7 3.86a2 2 0 00-3.4 0z"/>
                </svg>
                خطا در بروزرسانی اطلاعات:
            </div>
            <ul class="list-inside list-disc space-y-1 text-xs text-rose-300/90">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- فرم ویرایش مقاله --}}
    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ستون اصلی (۲ سوم صفحه): مشخصات، محتوا، سئو -->
            <div class="lg:col-span-2 space-y-6">

                <!-- مشخصات پایه: عنوان، اسلاگ، خلاصه -->
                <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-300 mb-2">
                            عنوان مقاله <span class="text-rose-400">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $post->title) }}"
                               required
                               placeholder="عنوان مقاله..."
                               class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm font-semibold text-white placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">
                            نامک یکتا (Slug)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug', $post->slug) }}"
                               placeholder="نامک مقاله"
                               class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-xs text-gray-200 placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                               dir="ltr">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">
                            چکیده / خلاصه مقاله
                        </label>
                        <textarea name="summary"
                                  rows="3"
                                  placeholder="خلاصه کوتاهی از مقاله جهت نمایش در کارت‌ها و شبکه‌های اجتماعی..."
                                  class="w-full resize-y rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm leading-relaxed text-gray-200 placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('summary', $post->summary) }}</textarea>
                    </div>
                </div>

                <!-- ادیتور متن اصلی مقاله -->
                <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg p-6">
                    <label class="block text-xs font-semibold text-gray-300 mb-3">
                        متن اصلی مقاله <span class="text-rose-400">*</span>
                    </label>
                    <textarea id="editor" name="content" class="w-full min-h-[450px] rounded-xl">{{ old('content', $post->content) }}</textarea>
                </div>

                <!-- بخش سئو (SEO) -->
                <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg p-6 space-y-5">
                    <div class="flex items-center gap-3 border-b border-gray-800/80 pb-4">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-white">
                                بهینه‌سازی برای موتورهای جستجو (SEO)
                            </h3>
                            <p class="text-[11px] text-gray-500">تنظیمات متاتگ‌ها جهت بهبود رتبه در موتورهای جستجو</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">
                            عنوان سئو (Meta Title)
                        </label>
                        <input type="text"
                               name="meta_title"
                               maxlength="70"
                               value="{{ old('meta_title', $post->meta_title) }}"
                               placeholder="عنوان سئو (حداکثر ۷۰ کاراکتر)"
                               class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm text-gray-200 placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">
                            توضیحات متا (Meta Description)
                        </label>
                        <textarea name="meta_description"
                                  maxlength="160"
                                  rows="2"
                                  placeholder="توضیحات متا برای نمایش در نتایج گوگل (حداکثر ۱۶۰ کاراکتر)"
                                  class="w-full resize-y rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm leading-relaxed text-gray-200 placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">
                                کلمات کلیدی (با کاما جدا کنید)
                            </label>
                            <input type="text"
                                   name="meta_keywords"
                                   value="{{ old('meta_keywords', $post->meta_keywords) }}"
                                   placeholder="پارکینگ هوشمند, نرم افزار آواپارک"
                                   class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm text-gray-200 placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-2">
                                آدرس کانونیکال (Canonical URL)
                            </label>
                            <input type="url"
                                   name="canonical_url"
                                   value="{{ old('canonical_url', $post->canonical_url) }}"
                                   placeholder="https://..."
                                   class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-left font-mono text-xs text-gray-200 placeholder-gray-600 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20"
                                   dir="ltr">
                        </div>
                    </div>
                </div>

            </div>

            <!-- ستون کناری: تنظیمات انتشار و تصویر شاخص -->
            <div class="space-y-6">

                <!-- تنظیمات وضعیت انتشار -->
                <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg p-6 space-y-5">
                    <div class="flex items-center gap-2 border-b border-gray-800/80 pb-3">
                        <span class="h-4 w-1.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-sm font-bold text-white">
                            تنظیمات انتشار
                        </h3>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">
                            وضعیت انتشار
                        </label>
                        <select name="status"
                                class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm font-medium text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>انتشار عمومی</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-2">
                            دسته‌بندی
                        </label>
                        <select name="category_id"
                                class="w-full rounded-xl border border-gray-800 bg-gray-950 px-4 py-3 text-sm text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                            <option value="">بدون دسته‌بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-500 px-4 py-3 text-sm font-medium text-white shadow-lg shadow-blue-600/20 transition active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>ذخیره تغییرات</span>
                    </button>
                </div>

                <!-- تصویر شاخص -->
                <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg p-6 space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-800/80 pb-3">
                        <span class="h-4 w-1.5 rounded-full bg-cyan-500"></span>
                        <h3 class="text-sm font-bold text-white">
                            تصویر شاخص
                        </h3>
                    </div>

                    <div class="space-y-3">
                        <div id="preview-box"
                             class="{{ $post->featured_image ? '' : 'hidden' }} w-full h-44 rounded-2xl overflow-hidden border border-gray-800 bg-gray-950 relative shadow-inner">
                            <img id="image-preview"
                                 src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : '#' }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover">
                        </div>

                        <label class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-gray-800 hover:border-blue-500/50 rounded-2xl cursor-pointer bg-gray-950/60 hover:bg-gray-900/60 transition group">
                            <div class="flex flex-col items-center justify-center py-4">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-800 text-gray-400 group-hover:text-blue-400 group-hover:bg-blue-500/10 transition mb-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-xs text-gray-300 font-medium">انتخاب یا جایگزینی تصویر</p>
                                <p class="text-[10px] text-gray-500 mt-1">PNG, JPG, WEBP (حداکثر ۳ مگابایت)</p>
                            </div>
                            <input type="file"
                                   name="featured_image"
                                   id="featured_image_input"
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewThumbnail(this)">
                        </label>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div>

<!-- کتابخانه محلی TinyMCE -->
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

<script>
    // ۱. راه‌اندازی ادیتور TinyMCE
    tinymce.init({
        selector: '#editor',
        base_url: '{{ asset("vendor/tinymce") }}',
        suffix: '.min',
        license_key: 'gpl',
        height: 480,
        directionality: 'rtl',
        skin: 'oxide-dark',
        content_css: 'dark',
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table wordcount directionality',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | ltr rtl | bullist numlist | link image media | code fullscreen',
        content_style: 'body { font-family: Tahoma, sans-serif; font-size: 14px; direction: rtl; text-align: right; color: #ffffff !important; background-color: #030712; padding: 12px; }'
    });

    // ۲. پیش‌نمایش تصویر شاخص
    function previewThumbnail(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const previewBox = document.getElementById('preview-box');
                const previewImg = document.getElementById('image-preview');
                previewImg.src = e.target.result;
                previewBox.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

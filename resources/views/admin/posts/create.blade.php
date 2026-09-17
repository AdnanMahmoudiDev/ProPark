@extends('admin.layout.app')

@section('content')
    <!-- هدر بالای صفحه فرم -->
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-gray-800 pb-5">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-white">
                ایجاد مقاله جدید
            </h1>
            <p class="text-xs text-gray-400 mt-1">
                اطلاعات، محتوا، متادیتای سئو و وضعیت انتشار مقاله را تکمیل نمایید.
            </p>
        </div>

        <a href="{{ route('admin.posts.index') }}"
           class="inline-flex items-center gap-1.5 rounded-xl border border-gray-700 bg-gray-800/80 px-4 py-2 text-xs font-semibold text-gray-300 backdrop-blur transition hover:bg-gray-700 hover:text-white">
            <span>&larr;</span>
            <span>بازگشت به لیست مقالات</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-950/40 border border-rose-800 text-rose-300 text-sm">
            <div class="font-bold mb-1">خطا در ثبت اطلاعات:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ستون اصلی (۲ سوم صفحه): عنوان، محتوا، سئو -->
            <div class="lg:col-span-2 space-y-6">

                <!-- مشخصات پایه: عنوان، اسلاگ، خلاصه -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">
                            عنوان مقاله <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               required
                               placeholder="عنوان جذاب و کامل مقاله..."
                               class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-white text-sm focus:border-blue-500 focus:ring-blue-500 font-bold placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">
                            نامک یکتا (Slug - انگلیسی یا فارسی)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug') }}"
                               placeholder="اختیاری - در صورت خالی ماندن خودکار تولید می‌شود"
                               class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-xs focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500"
                               dir="auto">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">
                            چکیده / خلاصه مقاله
                        </label>
                        <textarea name="summary"
                                  rows="3"
                                  placeholder="خلاصه کوتاهی از مقاله جهت نمایش در کارت‌ها و شبکه‌های اجتماعی..."
                                  class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500">{{ old('summary') }}</textarea>
                    </div>
                </div>

                <!-- ادیتور متن اصلی مقاله -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm">
                    <label class="block text-xs font-semibold text-gray-300 mb-2">
                        متن اصلی مقاله <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="editor" name="content" class="w-full min-h-[450px] rounded-xl">{{ old('content') }}</textarea>
                </div>

                <!-- بخش سئو (SEO) -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-800 pb-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        <h3 class="text-sm font-bold text-white">
                            بهینه‌سازی برای موتورهای جستجو (SEO)
                        </h3>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">
                            عنوان سئو (Meta Title)
                        </label>
                        <input type="text"
                               name="meta_title"
                               maxlength="70"
                               value="{{ old('meta_title') }}"
                               placeholder="پیش‌فرض: همان عنوان مقاله (حداکثر ۷۰ کاراکتر)"
                               class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">
                            توضیحات متا (Meta Description)
                        </label>
                        <textarea name="meta_description"
                                  maxlength="160"
                                  rows="2"
                                  placeholder="پیش‌فرض: همان چکیده مقاله (حداکثر ۱۶۰ کاراکتر برای نمایش در نتایج گوگل)"
                                  class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">
                                کلمات کلیدی (با کاما جدا کنید)
                            </label>
                            <input type="text"
                                   name="meta_keywords"
                                   value="{{ old('meta_keywords') }}"
                                   placeholder="پارکینگ هوشمند, نرم افزار آواپارک"
                                   class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">
                                آدرس کانونیکال (Canonical URL)
                            </label>
                            <input type="url"
                                   name="canonical_url"
                                   value="{{ old('canonical_url') }}"
                                   placeholder="https://..."
                                   class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-xs focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500"
                                   dir="ltr">
                        </div>
                    </div>
                </div>

            </div>

            <!-- ستون کناری: وضعیت و تصویر شاخص -->
            <div class="space-y-6">

                <!-- تنظیمات وضعیت انتشار -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-gray-800 pb-3">
                        تنظیمات انتشار
                    </h3>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">
                            وضعیت انتشار
                        </label>
                        <select id="status-select"
                                name="status"
                                class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-white text-sm focus:border-blue-500 focus:ring-blue-500 font-medium">
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>انتشار عمومی</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">
                            دسته‌بندی
                        </label>
                        <select name="category_id"
                                class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-white text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">بدون دسته‌بندی</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-600/20 transition-all flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        ذخیره مقاله
                    </button>
                </div>

                <!-- تصویر شاخص -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-gray-800 pb-3">
                        تصویر شاخص
                    </h3>

                    <div class="space-y-3">
                        <div id="preview-box"
                             class="hidden w-full h-44 rounded-xl overflow-hidden border border-gray-700 relative">
                            <img id="image-preview" src="#" alt="Preview" class="w-full h-full object-cover">
                        </div>

                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-700 hover:border-gray-500 rounded-xl cursor-pointer bg-gray-800/40 hover:bg-gray-800/70 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-xs text-gray-300 font-medium">کلیک برای انتخاب تصویر</p>
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

    <!-- لود کتابخانه محلی TinyMCE -->
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

    <script>
        // ۱. راه‌اندازی ادیتور
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
            content_style: 'body { font-family: Tahoma, sans-serif; font-size: 14px; direction: rtl; text-align: right; color: #ffffff !important; background-color: #1f2937; padding: 12px; }'
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

@extends('admin.layout.app')

@section('content')
    <!-- هدر بالای صفحه فرم -->
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-gray-800 pb-5">
        <div>
            <h1 class="text-2xl font-black tracking-tight text-white">
                ویرایش مقاله: {{ $post->title }}
            </h1>
            <p class="text-xs text-gray-400 mt-1">
                در حال ویرایش محتوا، سئو و تنظیمات مقاله هستید.
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
            <div class="font-bold mb-1">خطا در بروزرسانی:</div>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- ستون اصلی (محتوا و سئو) -->
            <div class="lg:col-span-2 space-y-6">

                <!-- مشخصات پایه -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-300 mb-1.5">
                            عنوان مقاله <span class="text-rose-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title', $post->title) }}"
                               required
                               class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-white text-sm focus:border-blue-500 focus:ring-blue-500 font-bold placeholder-gray-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">
                            نامک یکتا (Slug)
                        </label>
                        <input type="text"
                               name="slug"
                               value="{{ old('slug', $post->slug) }}"
                               class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-xs focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500"
                               dir="ltr">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">
                            چکیده / خلاصه مقاله
                        </label>
                        <textarea name="summary"
                                  rows="3"
                                  class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-500">{{ old('summary', $post->summary) }}</textarea>
                    </div>
                </div>

                <!-- ادیتور متن -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm">
                    <label class="block text-xs font-semibold text-gray-300 mb-2">
                        متن اصلی مقاله <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="editor" name="content" class="w-full min-h-[450px] rounded-xl">{{ old('content', $post->content) }}</textarea>
                </div>

                <!-- بخش سئو -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <div class="flex items-center gap-2 border-b border-gray-800 pb-3">
                        <h3 class="text-sm font-bold text-white">بهینه‌سازی برای موتورهای جستجو (SEO)</h3>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">عنوان سئو (Meta Title)</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">توضیحات متا (Meta Description)</label>
                        <textarea name="meta_description" rows="2" class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">کلمات کلیدی</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->meta_keywords) }}" class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">آدرس کانونیکال</label>
                            <input type="url" name="canonical_url" value="{{ old('canonical_url', $post->canonical_url) }}" class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-gray-200 text-xs focus:border-blue-500 focus:ring-blue-500" dir="ltr">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ستون کناری (تنظیمات و تصویر) -->
            <div class="space-y-6">
                <!-- تنظیمات -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-gray-800 pb-3">تنظیمات انتشار</h3>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">وضعیت انتشار</label>
                        <select name="status" class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-white text-sm focus:border-blue-500 focus:ring-blue-500 font-medium">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>پیش‌نویس</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>انتشار عمومی</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1.5">دسته‌بندی</label>
                        <select name="category_id" class="w-full rounded-xl border-gray-700 bg-gray-800/80 text-white text-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-600/20 transition-all">
                        ذخیره تغییرات
                    </button>
                </div>

                <!-- تصویر شاخص -->
                <div class="bg-gray-900/60 backdrop-blur-sm rounded-2xl p-6 border border-gray-800 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-gray-800 pb-3">تصویر شاخص</h3>
                    <div class="space-y-3">
                        <div id="preview-box" class="{{ $post->featured_image ? '' : 'hidden' }} w-full h-44 rounded-xl overflow-hidden border border-gray-700 relative">
                            <img id="image-preview" src="{{ $post->featured_image ? asset('storage/'.$post->featured_image) : '#' }}" alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-700 hover:border-gray-500 rounded-xl cursor-pointer bg-gray-800/40 hover:bg-gray-800/70 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <p class="text-xs text-gray-300">انتخاب تصویر جدید</p>
                            </div>
                            <input type="file" name="featured_image" id="featured_image_input" accept="image/*" class="hidden" onchange="previewThumbnail(this)">
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- کتابخانه محلی TinyMCE -->
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
    <script>
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

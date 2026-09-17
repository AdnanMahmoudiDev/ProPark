<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ویرایش دسته‌بندی: {{ $category->name }}
            </h2>
            <a href="{{ route('admin.categories.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl transition">
                بازگشت به لیست دسته‌بندی‌ها
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 sm:p-8 border border-gray-100 dark:border-gray-700/60 shadow-sm">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">
                            نام دسته‌بندی <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" required 
                               value="{{ old('name', $category->name) }}"
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="slug" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">
                            نامک (Slug)
                        </label>
                        <input type="text" name="slug" id="slug" 
                               value="{{ old('slug', $category->slug) }}" dir="ltr"
                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500 text-left">
                        <p class="text-xs text-gray-400 mt-1">شناسه در URL؛ در صورت خالی بودن بر اساس نام مجدداً تولید می‌شود.</p>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">
                            توضیحات مختصر
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700/60">
                        <a href="{{ route('admin.categories.index') }}" 
                           class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition">
                            انصراف
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow transition">
                            ذخیره تغییرات
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>

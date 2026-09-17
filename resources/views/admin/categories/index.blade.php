<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                مدیریت دسته‌بندی‌ها
            </h2>
            <a href="{{ route('admin.posts.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-xs font-semibold rounded-xl transition">
                بازگشت به مقالات
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- پیام موفقیت --}}
            @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- نمایش خطاها --}}
            @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- ستون فرم ساخت دسته‌بندی جدید --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700/60 shadow-sm h-fit">
                    <h3 class="text-base font-bold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-100 dark:border-gray-700/60">
                        افزودن دسته‌بندی جدید
                    </h3>
                    
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label for="name" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">
                                نام دسته‌بندی <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                   placeholder="مثلاً: آموزش سئو"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="slug" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">
                                نامک (Slug)
                            </label>
                            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" dir="ltr"
                                   placeholder="seo-training (اختیاری)"
                                   class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500 text-left">
                            <p class="text-[11px] text-gray-400 mt-1">در صورت خالی بودن خودکار ساخته می‌شود.</p>
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">
                                توضیحات
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="توضیح کوتاه درباره این دسته..."
                                      class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700/50 text-gray-800 dark:text-gray-100 text-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit" 
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow transition">
                            افزودن دسته‌بندی
                        </button>
                    </form>
                </div>

                {{-- ستون لیست دسته‌بندی‌ها --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/60 shadow-sm overflow-hidden">
                    <div class="p-4 sm:p-6 border-b border-gray-100 dark:border-gray-700/60 flex items-center justify-between">
                        <h3 class="text-base font-bold text-gray-800 dark:text-gray-100">
                            لیست دسته‌بندی‌ها
                        </h3>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            تعداد کل: {{ $categories->total() ?? $categories->count() }}
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-right text-sm divide-y divide-gray-100 dark:divide-gray-700/60">
                            <thead class="bg-gray-50 dark:bg-gray-700/30 text-gray-600 dark:text-gray-300 text-xs">
                                <tr>
                                    <th class="py-3.5 px-4 font-semibold">نام</th>
                                    <th class="py-3.5 px-4 font-semibold">نامک (Slug)</th>
                                    <th class="py-3.5 px-4 font-semibold text-center">تعداد مقالات</th>
                                    <th class="py-3.5 px-4 font-semibold text-center">عملیات</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700/60 text-gray-800 dark:text-gray-200">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50/70 dark:hover:bg-gray-700/20 transition">
                                        <td class="py-3.5 px-4 font-medium">
                                            {{ $category->name }}
                                            @if($category->description)
                                                <p class="text-xs text-gray-400 font-normal mt-0.5 line-clamp-1">{{ $category->description }}</p>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-4 text-xs font-mono text-gray-500 dark:text-gray-400" dir="ltr">
                                            {{ $category->slug }}
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                                                {{ $category->posts_count ?? $category->posts()->count() }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                                   class="px-2.5 py-1 text-xs font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 bg-blue-50 dark:bg-blue-950/40 hover:bg-blue-100 dark:hover:bg-blue-900/50 rounded-lg transition">
                                                    ویرایش
                                                </a>
                                                
                                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                                                      onsubmit="return confirm('آیا از حذف این دسته‌بندی اطمینان دارید؟');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="px-2.5 py-1 text-xs font-medium text-rose-600 hover:text-rose-700 dark:text-rose-400 dark:hover:text-rose-300 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/50 rounded-lg transition">
                                                        حذف
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-400 dark:text-gray-500 text-sm">
                                            هنوز هیچ دسته‌بندی ایجاد نشده است.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($categories, 'hasPages') && $categories->hasPages())
                        <div class="p-4 border-t border-gray-100 dark:border-gray-700/60">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

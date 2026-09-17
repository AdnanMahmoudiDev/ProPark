@extends('admin.layout.app')

@section('title', 'مقالات وبلاگ')

@section('content')
<div class="p-6 space-y-6">

    <!-- بخش هدر و دکمه‌های عملیات -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">مقالات وبلاگ</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">مدیریت مقالات: ایجاد، ویرایش، حذف</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-medium rounded-xl transition">
                دسته‌بندی‌ها
            </a>

            <a href="{{ route('admin.posts.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
                مقاله جدید
            </a>
        </div>
    </div>

    <!-- پیام موفقیت -->
    @if(session('success'))
        <div class="p-4 rounded-xl border border-emerald-200 dark:border-emerald-500/20 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-300 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- فیلتر و جستجو -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700">
        <form method="GET" action="{{ route('admin.posts.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-xs mb-1.5 text-gray-500 dark:text-gray-400">جستجو</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="عنوان مقاله..."
                       class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 px-3 py-2 text-sm text-gray-900 dark:text-white">
            </div>

            <div>
                <label class="block text-xs mb-1.5 text-gray-500 dark:text-gray-400">دسته‌بندی</label>
                <select name="category_id"
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 px-3 py-2 text-sm text-gray-900 dark:text-white">
                    <option value="">همه</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs mb-1.5 text-gray-500 dark:text-gray-400">وضعیت</label>
                <select name="status"
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/40 px-3 py-2 text-sm text-gray-900 dark:text-white">
                    <option value="">همه</option>
                    <option value="draft" @selected(request('status') === 'draft')>پیش‌نویس</option>
                    <option value="published" @selected(request('status') === 'published')>منتشر شده</option>
                    <option value="scheduled" @selected(request('status') === 'scheduled')>زمان‌بندی</option>
                </select>
            </div>

            <div class="md:col-span-4 flex items-center gap-2">
                <button type="submit"
                        class="px-4 py-2 rounded-xl bg-gray-900 text-white dark:bg-white dark:text-gray-900 text-sm">
                    اعمال فیلتر
                </button>

                <a href="{{ route('admin.posts.index') }}"
                   class="px-4 py-2 rounded-xl border border-gray-200 dark:border-gray-700 text-sm text-gray-700 dark:text-gray-200">
                    پاک کردن
                </a>
            </div>
        </form>
    </div>

    <!-- جدول مقالات -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-900/30 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="text-right px-4 py-3">عنوان</th>
                        <th class="text-right px-4 py-3">دسته</th>
                        <th class="text-right px-4 py-3">نویسنده</th>
                        <th class="text-right px-4 py-3">وضعیت</th>
                        <th class="text-right px-4 py-3">انتشار (شمسی)</th>
                        <th class="text-center px-4 py-3">عملیات</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($posts as $post)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $post->title }}</div>
                                <div class="text-xs text-gray-400 mt-1">{{ $post->slug }}</div>
                            </td>

                            <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                                {{ $post->category?->name ?? '—' }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                                {{ $post->author?->name ?? '—' }}
                            </td>

                            <td class="px-4 py-3">
                                @php
                                    $badge = match($post->status) {
                                        'published' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300',
                                        'draft' => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200',
                                        default => 'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-300',
                                    };

                                    $label = match($post->status) {
                                        'published' => 'منتشر شده',
                                        'draft' => 'پیش‌نویس',
                                        default => 'زمان‌بندی',
                                    };
                                @endphp

                                <span class="inline-flex px-2 py-1 rounded-full text-xs {{ $badge }}">
                                    {{ $label }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-xs text-gray-500 dark:text-gray-400">
                                @if($post->published_at)
                                    {{ jdate($post->published_at)->format('Y/m/d H:i') }}
                                @else
                                    <span class="text-gray-400">منتشر نشده</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.posts.edit', $post) }}"
                                       class="px-3 py-1.5 rounded-lg bg-amber-500/10 text-amber-700 dark:text-amber-300 text-xs">
                                        ویرایش
                                    </a>

                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                          onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-700 dark:text-rose-300 text-xs">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-gray-500 dark:text-gray-400">
                                هیچ مقاله‌ای یافت نشد.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

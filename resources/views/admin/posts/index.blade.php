@extends('admin.layout.app')

@section('title', 'مقالات وبلاگ')

@section('content')
<div dir="rtl" class="min-h-screen space-y-7 pb-8">

    {{-- هدر صفحه با هاله نوری آبی، نیلی و بنفش --}}
    <div class="relative overflow-hidden rounded-3xl border border-gray-800/80 bg-gradient-to-b from-gray-900/90 via-gray-950/80 to-gray-950/95 p-6 shadow-2xl shadow-black/50 backdrop-blur-2xl sm:p-8">

        {{-- هاله مرکزی گرادینتی --}}
        <div class="pointer-events-none absolute -top-20 left-1/2 h-40 w-[min(90%,550px)] -translate-x-1/2 rounded-full bg-gradient-to-r from-blue-600/20 via-indigo-600/25 to-purple-600/20 blur-[85px] opacity-75"></div>

        {{-- هاله‌های کناری --}}
        <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-indigo-500/15 blur-[60px]"></div>
        <div class="pointer-events-none absolute -bottom-20 -left-10 h-48 w-48 rounded-full bg-blue-500/10 blur-[55px]"></div>
        <div class="pointer-events-none absolute -bottom-20 right-1/3 h-40 w-40 rounded-full bg-purple-500/10 blur-[55px]"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h1 class="flex items-center gap-3 text-2xl font-extrabold tracking-tight text-white sm:text-3xl">
                    <span class="h-8 w-1.5 rounded-full bg-gradient-to-b from-blue-400 to-purple-500 shadow-[0_0_14px_rgba(99,102,241,0.45)]"></span>
                    <span>مدیریت مقالات</span>
                </h1>

                <p class="mt-3 max-w-xl text-sm leading-7 text-gray-400">
                    مقالات وبلاگ را مدیریت کنید، وضعیت انتشار را بررسی کنید و محتوای جدید بسازید.
                </p>

                <div class="mt-5 flex flex-wrap items-center gap-3 text-xs text-gray-400">
                    <span class="inline-flex items-center gap-2 rounded-xl border border-gray-700/70 bg-gray-900/60 px-3 py-2 backdrop-blur-sm">
                        <svg class="h-4 w-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v12m6-6H6"/>
                        </svg>
                        فضای مدیریت محتوا
                    </span>

                    <span class="inline-flex items-center gap-2 rounded-xl border border-gray-700/70 bg-gray-900/60 px-3 py-2 backdrop-blur-sm">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        مدیریت و انتشار محتوا
                    </span>
                </div>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <a
                    href="{{ route('admin.categories.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl border border-gray-700/80 bg-gray-900/70 px-5 py-3 text-sm font-semibold text-gray-200 shadow-lg transition duration-300 hover:-translate-y-0.5 hover:border-gray-600 hover:bg-gray-800 hover:text-white"
                >
                    <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h10"/>
                    </svg>
                    دسته‌بندی‌ها
                </a>

                <a
                    href="{{ route('admin.posts.create') }}"
                    class="group inline-flex items-center justify-center gap-2 rounded-2xl border border-blue-400/30 bg-gradient-to-l from-blue-600 to-blue-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-900/30 transition duration-300 hover:-translate-y-0.5 hover:from-blue-500 hover:to-cyan-500 hover:shadow-blue-900/50"
                >
                    <svg class="h-5 w-5 transition-transform duration-300 group-hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14"/>
                    </svg>
                    ایجاد مقاله جدید
                </a>
            </div>
        </div>
    </div>

    {{-- پیام موفقیت --}}
    @if(session('success'))
        <div class="relative overflow-hidden rounded-2xl border border-emerald-500/30 bg-emerald-950/30 p-4 shadow-lg shadow-emerald-950/20 backdrop-blur-xl">
            <div class="pointer-events-none absolute inset-0 bg-gradient-to-l from-emerald-500/[0.06] to-transparent"></div>

            <div class="relative flex items-start gap-3">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-emerald-500/30 bg-emerald-500/10">
                    <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <div class="min-w-0 flex-1">
                    <p class="text-sm font-bold text-emerald-300">عملیات موفق</p>
                    <p class="mt-1 text-sm leading-6 text-emerald-200/80">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- فیلتر و جستجو --}}
    <section class="overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-900/60 shadow-xl shadow-black/20 backdrop-blur-xl">
        <div class="flex flex-col gap-3 border-b border-gray-800/80 bg-gradient-to-l from-blue-950/15 to-transparent px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-blue-700/30 bg-blue-600/10">
                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-white">جستجو و فیلتر مقالات</h2>
                    <p class="mt-1 text-xs text-gray-500">محتوای موردنظر خود را سریع‌تر پیدا کنید.</p>
                </div>
            </div>

            <span class="w-fit rounded-xl border border-gray-700/80 bg-gray-800/70 px-3 py-2 text-xs text-gray-400">
                فیلتر پیشرفته
            </span>
        </div>

        <form method="GET" action="{{ route('admin.posts.index') }}" class="space-y-5 p-5 sm:p-6">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-4">

                {{-- جستجو --}}
                <div class="xl:col-span-2">
                    <label for="post-search" class="mb-2 block text-xs font-semibold text-gray-400">
                        جستجو در عنوان
                    </label>

                    <div class="group relative">
                        <svg class="pointer-events-none absolute right-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-500 transition group-focus-within:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M19 10.5a8.5 8.5 0 11-17 0 8.5 8.5 0 0117 0z"/>
                        </svg>

                        <input
                            id="post-search"
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="عنوان مقاله را وارد کنید..."
                            class="w-full rounded-2xl border border-gray-700/80 bg-gray-950/60 py-3 pr-11 pl-4 text-sm text-white outline-none transition placeholder:text-gray-600 focus:border-blue-500/70 focus:ring-4 focus:ring-blue-500/10"
                        >
                    </div>
                </div>

                {{-- دسته‌بندی --}}
                <div>
                    <label for="post-category" class="mb-2 block text-xs font-semibold text-gray-400">
                        دسته‌بندی
                    </label>

                    <select
                        id="post-category"
                        name="category_id"
                        class="w-full rounded-2xl border border-gray-700/80 bg-gray-950/60 px-3 py-3 text-sm text-gray-200 outline-none transition focus:border-blue-500/70 focus:ring-4 focus:ring-blue-500/10"
                    >
                        <option value="" class="bg-gray-900">همه دسته‌بندی‌ها</option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(request('category_id') == $category->id)
                                class="bg-gray-900"
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- وضعیت --}}
                <div>
                    <label for="post-status" class="mb-2 block text-xs font-semibold text-gray-400">
                        وضعیت انتشار
                    </label>

                    <select
                        id="post-status"
                        name="status"
                        class="w-full rounded-2xl border border-gray-700/80 bg-gray-950/60 px-3 py-3 text-sm text-gray-200 outline-none transition focus:border-blue-500/70 focus:ring-4 focus:ring-blue-500/10"
                    >
                        <option value="" class="bg-gray-900">همه وضعیت‌ها</option>
                        <option value="draft" @selected(request('status') === 'draft') class="bg-gray-900">پیش‌نویس</option>
                        <option value="published" @selected(request('status') === 'published') class="bg-gray-900">منتشر شده</option>
                        <option value="scheduled" @selected(request('status') === 'scheduled') class="bg-gray-900">زمان‌بندی شده</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-3 border-t border-gray-800/80 pt-5 sm:flex-row sm:items-center">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-950/30 transition duration-300 hover:bg-blue-500"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h18l-7 8v7l-4-2v-5L3 4z"/>
                    </svg>
                    اعمال فیلترها
                </button>

                <a
                    href="{{ route('admin.posts.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-700 bg-gray-800/50 px-5 py-3 text-sm font-medium text-gray-300 transition hover:border-gray-600 hover:bg-gray-800 hover:text-white"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4v6h6M5.6 15a7 7 0 101.1-7.8L4 10"/>
                    </svg>
                    پاک کردن فیلترها
                </a>
            </div>
        </form>
    </section>

    {{-- جدول مقالات --}}
    <section class="overflow-hidden rounded-3xl border border-gray-800/80 bg-gray-900/60 shadow-xl shadow-black/20 backdrop-blur-xl">

        {{-- عنوان جدول --}}
        <div class="flex flex-col gap-3 border-b border-gray-800/80 bg-gradient-to-l from-cyan-950/10 to-transparent px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-cyan-700/30 bg-cyan-500/10">
                    <svg class="h-5 w-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                    </svg>
                </div>

                <div>
                    <h2 class="text-base font-bold text-white">فهرست مقالات</h2>
                    <p class="mt-1 text-xs text-gray-500">مدیریت، ویرایش و بررسی وضعیت انتشار محتوا</p>
                </div>
            </div>

            <div class="flex items-center gap-2 text-xs text-gray-400">
                <span class="h-2 w-2 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.5)]"></span>
                <span>مدیریت محتوا</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] text-right">
                <thead>
                    <tr class="border-b border-gray-800/80 bg-gray-950/60">
                        <th class="px-5 py-4 text-xs font-bold text-gray-400">عنوان مقاله</th>
                        <th class="px-5 py-4 text-xs font-bold text-gray-400">دسته‌بندی</th>
                        <th class="px-5 py-4 text-xs font-bold text-gray-400">نویسنده</th>
                        <th class="px-5 py-4 text-xs font-bold text-gray-400">وضعیت</th>
                        <th class="px-5 py-4 text-xs font-bold text-gray-400">تاریخ انتشار</th>
                        <th class="px-5 py-4 text-center text-xs font-bold text-gray-400">عملیات</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-800/60">
                    @forelse($posts as $post)
                        @php
                            $badge = match($post->status) {
                                'published' => 'border-emerald-700/40 bg-emerald-500/10 text-emerald-300',
                                'draft' => 'border-gray-700 bg-gray-800/80 text-gray-300',
                                default => 'border-amber-700/40 bg-amber-500/10 text-amber-300',
                            };

                            $label = match($post->status) {
                                'published' => 'منتشر شده',
                                'draft' => 'پیش‌نویس',
                                default => 'زمان‌بندی شده',
                            };

                            $statusDot = match($post->status) {
                                'published' => 'bg-emerald-400',
                                'draft' => 'bg-gray-400',
                                default => 'bg-amber-400',
                            };
                        @endphp

                        <tr class="group transition duration-200 hover:bg-blue-500/[0.035]">

                            {{-- عنوان --}}
                            <td class="px-5 py-4">
                                <div class="flex min-w-0 items-start gap-3">
                                    <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-blue-700/20 bg-blue-500/10 transition duration-300 group-hover:border-blue-500/40 group-hover:bg-blue-500/15">
                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M8 5h8M8 9h8M8 13h5M5 3h14a1 1 0 011 1v16a1 1 0 01-1 1H5a1 1 0 01-1-1V4a1 1 0 011-1z"/>
                                        </svg>
                                    </div>

                                    <div class="min-w-0 pt-0.5">
                                        <div class="max-w-sm truncate text-sm font-semibold text-gray-100 transition group-hover:text-blue-300">
                                            {{ $post->title }}
                                        </div>

                                        <div class="mt-1 max-w-sm truncate text-xs text-gray-500" dir="ltr">
                                            {{ $post->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- دسته‌بندی --}}
                            <td class="px-5 py-4">
                                @if($post->category?->name)
                                    <span class="inline-flex items-center rounded-lg border border-violet-700/30 bg-violet-500/[0.08] px-2.5 py-1.5 text-xs text-violet-300">
                                        {{ $post->category->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-600">—</span>
                                @endif
                            </td>

                            {{-- نویسنده --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-gray-700 bg-gray-800 text-xs font-bold text-gray-300">
                                        {{ $post->author?->name ? mb_substr($post->author->name, 0, 1) : '—' }}
                                    </div>

                                    <span class="text-sm text-gray-300">
                                        {{ $post->author?->name ?? '—' }}
                                    </span>
                                </div>
                            </td>

                            {{-- وضعیت --}}
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center gap-2 rounded-full border px-3 py-1.5 text-xs font-medium {{ $badge }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $statusDot }}"></span>
                                    {{ $label }}
                                </span>
                            </td>

                            {{-- تاریخ --}}
                            <td class="px-5 py-4">
                                @if($post->published_at)
                                    <div class="whitespace-nowrap text-xs font-medium text-gray-300">
                                        {{ jdate($post->published_at)->format('Y/m/d') }}
                                    </div>

                                    <div class="mt-1 whitespace-nowrap text-[11px] text-gray-500">
                                        {{ jdate($post->published_at)->format('H:i') }}
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-600"></span>
                                        منتشر نشده
                                    </span>
                                @endif
                            </td>

                            {{-- عملیات --}}
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a
                                        href="{{ route('admin.posts.edit', $post) }}"
                                        class="inline-flex items-center gap-1.5 rounded-xl border border-amber-700/30 bg-amber-500/[0.08] px-3 py-2 text-xs font-semibold text-amber-300 transition duration-200 hover:border-amber-500/50 hover:bg-amber-500/15"
                                    >
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 3.5a2.12 2.12 0 013 3L9 17l-4 1 1-4 10.5-10.5z"/>
                                        </svg>
                                        ویرایش
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.posts.destroy', $post) }}"
                                        onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-xl border border-rose-700/30 bg-rose-500/[0.08] px-3 py-2 text-xs font-semibold text-rose-300 transition duration-200 hover:border-rose-500/50 hover:bg-rose-500/15"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3"/>
                                            </svg>
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-gray-700 bg-gray-800/60">
                                    <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>
                                    </svg>
                                </div>

                                <h3 class="mt-4 text-sm font-bold text-gray-200">
                                    مقاله‌ای پیدا نشد
                                </h3>

                                <p class="mt-2 text-xs leading-6 text-gray-500">
                                    فیلترها را تغییر دهید یا اولین مقاله خود را ایجاد کنید.
                                </p>

                                <a
                                    href="{{ route('admin.posts.create') }}"
                                    class="mt-4 inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white transition hover:bg-blue-500"
                                >
                                    ایجاد مقاله جدید
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- صفحه‌بندی --}}
        @if($posts->hasPages())
            <div class="flex flex-col gap-4 border-t border-gray-800/80 bg-gray-950/30 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <p class="text-xs text-gray-500">
                    برای مشاهده مقالات بیشتر از صفحه‌بندی استفاده کنید.
                </p>

                <div class="overflow-x-auto">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </section>

</div>
@endsection

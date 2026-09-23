<x-app-layout>

    @php
        /*
        |--------------------------------------------------------------------------
        | Page Data
        |--------------------------------------------------------------------------
        */

        $pageTitle = __('blog_page_title');

        $searchQuery = request('search');
        $activeCategory = request('category');

        $hasFilters = filled($searchQuery) || filled($activeCategory);

        /*
        |--------------------------------------------------------------------------
        | Decode HTML Entities
        |--------------------------------------------------------------------------
        */

        $decodeText = function ($text) {
            return html_entity_decode(
                $text ?? '',
                ENT_QUOTES | ENT_HTML5,
                'UTF-8'
            );
        };
    @endphp


    {{-- =========================================================
         SEO
    ========================================================== --}}

    <x-slot name="title">
        {{ $pageTitle }}
    </x-slot>

    <meta
        name="description"
        content="{{ __('blog_meta_desc') }}"
    >


    {{-- =========================================================
         PAGE
    ========================================================== --}}

    <div class="relative min-h-screen overflow-hidden bg-slate-950 text-slate-100">


        {{-- =====================================================
             BACKGROUND
        ====================================================== --}}

        <div
            class="pointer-events-none absolute inset-0 overflow-hidden"
            aria-hidden="true"
        >

            <div
                class="absolute -top-48 left-1/2 h-[600px] w-[900px] -translate-x-1/2 rounded-full bg-blue-600/[0.08] blur-3xl"
            ></div>

            <div
                class="absolute right-[-250px] top-[650px] h-[500px] w-[500px] rounded-full bg-indigo-600/[0.07] blur-3xl"
            ></div>

            <div
                class="absolute bottom-[-250px] left-[-200px] h-[500px] w-[500px] rounded-full bg-cyan-600/[0.04] blur-3xl"
            ></div>

        </div>


        {{-- =====================================================
             READING / TOP LINE
        ====================================================== --}}

        <div
            class="fixed left-0 top-0 z-[100] h-[3px] w-full bg-gradient-to-r from-blue-500 via-cyan-400 to-indigo-500 opacity-80"
            aria-hidden="true"
        ></div>


        <main class="relative z-10">


            {{-- =================================================
                 HERO
            ================================================== --}}

            <section
                class="border-b border-white/5"
            >

                <div
                    class="mx-auto max-w-7xl px-4 pb-12 pt-14 sm:px-6 sm:pb-16 sm:pt-20 lg:px-8"
                >

                    <div class="mx-auto max-w-4xl text-center">


                        {{-- Eyebrow --}}
                        <div
                            class="mb-6 flex justify-center"
                        >

                            <span
                                class="inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-500/10 px-4 py-2 text-xs font-semibold text-blue-300"
                            >

                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-blue-400"
                                ></span>

                                {{ __('blog_eyebrow') }}

                            </span>

                        </div>


                        {{-- Title --}}
                        <h1
                            class="text-3xl font-black leading-[1.5] tracking-tight text-white sm:text-4xl md:text-5xl lg:text-6xl"
                        >
                            {{ __('blog_main_title') }}
                        </h1>


                        {{-- Description --}}
                        <p
                            class="mx-auto mt-6 max-w-2xl text-sm leading-8 text-slate-400 sm:text-base"
                        >
                            {{ __('blog_main_subtitle') }}
                        </p>


                        {{-- Search --}}
                        <div
                            class="mx-auto mt-9 max-w-2xl"
                        >

                            <form
                                action="{{ route('blog.index') }}"
                                method="GET"
                                class="relative"
                            >

                                <div
                                    class="relative flex items-center"
                                >

                                    {{-- Search Icon --}}
                                    <div
                                        class="pointer-events-none absolute right-4 text-slate-500"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >

                                            <circle
                                                cx="11"
                                                cy="11"
                                                r="7"
                                            ></circle>

                                            <path
                                                stroke-linecap="round"
                                                d="m20 20-4-4"
                                            />

                                        </svg>

                                    </div>


                                    <input
                                        type="search"
                                        name="search"
                                        value="{{ $searchQuery }}"
                                        placeholder="{{ __('blog_search_placeholder') }}"
                                        autocomplete="off"
                                        class="h-14 w-full rounded-2xl border border-white/10 bg-white/[0.04] px-12 pl-28 text-sm text-white shadow-2xl shadow-black/20 outline-none backdrop-blur-xl transition placeholder:text-slate-600 focus:border-blue-500/50 focus:bg-white/[0.06] focus:ring-2 focus:ring-blue-500/10"
                                    >


                                    <button
                                        type="submit"
                                        class="absolute left-2 inline-flex h-10 items-center justify-center rounded-xl bg-blue-600 px-5 text-xs font-bold text-white transition hover:bg-blue-500"
                                    >
                                        {{ __('blog_search_btn') }}
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 CATEGORY FILTERS
            ================================================== --}}

            <section
                class="border-b border-white/5 bg-slate-950/50"
            >

                <div
                    class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8"
                >

                    <div
                        class="flex items-center gap-3 overflow-x-auto pb-1 scrollbar-thin scrollbar-track-transparent scrollbar-thumb-slate-700"
                    >

                        {{-- All --}}
                        <a
                            href="{{ route('blog.index') }}"
                            class="inline-flex shrink-0 items-center gap-2 rounded-xl border px-4 py-2.5 text-xs font-semibold transition
                            {{ !$activeCategory
                                ? 'border-blue-500/30 bg-blue-500/10 text-blue-300'
                                : 'border-white/10 bg-white/[0.02] text-slate-400 hover:border-white/20 hover:bg-white/[0.05] hover:text-white'
                            }}"
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />

                            </svg>

                            {{ __('blog_all_articles') }}

                        </a>


                        {{-- Categories --}}
                        @foreach($categories as $category)

                            <a
                                href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                class="inline-flex shrink-0 items-center gap-2 rounded-xl border px-4 py-2.5 text-xs font-semibold transition
                                {{ $activeCategory === $category->slug
                                    ? 'border-blue-500/30 bg-blue-500/10 text-blue-300'
                                    : 'border-white/10 bg-white/[0.02] text-slate-400 hover:border-white/20 hover:bg-white/[0.05] hover:text-white'
                                }}"
                            >

                                {{ $category->name }}

                                <span
                                    class="rounded-full bg-white/[0.06] px-2 py-0.5 text-[10px] text-slate-500"
                                >
                                    {{ $category->posts_count }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </div>

            </section>


            {{-- =================================================
                 CONTENT
            ================================================== --}}

            <section
                class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16"
            >

                <div
                    class="grid grid-cols-1 gap-10 lg:grid-cols-[minmax(0,1fr)_300px] lg:items-start"
                >


                    {{-- =================================================
                         MAIN COLUMN
                    ================================================== --}}

                    <div class="min-w-0">


                        {{-- =================================================
                             RESULT HEADER
                        ================================================== --}}

                        <div
                            class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between"
                        >

                            <div>

                                @if($searchQuery)

                                    <p
                                        class="text-xs font-semibold text-blue-400"
                                    >
                                        {{ __('blog_search_result_label') }}
                                    </p>

                                    <h2
                                        class="mt-2 text-xl font-black text-white sm:text-2xl"
                                    >
                                        {{ __('blog_search_heading', ['query' => $searchQuery]) }}
                                    </h2>

                                @elseif($activeCategory)

                                    <p
                                        class="text-xs font-semibold text-blue-400"
                                    >
                                        {{ __('blog_category_label') }}
                                    </p>

                                    <h2
                                        class="mt-2 text-xl font-black text-white sm:text-2xl"
                                    >
                                        {{ __('blog_category_heading') }}
                                    </h2>

                                @else

                                    <p
                                        class="text-xs font-semibold text-blue-400"
                                    >
                                        {{ __('blog_latest_label') }}
                                    </p>

                                    <h2
                                        class="mt-2 text-xl font-black text-white sm:text-2xl"
                                    >
                                        {{ __('blog_articles_heading') }}
                                    </h2>

                                @endif

                            </div>


                            @if($posts->total())

                                <span
                                    class="text-xs text-slate-500"
                                >
                                    {{ number_format($posts->total()) }}
                                    {{ __('blog_count_suffix') }}
                                </span>

                            @endif

                        </div>


                        {{-- =================================================
                             FEATURED POST
                        ================================================== --}}

                        @if(
                            $featuredPost &&
                            (!request()->has('page') || request()->page == 1) &&
                            !$activeCategory &&
                            !$searchQuery
                        )

                            <article
                                class="group relative mb-10 overflow-hidden rounded-3xl border border-white/10 bg-white/[0.025] shadow-2xl shadow-black/20 transition duration-500 hover:border-blue-400/20"
                            >

                                {{-- Image --}}
                                <a
                                    href="{{ route('blog.show', $featuredPost->slug) }}"
                                    class="relative block aspect-[16/8] overflow-hidden bg-slate-900"
                                >

                                    @if($featuredPost->featured_image)

                                        <img
                                            src="{{ Str::startsWith($featuredPost->featured_image, ['http://', 'https://'])
                                                ? $featuredPost->featured_image
                                                : asset('storage/' . $featuredPost->featured_image) }}"
                                            alt="{{ $featuredPost->title }}"
                                            class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.03]"
                                            loading="eager"
                                            onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                        >

                                    @endif


                                    {{-- Fallback --}}
                                    <div
                                        class="{{ $featuredPost->featured_image ? 'hidden' : '' }} absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-950 via-slate-900 to-slate-950"
                                    >

                                        <svg
                                            class="h-16 w-16 text-slate-700"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.2"
                                        >

                                            <rect
                                                x="3"
                                                y="3"
                                                width="18"
                                                height="18"
                                                rx="2"
                                            />

                                            <circle
                                                cx="8.5"
                                                cy="8.5"
                                                r="1.5"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m21 15-5-5L5 21"
                                            />

                                        </svg>

                                    </div>


                                    {{-- Overlay --}}
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"
                                    ></div>


                                    

                                </a>


                                {{-- Content --}}
                                <div
                                    class="p-6 sm:p-8"
                                >

                                    {{-- Meta --}}
                                    <div
                                        class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-500"
                                    >

                                        @if($featuredPost->category)

                                            <span
                                                class="font-semibold text-blue-400"
                                            >
                                                {{ $featuredPost->category->name }}
                                            </span>

                                        @endif


                                        @if($featuredPost->published_at)

                                            <span class="text-slate-700">
                                                /
                                            </span>

                                            <time
                                                datetime="{{ jdate($featuredPost->published_at)->format('Y/m/d') }}"
                                            >
                                                {{ jdate($featuredPost->published_at)->format('Y/m/d') }}
                                            </time>

                                        @endif


                                        @if($featuredPost->reading_time)

                                            <span class="text-slate-700">
                                                /
                                            </span>

                                            <span>
                                                {{ $featuredPost->reading_time }}
                                                {{ __('blog_reading_time_suffix') }}
                                            </span>

                                        @endif

                                    </div>


                                    {{-- Title --}}
                                    <h2
                                        class="mt-4 text-2xl font-black leading-[1.7] tracking-tight text-white transition group-hover:text-blue-300 sm:text-3xl"
                                    >

                                        <a
                                            href="{{ route('blog.show', $featuredPost->slug) }}"
                                        >
                                            {{ $featuredPost->title }}
                                        </a>

                                    </h2>


                                    {{-- Summary --}}
                                    @if(filled($featuredPost->summary))

                                        <p
                                            class="mt-4 line-clamp-3 text-sm leading-8 text-slate-400 sm:text-base"
                                        >
                                            {{ $decodeText($featuredPost->summary) }}
                                        </p>

                                    @endif


                                    {{-- Read --}}
                                    <div class="mt-6">

                                        <a
                                            href="{{ route('blog.show', $featuredPost->slug) }}"
                                            class="inline-flex items-center gap-2 text-sm font-bold text-blue-400 transition hover:text-blue-300"
                                        >

                                            {{ __('blog_read_article') }}

                                            <svg
                                                class="h-4 w-4"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M19 12H5m7 7-7-7 7-7"
                                                />

                                            </svg>

                                        </a>

                                    </div>

                                </div>

                            </article>

                        @endif


                        {{-- =================================================
                             POSTS GRID
                        ================================================== --}}

                        <div
                            class="grid grid-cols-1 gap-6 md:grid-cols-2"
                        >

                            @forelse($posts as $post)

                                @if(
                                    $featuredPost &&
                                    (!request()->has('page') || request()->page == 1) &&
                                    !$activeCategory &&
                                    !$searchQuery &&
                                    $post->id === $featuredPost->id
                                )
                                    @continue
                                @endif


                                @php

                                    $postImage = filled($post->featured_image)
                                        ? (
                                            Str::startsWith($post->featured_image, ['http://', 'https://'])
                                                ? $post->featured_image
                                                : asset('storage/' . $post->featured_image)
                                        )
                                        : null;

                                @endphp


                                <article
                                    class="group flex h-full flex-col overflow-hidden rounded-2xl border border-white/10 bg-white/[0.025] transition duration-300 hover:-translate-y-1 hover:border-white/20 hover:bg-white/[0.04] hover:shadow-2xl hover:shadow-black/20"
                                >

                                    {{-- Image --}}
                                    <a
                                        href="{{ route('blog.show', $post->slug) }}"
                                        class="relative block aspect-[16/9] overflow-hidden bg-slate-900"
                                    >

                                        @if($postImage)

                                            <img
                                                src="{{ $postImage }}"
                                                alt="{{ $post->title }}"
                                                class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.04]"
                                                loading="lazy"
                                                onerror="this.style.display='none'; this.nextElementSibling.classList.remove('hidden');"
                                            >

                                        @endif


                                        {{-- Fallback --}}
                                        <div
                                            class="{{ $postImage ? 'hidden' : '' }} absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-900 to-slate-950"
                                        >

                                            <svg
                                                class="h-10 w-10 text-slate-700"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.3"
                                            >

                                                <rect
                                                    x="3"
                                                    y="3"
                                                    width="18"
                                                    height="18"
                                                    rx="2"
                                                />

                                                <circle
                                                    cx="8.5"
                                                    cy="8.5"
                                                    r="1.5"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="m21 15-5-5L5 21"
                                                />

                                            </svg>

                                        </div>

                                    </a>


                                    {{-- Card Body --}}
                                    <div
                                        class="flex flex-1 flex-col p-5 sm:p-6"
                                    >

                                        {{-- Meta --}}
                                        <div
                                            class="flex items-center justify-between gap-3 text-[11px]"
                                        >

                                            @if($post->category)

                                                <span
                                                    class="truncate font-semibold text-blue-400"
                                                >
                                                    {{ $post->category->name }}
                                                </span>

                                            @else

                                                <span class="text-slate-600">
                                                    {{ __('blog_general') }}
                                                </span>

                                            @endif


                                            @if($post->published_at)

                                                <time
                                                    class="shrink-0 text-slate-600"
                                                    datetime="{{ jdate($post->updated_at)->format('Y/m/d') }}"
                                                >
                                                    {{ jdate($post->updated_at)->format('Y/m/d') }}
                                                </time>

                                            @endif

                                        </div>


                                        {{-- Title --}}
                                        <h3
                                            class="mt-3 line-clamp-2 text-lg font-black leading-[1.7] text-white transition group-hover:text-blue-300"
                                        >

                                            <a
                                                href="{{ route('blog.show', $post->slug) }}"
                                            >
                                                {{ $post->title }}
                                            </a>

                                        </h3>


                                        {{-- Summary --}}
                                        @if(filled($post->summary))

                                            <p
                                                class="mt-3 line-clamp-3 flex-1 text-sm leading-7 text-slate-400"
                                            >
                                                {{ $decodeText($post->summary) }}
                                            </p>

                                        @else

                                            <div class="flex-1"></div>

                                        @endif


                                        {{-- Footer --}}
                                        <div
                                            class="mt-5 flex items-center justify-between border-t border-white/5 pt-4"
                                        >

                                            <div
                                                class="flex items-center gap-2 text-[11px] text-slate-500"
                                            >

                                                <svg
                                                    class="h-4 w-4"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >

                                                    <circle
                                                        cx="12"
                                                        cy="12"
                                                        r="9"
                                                    ></circle>

                                                    <path
                                                        stroke-linecap="round"
                                                        d="M12 7v5l3 2"
                                                    />

                                                </svg>

                                                <span>
                                                    {{ $post->reading_time ?? 5 }}
                                                    {{ __('blog_reading_time_suffix') }}
                                                </span>

                                            </div>


                                            <a
                                                href="{{ route('blog.show', $post->slug) }}"
                                                class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-400 transition hover:text-blue-300"
                                            >

                                                {{ __('blog_read_btn') }}

                                                <svg
                                                    class="h-3.5 w-3.5"
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                >

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19 12H5m7 7-7-7 7-7"
                                                    />

                                                </svg>

                                            </a>

                                        </div>

                                    </div>

                                </article>

                            @empty

                                <div
                                    class="col-span-full rounded-3xl border border-dashed border-white/10 bg-white/[0.02] px-6 py-20 text-center"
                                >

                                    <div
                                        class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-white/[0.04] text-slate-600"
                                    >

                                        <svg
                                            class="h-7 w-7"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >

                                            <circle
                                                cx="11"
                                                cy="11"
                                                r="7"
                                            ></circle>

                                            <path
                                                stroke-linecap="round"
                                                d="m20 20-4-4"
                                            />

                                        </svg>

                                    </div>


                                    <h2
                                        class="mt-5 text-lg font-bold text-white"
                                    >
                                        {{ __('blog_empty_title') }}
                                    </h2>


                                    <p
                                        class="mx-auto mt-2 max-w-md text-sm leading-7 text-slate-500"
                                    >
                                        {{ __('blog_empty_desc') }}
                                    </p>


                                    <a
                                        href="{{ route('blog.index') }}"
                                        class="mt-6 inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-bold text-white transition hover:bg-blue-500"
                                    >
                                        {{ __('blog_view_all_btn') }}
                                    </a>

                                </div>

                            @endforelse

                        </div>


                        {{-- =================================================
                             PAGINATION
                        ================================================== --}}

                        @if($posts->hasPages())

                            <div
                                class="mt-10 border-t border-white/5 pt-8"
                            >

                                {{ $posts->withQueryString()->links() }}

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                         SIDEBAR
                    ================================================== --}}

                    <aside
                        class="lg:sticky lg:top-24"
                    >

                        <div class="space-y-5">


                            {{-- Categories --}}
                            <div
                                class="rounded-2xl border border-white/10 bg-white/[0.025] p-5"
                            >

                                <div
                                    class="mb-5 flex items-center justify-between"
                                >

                                    <div>

                                        <p
                                            class="text-[11px] font-semibold text-blue-400"
                                        >
                                            {{ __('blog_browse_topics') }}
                                        </p>

                                        <h2
                                            class="mt-1 text-base font-black text-white"
                                        >
                                            {{ __('blog_categories_title') }}
                                        </h2>

                                    </div>


                                    <svg
                                        class="h-5 w-5 text-slate-600"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            d="M4 6h16M4 12h16M4 18h10"
                                        />

                                    </svg>

                                </div>


                                <div class="space-y-1">

                                    <a
                                        href="{{ route('blog.index') }}"
                                        class="group flex items-center justify-between rounded-xl px-3 py-3 transition
                                        {{ !$activeCategory
                                            ? 'bg-blue-500/10 text-blue-300'
                                            : 'text-slate-400 hover:bg-white/[0.04] hover:text-white'
                                        }}"
                                    >

                                        <span
                                            class="text-xs font-semibold"
                                        >
                                            {{ __('blog_all_articles') }}
                                        </span>


                                        <svg
                                            class="h-4 w-4 opacity-40 transition group-hover:-translate-x-1"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 12H5m7 7-7-7 7-7"
                                            />

                                        </svg>

                                    </a>


                                    @foreach($categories as $category)

                                        <a
                                            href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                            class="group flex items-center justify-between rounded-xl px-3 py-3 transition
                                            {{ $activeCategory === $category->slug
                                                ? 'bg-blue-500/10 text-blue-300'
                                                : 'text-slate-400 hover:bg-white/[0.04] hover:text-white'
                                            }}"
                                        >

                                            <span
                                                class="truncate text-xs font-medium"
                                            >
                                                {{ $category->name }}
                                            </span>


                                            <span
                                                class="shrink-0 rounded-full bg-white/[0.05] px-2 py-1 text-[10px] text-slate-500"
                                            >
                                                {{ $category->posts_count }}
                                            </span>

                                        </a>

                                    @endforeach

                                </div>

                            </div>


                            {{-- Blog Info --}}
                            <div
                                class="relative overflow-hidden rounded-2xl border border-blue-400/10 bg-gradient-to-br from-blue-600/[0.12] via-indigo-600/[0.07] to-transparent p-6"
                            >

                                <div
                                    class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-blue-500/10 blur-3xl"
                                ></div>


                                <div class="relative">

                                    <div
                                        class="mb-5 flex h-11 w-11 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400"
                                    >

                                        <svg
                                            class="h-6 w-6"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 6.5a3.5 3.5 0 013.5-3.5H20v17h-4.5a3.5 3.5 0 00-3.5 3.5m0-17A3.5 3.5 0 008.5 3H4v17h4.5a3.5 3.5 0 013.5 3.5m0-17v17"
                                            />

                                        </svg>

                                    </div>


                                    <h2
                                        class="text-lg font-black leading-8 text-white"
                                    >
                                        {{ __('blog_encyclopedia_title') }}
                                    </h2>


                                    <p
                                        class="mt-3 text-xs leading-7 text-slate-400"
                                    >
                                        {{ __('blog_encyclopedia_desc') }}
                                    </p>

                                </div>

                            </div>


                            {{-- CTA --}}
                            <div
                                class="rounded-2xl border border-white/10 bg-white/[0.025] p-5"
                            >

                                <p
                                    class="text-xs font-semibold text-slate-500"
                                >
                                    {{ __('blog_looking_new') }}
                                </p>


                                <h2
                                    class="mt-2 text-base font-bold leading-7 text-white"
                                >
                                    {{ __('blog_follow_new') }}
                                </h2>


                                <a
                                    href="{{ route('home') }}"
                                    class="mt-4 inline-flex w-full items-center justify-center rounded-xl border border-white/10 bg-white/[0.04] px-4 py-3 text-xs font-bold text-slate-200 transition hover:bg-white/[0.08] hover:text-white"
                                >
                                    {{ __('blog_about_avapark') }}
                                </a>

                            </div>

                        </div>

                    </aside>

                </div>

            </section>


        </main>

    </div>

</x-app-layout>

<x-app-layout>

    @php
        /*
        |--------------------------------------------------------------------------
        | SEO
        |--------------------------------------------------------------------------
        */

        $seoTitle = filled($post->seo_title)
            ? $post->seo_title
            : $post->title;

        $seoDescription = filled($post->seo_description)
            ? $post->seo_description
            : \Illuminate\Support\Str::limit(
                strip_tags($post->excerpt ?? ''),
                160
            );

        /*
        |--------------------------------------------------------------------------
        | Canonical URL
        |--------------------------------------------------------------------------
        */

        $canonicalUrl = filled($post->canonical_url)
            ? $post->canonical_url
            : route('blog.show', $post->slug);

        /*
        |--------------------------------------------------------------------------
        | Featured Image
        |--------------------------------------------------------------------------
        */

        $featuredImage = filled($post->featured_image)
            ? asset('storage/' . $post->featured_image)
            : asset('images/default-blog.jpg');

        /*
        |--------------------------------------------------------------------------
        | Open Graph Image
        |--------------------------------------------------------------------------
        */

        $ogImage = filled($post->og_image)
            ? asset('storage/' . $post->og_image)
            : $featuredImage;

        /*
        |--------------------------------------------------------------------------
        | Author
        |--------------------------------------------------------------------------
        */

        $authorName = $post->author?->name ?? 'ProPark';

        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $categoryName = $post->category?->name;

        /*
        |--------------------------------------------------------------------------
        | Article URL
        |--------------------------------------------------------------------------
        */

        $articleUrl = route('blog.show', $post->slug);
    @endphp


    {{-- =========================================================
         SEO
    ========================================================== --}}

    <x-slot name="title">
        {{ $seoTitle }}
    </x-slot>

    <meta
        name="description"
        content="{{ $seoDescription }}"
    >

    <link
        rel="canonical"
        href="{{ $canonicalUrl }}"
    >


    {{-- =========================================================
         OPEN GRAPH
    ========================================================== --}}

    <meta
        property="og:type"
        content="article"
    >

    <meta
        property="og:title"
        content="{{ $seoTitle }}"
    >

    <meta
        property="og:description"
        content="{{ $seoDescription }}"
    >

    <meta
        property="og:url"
        content="{{ $canonicalUrl }}"
    >

    <meta
        property="og:image"
        content="{{ $ogImage }}"
    >

    <meta
        property="og:site_name"
        content="ProPark"
    >

    @if($categoryName)
        <meta
            property="article:section"
            content="{{ $categoryName }}"
        >
    @endif

    @if($post->published_at)
        <meta
            property="article:published_time"
            content="{{ $post->published_at->toIso8601String() }}"
        >
    @endif

    @if($post->updated_at)
        <meta
            property="article:modified_time"
            content="{{ $post->updated_at->toIso8601String() }}"
        >
    @endif


    {{-- =========================================================
         TWITTER
    ========================================================== --}}

    <meta
        name="twitter:card"
        content="summary_large_image"
    >

    <meta
        name="twitter:title"
        content="{{ $seoTitle }}"
    >

    <meta
        name="twitter:description"
        content="{{ $seoDescription }}"
    >

    <meta
        name="twitter:image"
        content="{{ $ogImage }}"
    >


    {{-- =========================================================
         ARTICLE STRUCTURED DATA
    ========================================================== --}}

    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Article",
        "headline": @json($post->title),
        "description": @json($seoDescription),
        "image": [
            @json($ogImage)
        ],
        "url": @json($canonicalUrl),
        "datePublished": @json($post->published_at?->toIso8601String()),
        "dateModified": @json($post->updated_at?->toIso8601String()),
        "author": {
            "@type": "Person",
            "name": @json($authorName)
        },
        "publisher": {
            "@type": "Organization",
            "name": "ProPark"
        },
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": @json($canonicalUrl)
        }
    }
    </script>


    {{-- =========================================================
         PAGE
    ========================================================== --}}

    <div
        class="relative min-h-screen overflow-hidden bg-slate-950 text-slate-100"
    >

        {{-- Background --}}
        <div
            class="pointer-events-none absolute inset-0 overflow-hidden"
            aria-hidden="true"
        >

            <div
                class="absolute -top-40 left-1/2 h-[500px] w-[800px] -translate-x-1/2 rounded-full bg-blue-600/10 blur-3xl"
            ></div>

            <div
                class="absolute right-[-200px] top-[500px] h-[400px] w-[400px] rounded-full bg-indigo-600/10 blur-3xl"
            ></div>

            <div
                class="absolute bottom-[-200px] left-[-150px] h-[400px] w-[400px] rounded-full bg-cyan-600/5 blur-3xl"
            ></div>

        </div>


        {{-- =====================================================
             READING PROGRESS
        ====================================================== --}}

        <div
            id="reading-progress"
            class="fixed left-0 top-0 z-[100] h-[3px] w-0 bg-gradient-to-r from-blue-500 via-cyan-400 to-indigo-500"
        ></div>


        {{-- =====================================================
             COPY TOAST
        ====================================================== --}}

        <div
            id="copy-toast"
            class="pointer-events-none fixed bottom-6 left-1/2 z-[110] hidden -translate-x-1/2 rounded-full border border-slate-700 bg-slate-900/95 px-5 py-3 text-sm font-medium text-white shadow-2xl backdrop-blur"
        >
            لینک مقاله کپی شد ✓
        </div>


        <main class="relative z-10">


            {{-- =================================================
                 BREADCRUMB
            ================================================== --}}

            <section class="border-b border-white/5">

                <div class="mx-auto min-w-0 max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

                    <nav
                        class="flex min-w-0 items-center gap-2 overflow-hidden text-sm"
                        aria-label="مسیر صفحه"
                    >

                        <a
                            href="{{ route('home') }}"
                            class="shrink-0 text-slate-400 transition hover:text-white"
                        >
                            خانه
                        </a>

                        <svg
                            class="h-4 w-4 shrink-0 text-slate-600"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.707 14.707a1 1 0 01-1.414-1.414L10.586 9 6.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <a
                            href="{{ route('blog.index') }}"
                            class="shrink-0 text-slate-400 transition hover:text-white"
                        >
                            وبلاگ
                        </a>

                        @if($categoryName)

                            <svg
                                class="h-4 w-4 shrink-0 text-slate-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.707 14.707a1 1 0 01-1.414-1.414L10.586 9 6.293 4.707a1 1 0 011.414-1.414l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>

                            <span class="shrink-0 text-slate-400">
                                {{ $categoryName }}
                            </span>

                        @endif

                        <svg
                            class="h-4 w-4 shrink-0 text-slate-600"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            aria-hidden="true"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.707 14.707a1 1 0 01-1.414-1.414L10.586 9 6.293 4.707a1 1 0 010 1.414l-5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            />
                        </svg>

                        <span class="min-w-0 truncate text-slate-200">
                            {{ $post->title }}
                        </span>

                    </nav>

                </div>

            </section>


            {{-- =================================================
                 ARTICLE HEADER
            ================================================== --}}

            <header
                class="mx-auto max-w-5xl px-4 pb-12 pt-12 text-center sm:px-6 sm:pt-16 lg:px-8 lg:pt-20"
            >

                {{-- Category --}}
                @if($post->category)

                    <div class="mb-6 flex justify-center">

                        <a
                            href="{{ route('blog.index', ['category' => $post->category->slug]) }}"
                            class="inline-flex items-center gap-2 rounded-full border border-blue-400/20 bg-blue-500/10 px-4 py-2 text-sm font-medium text-blue-300 transition hover:border-blue-400/40 hover:bg-blue-500/15"
                        >

                            <span
                                class="h-1.5 w-1.5 rounded-full bg-blue-400"
                            ></span>

                            {{ $post->category->name }}

                        </a>

                    </div>

                @endif


                {{-- Meta --}}
                <div
                    class="mb-6 flex flex-wrap items-center justify-center gap-x-5 gap-y-3 text-sm text-slate-400"
                >

                    {{-- Published At --}}
                    @if($post->published_at)

                        <div class="flex items-center gap-2">

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
                                    d="M8 7V3m8 4V3m-9 8h10M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                                />
                            </svg>

                            <time
                                datetime="{{ $post->published_at->toIso8601String() }}"
                            >
                                {{ jdate($post->published_at)->format('Y/m/d') }}
                            </time>

                        </div>

                    @endif


                    {{-- Reading Time --}}
                    @if(!is_null($post->reading_time))

                        <span
                            class="hidden h-1 w-1 rounded-full bg-slate-600 sm:block"
                        ></span>

                        <div class="flex items-center gap-2">

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
                                {{ $post->reading_time }} دقیقه مطالعه
                            </span>

                        </div>

                    @endif


                    {{-- Views --}}
                    <span
                        class="hidden h-1 w-1 rounded-full bg-slate-600 sm:block"
                    ></span>

                    <div class="flex items-center gap-2">

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
                                d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="2.5"
                            />

                        </svg>

                        <span>
                            {{ number_format($post->views_count ?? 0) }} بازدید
                        </span>

                    </div>

                </div>


                {{-- Title --}}
                <h1
                    class="text-balance text-3xl font-black tracking-tight text-white !leading-[1.8] sm:text-4xl md:text-5xl lg:text-6xl"
                >
                    {{ $post->title }}
                </h1>


                {{-- Excerpt --}}
                @if(filled($post->excerpt))

                    <p
                        class="mx-auto mt-7 max-w-3xl text-base leading-8 text-slate-400 sm:text-lg"
                    >
                        {{ html_entity_decode($post->excerpt ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8') }}
                    </p>

                @endif


                {{-- Author --}}
                <div class="mt-9 flex flex-wrap items-center justify-center">

                    <div
                        class="flex items-center gap-3 rounded-full border border-white/10 bg-white/[0.03] px-4 py-2.5"
                    >

                        <div
                            class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-sm font-bold text-white"
                        >
                            {{ mb_substr($authorName, 0, 1) }}
                        </div>


                        <div class="text-right">

                            <div class="text-sm font-semibold text-white">
                                {{ $authorName }}
                            </div>

                            <div class="text-xs text-slate-500">
                                نویسنده مقاله
                            </div>

                        </div>

                    </div>

                </div>

            </header>


            {{-- =================================================
                 FEATURED IMAGE
            ================================================== --}}

            <section class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <figure
                    class="group relative overflow-hidden rounded-2xl border border-white/10 bg-slate-900 shadow-2xl shadow-black/20 sm:rounded-3xl"
                >

                    <div
                        class="absolute inset-0 z-10 bg-gradient-to-t from-slate-950/20 via-transparent to-white/5"
                    ></div>


                    <img
                        src="{{ $featuredImage }}"
                        alt="{{ $post->title }}"
                        class="aspect-[16/8] w-full object-cover transition duration-700 group-hover:scale-[1.015]"
                        loading="eager"
                    >

                </figure>

            </section>


            {{-- =================================================
                 MAIN CONTENT
            ================================================== --}}

            <section
                class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8 lg:py-16"
            >

                <div
                    class="grid grid-cols-1 gap-12 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start"
                >


                    {{-- =================================================
                         ARTICLE
                    ================================================== --}}

                    <article class="min-w-0">


                        {{-- Summary --}}
                        @if(filled($post->excerpt))

                            <div
                                class="mb-10 rounded-2xl border border-blue-400/10 bg-gradient-to-br from-blue-500/[0.08] to-indigo-500/[0.04] p-6 sm:p-8"
                            >

                                <div class="mb-4 flex items-center gap-3">

                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M13 16h-1v-4h-1m1-8h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />

                                        </svg>

                                    </div>


                                    <h2 class="text-base font-bold text-white">
                                        خلاصه مقاله
                                    </h2>

                                </div>


                                <p
                                    class="text-sm leading-8 text-slate-300 sm:text-base"
                                >
                                    {{ html_entity_decode($post->excerpt ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8') }}
                                </p>

                            </div>

                        @endif


                        {{-- Toolbar --}}
                        <div
                            class="mb-8 flex flex-wrap items-center justify-between gap-4 border-y border-white/5 py-4"
                        >

                            {{-- Font Size --}}
                            <div class="flex items-center gap-2">

                                <span class="text-xs text-slate-500">
                                    اندازه متن
                                </span>


                                <button
                                    type="button"
                                    id="font-decrease"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/[0.03] text-sm text-slate-300 transition hover:bg-white/[0.08] hover:text-white"
                                    aria-label="کوچک کردن متن"
                                >
                                    A−
                                </button>


                                <button
                                    type="button"
                                    id="font-increase"
                                    class="flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 bg-white/[0.03] text-sm text-slate-300 transition hover:bg-white/[0.08] hover:text-white"
                                    aria-label="بزرگ کردن متن"
                                >
                                    A+
                                </button>

                            </div>


                            {{-- Copy Link --}}
                            <button
                                type="button"
                                id="copy-link"
                                class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/[0.03] px-3.5 py-2 text-xs font-medium text-slate-300 transition hover:bg-white/[0.08] hover:text-white"
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
                                        d="M8 12h8m-4-4l4 4-4 4"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13 7V5a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2h2m4 6h6a2 2 0 002-2V9a2 2 0 00-2-2h-6a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    />

                                </svg>

                                کپی لینک

                            </button>

                        </div>


                        {{-- Article Content --}}
                        <div
                            id="article-content"
                            class="prose prose-invert prose-slate max-w-none text-[17px] leading-[2.15] prose-headings:scroll-mt-28 prose-headings:font-black prose-headings:text-white prose-h2:mb-5 prose-h2:mt-14 prose-h2:text-2xl prose-h3:mb-4 prose-h3:mt-10 prose-h3:text-xl prose-p:my-6 prose-p:text-slate-300 prose-a:text-blue-400 prose-a:no-underline prose-a:transition hover:prose-a:text-blue-300 prose-strong:text-white prose-blockquote:border-blue-500 prose-blockquote:bg-white/[0.03] prose-blockquote:px-5 prose-blockquote:py-2 prose-img:rounded-2xl prose-img:border prose-img:border-white/10 sm:text-[18px]"
                        >

                            {!! $post->content !!}

                        </div>


                        {{-- =================================================
                             AUTHOR CARD
                        ================================================== --}}

                        <div
                            class="mt-16 overflow-hidden rounded-2xl border border-white/10 bg-white/[0.025]"
                        >

                            <div class="p-6 sm:p-8">

                                <div
                                    class="flex flex-col gap-5 sm:flex-row sm:items-center"
                                >

                                    <div
                                        class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-xl font-black text-white shadow-lg shadow-blue-900/20"
                                    >
                                        {{ mb_substr($authorName, 0, 1) }}
                                    </div>


                                    <div>

                                        <p
                                            class="mb-1 text-xs font-medium text-blue-400"
                                        >
                                            درباره نویسنده
                                        </p>


                                        <h3
                                            class="text-lg font-bold text-white"
                                        >
                                            {{ $authorName }}
                                        </h3>


                                        <p
                                            class="mt-2 text-sm leading-7 text-slate-400"
                                        >
                                            نویسنده و تولیدکننده محتوای تخصصی در حوزه فناوری و پارکینگ هوشمند ProPark.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </article>


                    {{-- =================================================
                         SIDEBAR
                    ================================================== --}}

                    <aside class="lg:sticky lg:top-24">

                        <div class="space-y-6">


                            {{-- Table Of Contents --}}
                            <div
                                id="toc-wrapper"
                                class="rounded-2xl border border-white/10 bg-white/[0.025] p-5"
                            >

                                <div class="mb-5 flex items-center gap-3">

                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400"
                                    >

                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 6h14M5 12h14M5 18h9"
                                            />

                                        </svg>

                                    </div>


                                    <div>

                                        <h2 class="text-sm font-bold text-white">
                                            فهرست مطالب
                                        </h2>

                                        <p class="mt-1 text-xs text-slate-500">
                                            مرور سریع مقاله
                                        </p>

                                    </div>

                                </div>


                                <nav
                                    id="toc"
                                    class="max-h-[60vh] overflow-y-auto"
                                    aria-label="فهرست مطالب مقاله"
                                >
                                    <p class="text-sm leading-7 text-slate-500">
                                        در حال ساخت فهرست مطالب...
                                    </p>
                                </nav>

                            </div>


                            {{-- =================================================
                                 ARTICLE STATS
                            ================================================== --}}

                            <div
                                class="rounded-2xl border border-white/10 bg-white/[0.025] p-5"
                            >

                                <h2
                                    class="mb-4 text-sm font-bold text-white"
                                >
                                    اطلاعات مقاله
                                </h2>


                                <div class="space-y-4">

                                    {{-- Views --}}
                                    <div
                                        class="flex items-center justify-between"
                                    >

                                        <span
                                            class="text-sm text-slate-500"
                                        >
                                            بازدید
                                        </span>

                                        <span
                                            class="text-sm font-semibold text-slate-200"
                                        >
                                            {{ number_format($post->views_count ?? 0) }}
                                        </span>

                                    </div>


                                    {{-- Reading Time --}}
                                    @if(!is_null($post->reading_time))

                                        <div
                                            class="flex items-center justify-between"
                                        >

                                            <span
                                                class="text-sm text-slate-500"
                                            >
                                                زمان مطالعه
                                            </span>

                                            <span
                                                class="text-sm font-semibold text-slate-200"
                                            >
                                                {{ $post->reading_time }} دقیقه
                                            </span>

                                        </div>

                                    @endif


                                    {{-- Published --}}
                                    @if($post->published_at)

                                        <div
                                            class="flex items-center justify-between"
                                        >

                                            <span
                                                class="text-sm text-slate-500"
                                            >
                                                انتشار
                                            </span>

                                            <time
                                                datetime="{{ jdate($post->published_at)->format('Y/m/d') }}"
                                                class="text-sm font-semibold text-slate-200"
                                            >
                                                {{ jdate($post->published_at)->format('Y/m/d') }}
                                            </time>

                                        </div>

                                    @endif


                                    {{-- Updated --}}
                                    @if(
                                        $post->updated_at &&
                                        $post->published_at &&
                                        $post->updated_at->gt($post->published_at)
                                    )

                                        <div
                                            class="flex items-center justify-between"
                                        >

                                            <span
                                                class="text-sm text-slate-500"
                                            >
                                                بروزرسانی
                                            </span>

                                            <time
                                                datetime="{{ jdate($post->updated_at)->format('Y/m/d') }}"
                                                class="text-sm font-semibold text-slate-200"
                                            >
                                                {{ jdate($post->updated_at)->format('Y/m/d') }}
                                            </time>

                                        </div>

                                    @endif

                                </div>

                            </div>


                            {{-- =================================================
                                 PROPARK CTA
                            ================================================== --}}

                            <div
                                class="relative overflow-hidden rounded-2xl border border-blue-400/10 bg-gradient-to-br from-blue-600/15 via-indigo-600/10 to-transparent p-6"
                            >

                                <div
                                    class="pointer-events-none absolute -right-12 -top-12 h-32 w-32 rounded-full bg-blue-500/10 blur-2xl"
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
                                            stroke-width="1.8"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M12 3l8 4v5c0 4.8-3.4 7.9-8 9-4.6-1.1-8-4.2-8-9V7l8-4z"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12l2 2 4-4"
                                            />

                                        </svg>

                                    </div>


                                    <h2
                                        class="text-lg font-black text-white"
                                    >
                                        پارکینگ هوشمند با ProPark
                                    </h2>


                                    <p
                                        class="mt-3 text-sm leading-7 text-slate-400"
                                    >
                                        راهکارهای هوشمند ProPark برای مدیریت و کنترل بهتر پارکینگ.
                                    </p>


                                    <a
                                        href="{{ route('home') }}"
                                        class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-blue-500"
                                    >

                                        بیشتر بدانید

                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19 12H5m7 7l-7-7 7-7"
                                            />

                                        </svg>

                                    </a>

                                </div>

                            </div>

                        </div>

                    </aside>

                </div>

            </section>


            {{-- =========================================================
                 RELATED POSTS
            ========================================================== --}}

            @if(isset($relatedPosts) && $relatedPosts->count())

                <section class="border-t border-white/5">

                    <div
                        class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20"
                    >

                        <div
                            class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between"
                        >

                            <div>

                                <p
                                    class="text-sm font-semibold text-blue-400"
                                >
                                    ادامه مطالعه
                                </p>


                                <h2
                                    class="mt-2 text-2xl font-black text-white sm:text-3xl"
                                >
                                    مطالب مرتبط
                                </h2>

                            </div>


                            <a
                                href="{{ route('blog.index') }}"
                                class="inline-flex items-center gap-2 text-sm font-medium text-slate-400 transition hover:text-white"
                            >

                                مشاهده همه مطالب

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
                                        d="M5 12h14m-6-6l6 6-6 6"
                                    />

                                </svg>

                            </a>

                        </div>


                        <div
                            class="grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3"
                        >

                            @foreach($relatedPosts as $relatedPost)

                                @php

                                    $relatedImage = filled($relatedPost->featured_image)
                                        ? asset('storage/' . $relatedPost->featured_image)
                                        : asset('images/default-blog.jpg');

                                @endphp


                                <a
                                    href="{{ route('blog.show', $relatedPost->slug) }}"
                                    class="group overflow-hidden rounded-2xl border border-white/10 bg-white/[0.025] transition duration-300 hover:-translate-y-1 hover:border-white/20 hover:bg-white/[0.04]"
                                >

                                    <div class="relative overflow-hidden">

                                        <img
                                            src="{{ $relatedImage }}"
                                            alt="{{ $relatedPost->title }}"
                                            class="aspect-[16/9] w-full object-cover transition duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        >


                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-slate-950/50 to-transparent"
                                        ></div>

                                    </div>


                                    <div class="p-5">

                                        @if($relatedPost->category)

                                            <span
                                                class="text-xs font-semibold text-blue-400"
                                            >
                                                {{ $relatedPost->category->name }}
                                            </span>

                                        @endif


                                        <h3
                                            class="mt-2 line-clamp-2 text-lg font-bold leading-8 text-white transition group-hover:text-blue-300"
                                        >
                                            {{ $relatedPost->title }}
                                        </h3>


                                        @if($relatedPost->published_at)

                                            <div
                                                class="mt-4 text-xs text-slate-500"
                                            >
                                                {{ $relatedPost->published_at->format('Y/m/d') }}
                                            </div>

                                        @endif

                                    </div>

                                </a>

                            @endforeach

                        </div>

                    </div>

                </section>

            @endif

        </main>

    </div>


    {{-- =============================================================
         JAVASCRIPT
    ============================================================== --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | Reading Progress
            |--------------------------------------------------------------------------
            */

            const progressBar =
                document.getElementById('reading-progress');

            function updateReadingProgress() {

                if (!progressBar) {
                    return;
                }

                const scrollTop = window.scrollY;

                const documentHeight =
                    document.documentElement.scrollHeight -
                    window.innerHeight;

                if (documentHeight <= 0) {
                    progressBar.style.width = '0%';
                    return;
                }

                const progress =
                    Math.min(
                        100,
                        Math.max(
                            0,
                            (scrollTop / documentHeight) * 100
                        )
                    );

                progressBar.style.width = progress + '%';
            }


            window.addEventListener(
                'scroll',
                updateReadingProgress,
                {
                    passive: true
                }
            );


            updateReadingProgress();


            /*
            |--------------------------------------------------------------------------
            | Table Of Contents
            |--------------------------------------------------------------------------
            */

            const article =
                document.getElementById('article-content');

            const toc =
                document.getElementById('toc');

            const tocWrapper =
                document.getElementById('toc-wrapper');


            if (article && toc) {

                const headings =
                    article.querySelectorAll('h2, h3');


                if (headings.length === 0) {

                    if (tocWrapper) {
                        tocWrapper.style.display = 'none';
                    }

                } else {

                    toc.innerHTML = '';


                    const list =
                        document.createElement('ul');

                    list.className =
                        'space-y-1';


                    headings.forEach(function (heading, index) {

                        if (!heading.id) {
                            heading.id =
                                'section-' + (index + 1);
                        }


                        const item =
                            document.createElement('li');


                        const link =
                            document.createElement('a');


                        link.href =
                            '#' + heading.id;


                        link.textContent =
                            heading.textContent.trim();


                        link.className =
                            'toc-link block rounded-lg px-3 py-2 text-sm leading-6 text-slate-400 transition hover:bg-white/[0.04] hover:text-white';


                        if (
                            heading.tagName.toLowerCase() ===
                            'h3'
                        ) {

                            link.classList.add(
                                'mr-4',
                                'text-xs'
                            );

                        }


                        link.addEventListener(
                            'click',
                            function (event) {

                                event.preventDefault();


                                const target =
                                    document.getElementById(
                                        heading.id
                                    );


                                if (!target) {
                                    return;
                                }


                                const offset = 100;


                                const targetPosition =
                                    target.getBoundingClientRect().top +
                                    window.scrollY -
                                    offset;


                                window.scrollTo({
                                    top: targetPosition,
                                    behavior: 'smooth'
                                });

                            }
                        );


                        item.appendChild(link);

                        list.appendChild(item);

                    });


                    toc.appendChild(list);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Font Size
            |--------------------------------------------------------------------------
            */

            const articleContent =
                document.getElementById(
                    'article-content'
                );


            const decreaseButton =
                document.getElementById(
                    'font-decrease'
                );


            const increaseButton =
                document.getElementById(
                    'font-increase'
                );


            let articleFontSize = 18;


            function updateFontSize() {

                if (!articleContent) {
                    return;
                }

                articleContent.style.fontSize =
                    articleFontSize + 'px';
            }


            if (decreaseButton) {

                decreaseButton.addEventListener(
                    'click',
                    function () {

                        if (articleFontSize > 14) {

                            articleFontSize -= 2;

                            updateFontSize();

                        }

                    }
                );

            }


            if (increaseButton) {

                increaseButton.addEventListener(
                    'click',
                    function () {

                        if (articleFontSize < 24) {

                            articleFontSize += 2;

                            updateFontSize();

                        }

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Copy Article Link
            |--------------------------------------------------------------------------
            */

            const copyButton =
                document.getElementById('copy-link');


            const copyToast =
                document.getElementById('copy-toast');


            if (copyButton) {

                copyButton.addEventListener(
                    'click',
                    async function () {

                        const url =
                            window.location.href;


                        try {

                            if (
                                navigator.clipboard &&
                                window.isSecureContext
                            ) {

                                await navigator.clipboard.writeText(
                                    url
                                );

                            } else {

                                const textarea =
                                    document.createElement(
                                        'textarea'
                                    );


                                textarea.value = url;

                                textarea.style.position =
                                    'fixed';

                                textarea.style.opacity =
                                    '0';


                                document.body.appendChild(
                                    textarea
                                );


                                textarea.focus();

                                textarea.select();


                                document.execCommand(
                                    'copy'
                                );


                                textarea.remove();

                            }


                            if (copyToast) {

                                copyToast.classList.remove(
                                    'hidden'
                                );


                                setTimeout(
                                    function () {

                                        copyToast.classList.add(
                                            'hidden'
                                        );

                                    },
                                    2000
                                );

                            }

                        } catch (error) {

                            console.error(
                                'Unable to copy link:',
                                error
                            );

                        }

                    }
                );

            }

        });
    </script>

</x-app-layout>
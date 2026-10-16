<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'داشبورد مدیریت') | AvaPark</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        :root {
            color-scheme: dark;
            --pp-bg: #0b1020;
            --pp-panel: rgba(20, 27, 45, .88);
            --pp-border: rgba(148, 163, 184, .13);
            --pp-blue: #3b82f6;
            --pp-muted: #94a3b8;
        }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background:
                radial-gradient(ellipse at 85% 0%, rgba(37,99,235,.12), transparent 36%),
                radial-gradient(ellipse at 0% 55%, rgba(6,182,212,.055), transparent 32%),
                var(--pp-bg);
            color: #e5e7eb;
            font-family: Vazirmatn, Tahoma, sans-serif;
        }

        .pp-sidebar {
            background: linear-gradient(180deg, #111827 0%, #0d1424 100%);
            border-left: 1px solid var(--pp-border);
        }

        .pp-panel {
            background: var(--pp-panel);
            border: 1px solid var(--pp-border);
            box-shadow: 0 12px 35px rgba(0,0,0,.12);
            backdrop-filter: blur(16px);
        }

        .pp-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 13px;
            border: 1px solid transparent;
            border-radius: 12px;
            color: #9caec5;
            font-size: 13px;
            transition: background .2s, color .2s, border-color .2s;
        }

        .pp-nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,.045);
        }

        .pp-nav-link.active {
            color: #93c5fd;
            background: linear-gradient(100deg, rgba(37,99,235,.22), rgba(37,99,235,.07));
            border-color: rgba(59,130,246,.3);
            box-shadow: inset 3px 0 0 #3b82f6;
        }

        .pp-nav-link svg { width: 19px; height: 19px; flex-shrink: 0; }

        .pp-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pp-section-title::before {
            content: "";
            display: block;
            width: 4px;
            height: 20px;
            border-radius: 10px;
            background: linear-gradient(180deg, #60a5fa, #6366f1);
        }

        .pp-scrollbar { scrollbar-width: thin; scrollbar-color: #334155 transparent; }

        .pp-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .pp-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 8px; }

        .pp-glow {
            position: absolute;
            width: 190px;
            height: 190px;
            border-radius: 999px;
            filter: blur(65px);
            opacity: .13;
            pointer-events: none;
        }

        .pp-stat {
            position: relative;
            overflow: hidden;
            isolation: isolate;
            transition: transform .22s, border-color .22s;
        }

        .pp-stat:hover {
            transform: translateY(-3px);
            border-color: rgba(96,165,250,.32);
        }

        .pp-stat-icon {
            display: grid;
            place-items: center;
            width: 46px;
            height: 46px;
            border-radius: 15px;
            border: 1px solid rgba(255,255,255,.07);
        }

        .pp-stat-icon svg { width: 22px; height: 22px; }

        .pp-table th {
            color: #94a3b8;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            padding: 13px 12px;
            text-align: right;
        }

        .pp-table td {
            padding: 14px 12px;
            font-size: 12px;
            border-top: 1px solid rgba(148,163,184,.09);
            white-space: nowrap;
        }

        .pp-table tbody tr { transition: background .18s; }
        .pp-table tbody tr:hover { background: rgba(59,130,246,.045); }

        .pp-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
            padding: 5px 9px;
            font-size: 11px;
            border: 1px solid currentColor;
        }

        .pp-status::before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .pp-chart-wrap { position: relative; width: 100%; min-height: 260px; }

        @media (max-width: 767px) {
            .pp-chart-wrap { min-height: 225px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen antialiased"
      x-data="{ sidebarOpen: false, sidebarCollapsed: false }">

    {{-- Mobile backdrop --}}
    <div x-cloak x-show="sidebarOpen"
         x-transition.opacity
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-slate-950/75 backdrop-blur-sm lg:hidden">
    </div>

    <div class="min-h-screen">

        {{-- Sidebar --}}
        <aside
            class="pp-sidebar fixed inset-y-0 right-0 z-50 flex flex-col w-[264px]
                   transition-all duration-300 lg:translate-x-0"
            :class="[
                sidebarOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0',
                sidebarCollapsed ? 'lg:w-[82px]' : 'lg:w-[264px]'
            ]">

            <div class="flex h-[76px] items-center justify-between border-b border-white/[.07] px-5">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex min-w-0 items-center gap-3">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-2xl
                                 border border-blue-400/25 bg-gradient-to-br
                                 from-blue-500/25 to-indigo-600/10 text-blue-300">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                             stroke-width="1.8" class="h-6 w-6">
                            <path d="M12 2.8 20 7.4v9.2L12 21.2 4 16.6V7.4L12 2.8Z"/>
                            <path d="m9 9 3-1.7L15 9v6l-3 1.7L9 15V9Z"/>
                        </svg>
                    </span>
                    <span x-show="!sidebarCollapsed || window.innerWidth < 1024"
                          class="min-w-0">
                        <span class="block text-lg font-black tracking-tight text-white">
                            Ava<span class="text-blue-400">Park</span>
                        </span>
                        <span class="block text-[10px] tracking-[.18em] text-slate-500">
                            CONTROL CENTER
                        </span>
                    </span>
                </a>

                <button @click="sidebarOpen = false"
                        class="rounded-lg p-2 text-slate-400 hover:bg-white/5 hover:text-white lg:hidden"
                        aria-label="بستن منو">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2">
                        <path d="m6 6 12 12M18 6 6 18"/>
                    </svg>
                </button>

                <button @click="sidebarCollapsed = !sidebarCollapsed"
                        class="hidden rounded-lg border border-white/10 p-1.5 text-slate-400
                               transition hover:bg-white/5 hover:text-white lg:block"
                        :aria-label="sidebarCollapsed ? 'باز کردن سایدبار' : 'جمع کردن سایدبار'">
                    <svg class="h-4 w-4 transition-transform"
                         :class="sidebarCollapsed ? 'rotate-180' : ''"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m14 7-5 5 5 5"/>
                    </svg>
                </button>
            </div>

            <div class="pp-scrollbar flex-1 overflow-y-auto px-3 py-5">
                <p x-show="!sidebarCollapsed"
                   class="mb-3 px-3 text-[10px] font-bold tracking-[.16em] text-slate-600">
                    منوی اصلی
                </p>

                @include('admin.layout.navigation')
            </div>

            <div class="border-t border-white/[.07] p-3">
                <div class="flex items-center gap-3 rounded-xl bg-white/[.035] p-3">
                    <div class="grid h-9 w-9 shrink-0 place-items-center rounded-xl
                                bg-gradient-to-br from-blue-500/25 to-indigo-500/20
                                text-sm font-bold text-blue-200">
                        {{ mb_substr(auth()->user()->name ?? 'A', 0, 1) }}
                    </div>
                    <div x-show="!sidebarCollapsed" class="min-w-0 flex-1">
                        <p class="truncate text-xs font-semibold text-white">
                            {{ auth()->user()->name ?? 'مدیر' }}
                        </p>
                        <p class="mt-1 text-[10px] text-slate-500">مدیر سیستم</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="min-h-screen transition-all duration-300 lg:mr-[264px]"
             :class="sidebarCollapsed ? 'lg:mr-[82px]' : 'lg:mr-[264px]'">

            {{-- Header --}}
            <header class="sticky top-0 z-30 border-b border-white/[.07]
                           bg-[#0b1020]/85 backdrop-blur-xl">
                <div class="flex min-h-[76px] items-center justify-between gap-4 px-4 sm:px-6 xl:px-8">

                    <div class="flex min-w-0 items-center gap-3">
                        <button @click="sidebarOpen = true"
                                class="grid h-10 w-10 shrink-0 place-items-center rounded-xl
                                       border border-white/10 bg-white/[.04] text-slate-300
                                       hover:bg-white/[.08] lg:hidden"
                                aria-label="باز کردن منو">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2">
                                <path d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>

                        <div class="min-w-0">
                            <div class="flex items-center gap-2 text-[10px] text-slate-500">
                                <span>AvaPark</span>
                                <span>/</span>
                                <span class="text-blue-400">@yield('breadcrumb', 'مدیریت')</span>
                            </div>
                            <h1 class="mt-1 truncate text-base font-bold text-white sm:text-lg">
                                @yield('header-title', 'پنل مدیریت')
                            </h1>
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-2.5 sm:gap-3">
                        {{-- دکمه انتقال به پنل کاربری عادی --}}
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center gap-2 rounded-xl border border-blue-500/30
                                  bg-blue-600/10 px-3.5 py-2 text-xs font-semibold text-blue-300
                                  shadow-sm transition hover:bg-blue-600 hover:text-white active:scale-95">
                            <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span class="hidden sm:inline">{{ __('ورود به پنل کاربری عادی') }}</span>
                            <span class="sm:hidden">{{ __('پنل کاربری') }}</span>
                        </a>

                        {{-- نشانگر آنلاین بودن پنل --}}
                        <div class="hidden items-center gap-2 rounded-xl border border-emerald-400/15
                                    bg-emerald-400/[.06] px-3 py-2 sm:flex">
                            <span class="relative flex h-2 w-2">
                                <span class="absolute inline-flex h-full w-full animate-ping
                                             rounded-full bg-emerald-400 opacity-40"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            </span>
                            <span class="text-[11px] text-emerald-300">پنل فعال</span>
                        </div>
                    </div>
                </div>
            </header>

            <main class="px-4 py-6 sm:px-6 sm:py-8 xl:px-8">
                @if (session('success'))
                    <div class="mb-6 flex items-center gap-3 rounded-2xl border
                                border-emerald-400/20 bg-emerald-400/[.07]
                                px-4 py-3 text-sm text-emerald-300">
                        <span class="grid h-8 w-8 place-items-center rounded-xl bg-emerald-400/10">✓</span>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl border border-rose-400/20
                                bg-rose-400/[.07] px-4 py-3 text-sm text-rose-300">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="border-t border-white/[.06] px-4 py-5 sm:px-8">
                <div class="flex flex-col gap-2 text-[10px] text-slate-600 sm:flex-row
                            sm:items-center sm:justify-between">
                    <span>© {{ date('Y') }} AvaPark — تمامی حقوق محفوظ است.</span>
                    <span>پنل مدیریت · نسخه وب</span>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>


<nav class="space-y-1.5" aria-label="ناوبری مدیریت">

    {{-- داشبورد --}}
    <a href="{{ route('admin.dashboard') }}"
       title="داشبورد"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">داشبورد</span>
        @if(request()->routeIs('admin.dashboard'))
            <span x-show="!sidebarCollapsed" class="h-1.5 w-1.5 rounded-full bg-blue-400"></span>
        @endif
    </a>

    <div x-show="!sidebarCollapsed"
         class="px-3 pb-1 pt-5 text-[10px] font-bold tracking-wider text-slate-600">
        مدیریت کاربران و خدمات
    </div>

    {{-- کاربران --}}
    <a href="{{ route('admin.users.index') }}"
       title="کاربران"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="10" cy="7" r="4"/>
            <path d="M20 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">کاربران</span>
    </a>

    {{-- اشتراک‌ها --}}
    <a href="{{ route('admin.subscriptions.index') }}"
       title="اشتراک‌ها و پشتیبانی ها"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.subscriptions.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <rect x="3" y="5" width="18" height="14" rx="2.5"/>
            <path d="M3 10h18M7 15h4"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">اشتراک‌ها و پشتیبانی ها</span>
    </a>

    {{-- فروشگاه --}}
    <a href="{{ route('admin.store.index') }}"
       title="فروشگاه"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.store.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <path d="M3 4h2l2.2 11.2a2 2 0 0 0 2 1.6h7.6a2 2 0 0 0 2-1.6L21 8H6"/>
            <circle cx="10" cy="20" r="1"/>
            <circle cx="18" cy="20" r="1"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">فروشگاه</span>
    </a>

    {{-- مقالات --}}
    <a href="{{ route('admin.posts.index') }}"
       title="مقالات"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <path d="M5 3h11l4 4v14H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
            <path d="M15 3v5h5M8 12h8M8 16h8"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">مقالات</span>
    </a>

    {{-- لایسنس‌ها --}}
    <a href="{{ route('admin.licenses.create') }}"
       title="ایجاد لایسنس"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.licenses.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <circle cx="8" cy="15" r="4"/>
            <path d="m11 12 8-8 3 3-8 8M17 7l3 3"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">ایجاد لایسنس</span>
    </a>

    <div x-show="!sidebarCollapsed"
         class="px-3 pb-1 pt-5 text-[10px] font-bold tracking-wider text-slate-600">
        ابزارها و زیرساخت
    </div>

    {{-- دیتابیس --}}
    <a href="{{ route('admin.database.index') }}"
       title="دیتابیس"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.database.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <ellipse cx="12" cy="5" rx="8" ry="3"/>
            <path d="M4 5v14c0 1.7 3.6 3 8 3s8-1.3 8-3V5"/>
            <path d="M4 12c0 1.7 3.6 3 8 3s8-1.3 8-3"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">دیتابیس</span>
    </a>

    {{-- مانیتورینگ --}}
    <a href="{{ route('admin.monitoring.index') }}"
       title="مانیتورینگ سایت و سرور"
       @click="sidebarOpen = false"
       class="pp-nav-link {{ request()->routeIs('admin.monitoring.*') ? 'active' : '' }}">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
            <rect x="3" y="4" width="18" height="13" rx="2"/>
            <path d="M8 21h8M12 17v4M6 11h3l2-4 3 8 2-4h2"/>
        </svg>
        <span x-show="!sidebarCollapsed" class="flex-1">مانیتورینگ</span>
    </a>

    {{-- خروج از حساب --}}
    <div class="my-4 border-t border-white/[.07]"></div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
                title="خروج از حساب کاربری"
                @click="if (!confirm('آیا مطمئن هستید که می‌خواهید از حساب کاربری خارج شوید؟')) $event.preventDefault()"
                class="pp-nav-link w-full text-right text-rose-300 hover:border-rose-400/15 hover:bg-rose-400/[.06] hover:text-rose-200">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                <path d="M10 17l5-5-5-5M15 12H3"/>
                <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
            </svg>
            <span x-show="!sidebarCollapsed" class="flex-1">خروج از حساب</span>
        </button>
    </form>

</nav>

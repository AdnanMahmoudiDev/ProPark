<nav x-data="{ open: false }" class="bg-gray-950/95 backdrop-blur-md border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            
            <div class="flex items-center gap-8">
                <!-- لوگو -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 shrink-0">
                    <x-application-logo class="block h-9 w-auto fill-current text-violet-500" />
                    <span class="text-xl font-bold tracking-tight text-white">ProPark</span>
                </a>

                <!-- لینک های navbar -->
                <div class="hidden sm:flex sm:items-center sm:gap-6">
                    <x-nav-link
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                        class="text-sm font-medium text-gray-300 hover:text-violet-400 transition"
                    >
                        {{ __('داشبورد کاربری') }}
                    </x-nav-link>
                </div>
            </div>

            
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="left" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-4 py-2 rounded-xl border border-gray-800 bg-gray-900 text-sm font-medium text-gray-300 hover:text-white hover:border-violet-500/50 hover:bg-gray-800 transition duration-200">
                            <span>{{ Auth::user()->name }}</span>

                            <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-800 bg-gray-900">
                            <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="bg-gray-900">
                            <x-dropdown-link :href="route('profile.edit')" class="text-gray-300 hover:text-white hover:bg-gray-800">
                                {{ __('پروفایل') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link
                                    :href="route('logout')"
                                    class="text-red-400 hover:text-red-300 hover:bg-gray-800"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                >
                                    {{ __('خروج از حساب کاربری') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- دکمه ی همبرگری برای مرورگر موبایل -->
            <div class="flex items-center sm:hidden">
                <button
                    @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 hover:text-white hover:bg-gray-900 focus:outline-none transition duration-150"
                >
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path
                            :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                        <path
                            :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-gray-800 bg-gray-950">
        <div class="pt-3 pb-2 space-y-1 px-4">
            <x-responsive-nav-link
                :href="route('dashboard')"
                :active="request()->routeIs('dashboard')"
                class="text-gray-300 hover:text-violet-400 hover:bg-gray-900 rounded-xl"
            >
                {{ __('داشبورد کاربری') }}
            </x-responsive-nav-link>
        </div>

        
        <div class="pt-4 pb-4 border-t border-gray-800 px-4">
            <div class="mb-3">
                <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-400 mt-1">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-2">
                <x-responsive-nav-link
                    :href="route('profile.edit')"
                    class="text-gray-300 hover:text-white hover:bg-gray-900 rounded-xl"
                >
                    {{ __('پروفایل') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link
                        :href="route('logout')"
                        class="text-red-400 hover:text-red-300 hover:bg-gray-900 rounded-xl"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        {{ __('خروج از حساب کاربری') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

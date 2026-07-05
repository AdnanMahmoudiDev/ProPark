<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-2xl font-bold text-white leading-tight">
                    داشبورد کاربری
                </h2>

                <div class="flex items-center gap-2 mt-2 text-xs text-gray-500">
                    <span class="w-2 h-2 bg-violet-500 rounded-full animate-pulse"></span>

                    <span>
                        تاریخ امروز:
                        {{ jdate(now())->format('Y/m/d') }}
                    </span>
                </div>
            </div>

            <div class="hidden sm:flex items-center gap-3">
                <div class="px-4 py-2 rounded-xl border border-violet-800
                            bg-violet-900/20 text-violet-300 text-xs">
                    ProPark Panel
                </div>
            </div>

        </div>
    </x-slot>


    <div class="py-10 min-h-screen bg-[#0b0f19]">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- خوشامد گویی  --}}
            <div class="relative overflow-hidden
                        bg-gradient-to-br from-gray-900 to-gray-950
                        border border-gray-800
                        rounded-3xl p-7 shadow-2xl">

                <div class="absolute top-0 right-0 w-72 h-72
                            bg-violet-700/10 blur-3xl rounded-full"></div>

                <div class="relative z-10">

                    <div class="flex items-start justify-between flex-wrap gap-4">

                        <div class="flex items-center gap-3">

                            <div class="w-12 h-12 rounded-2xl
                                        bg-violet-600/20
                                        border border-violet-700
                                        flex items-center justify-center">

                                <svg class="w-6 h-6 text-violet-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>

                            </div>

                            <div>
                                <h3 class="text-xl font-bold text-white">
                                    خوش آمدی،
                                    {{ auth()->user()->name }}
                                </h3>

                                <p class="text-sm text-gray-400 mt-1">
                                    مدیریت حساب و اشتراک ProPark
                                </p>
                            </div>

                        </div>

                        <div class="px-4 py-2 rounded-xl
                                    border border-green-700
                                    bg-green-900/20
                                    text-green-400 text-xs font-medium">
                            حساب فعال
                        </div>

                    </div>

                </div>

            </div>



            {{-- وضعیت --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- کارت اشتراک --}}
                <div class="relative overflow-hidden
                            bg-gray-900/70
                            border border-gray-800
                            rounded-3xl p-6
                            hover:border-violet-700/50
                            transition duration-300">

                    <div class="absolute top-0 left-0 w-40 h-40
                                bg-violet-600/10 blur-3xl rounded-full">
                    </div>

                    <div class="relative z-10">

                        <div class="flex items-center justify-between">

                            <div>
                                <p class="text-sm text-gray-400">
                                    وضعیت اشتراک
                                </p>

                                <h3 class="mt-2 text-2xl font-bold text-white">
                                    @if($activeSubscription)
                                        اشتراک فعال
                                    @else
                                        بدون اشتراک
                                    @endif
                                </h3>
                            </div>

                            <div class="w-14 h-14 rounded-2xl
                                        bg-violet-600/20 border border-violet-700
                                        flex items-center justify-center">
                                <svg class="w-7 h-7 text-violet-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M12 8c-1.657 0-3 1.343-3 3v1H8a2 2 0 00-2 2v3h12v-3a2 2 0 00-2-2h-1v-1c0-1.657-1.343-3-3-3z"/>

                                </svg>
                            </div>

                        </div>



                        <div class="mt-6">

                            @if($activeSubscription)

                                <div class="flex items-center gap-2 text-green-400 text-sm">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    اشتراک شما فعال است
                                </div>

                                <div class="mt-3 text-sm text-gray-400">
                                    تاریخ انقضا:
                                    <span class="text-white font-medium">
                                        {{ jdate($activeSubscription->expires_at)->format('Y/m/d') }}
                                    </span>
                                </div>

                                {{-- دکمه اطلاعات بیشتر --}}
                                <a href="{{ route('subscription.details') }}"
                                   class="mt-5 inline-block px-5 py-3 rounded-xl
                                          bg-violet-600 hover:bg-violet-500
                                          text-white text-sm font-medium
                                          transition duration-200 shadow-lg">
                                    اطلاعات بیشتر
                                </a>

                            @else
                                <div class="text-sm text-red-400">
                                    اشتراک فعالی ندارید
                                </div>
                            @endif

                        </div>

                    </div>

                </div>






                {{-- کارت لایسنس --}}
                <div class="relative overflow-hidden
                            bg-gray-900/70
                            border border-gray-800 rounded-3xl p-6
                            hover:border-violet-700/50 transition duration-300">

                    <div class="absolute top-0 right-0 w-40 h-40
                                bg-violet-600/10 blur-3xl rounded-full"></div>

                    <div class="relative z-10">

                        <div class="flex items-center justify-between">

                            <div class="w-full">

                                <p class="text-sm text-gray-400">
                                    کد لایسنس
                                </p>

                                <div class="mt-4">
                                    @if($license)
                                        <div class="px-4 py-4 rounded-2xl
                                                    bg-black/40 border border-gray-700
                                                    text-violet-400 font-mono
                                                    text-sm sm:text-base break-all select-all">
                                            {{ $license->license_key }}
                                        </div>
                                    @else
                                        <div class="text-gray-500 text-lg">
                                            —
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="hidden sm:flex w-14 h-14 rounded-2xl
                                        bg-violet-600/20 border border-violet-700
                                        items-center justify-center mr-5">
                                <svg class="w-7 h-7 text-violet-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                                </svg>
                            </div>

                        </div>


                        <div class="mt-5">
                            @if($license)
                                <div class="flex items-center gap-2 text-green-400 text-sm">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    لایسنس فعال
                                </div>
                            @else
                                <div class="text-sm text-red-400">
                                    لایسنسی برای شما ثبت نشده است
                                </div>
                            @endif
                        </div>

                    </div>

                </div>

            </div>








            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- عملیات سریع --}}
                <div class="lg:col-span-2
                            bg-gray-900/70 border border-gray-800
                            rounded-3xl p-6">

                    <div>
                        <h3 class="text-lg font-bold text-white">عملیات سریع</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            دسترسی سریع به بخش‌های مهم
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">

                        {{-- خرید اشتراک --}}
                        <a href="{{ route('shop') }}"
                           class="group p-5 rounded-2xl border border-gray-800
                                  bg-black/30 hover:border-violet-700
                                  hover:bg-violet-900/10 transition duration-300">

                            <div class="flex items-center justify-between">

                                <div>
                                    <h4 class="text-white font-semibold">خرید اشتراک</h4>
                                    <p class="text-sm text-gray-500 mt-1">
                                        مشاهده پلن‌ها و خرید
                                    </p>
                                </div>

                                <svg class="w-5 h-5 text-gray-600
                                            group-hover:text-violet-400 transition"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M14 5l7 7m0 0l-7 7m7-7H3"/>

                                </svg>

                            </div>

                        </a>


                        {{-- ویرایش جساب کاربری --}}
                        <a href="{{ route('profile.edit') }}"
                           class="group p-5 rounded-2xl border border-gray-800
                                  bg-black/30 hover:border-violet-700
                                  hover:bg-violet-900/10 transition duration-300">

                            <div class="flex items-center justify-between">

                                <div>
                                    <h4 class="text-white font-semibold">
                                        ویرایش پروفایل
                                    </h4>

                                    <p class="text-sm text-gray-500 mt-1">
                                        مدیریت اطلاعات حساب
                                    </p>
                                </div>

                                <svg class="w-5 h-5 text-gray-600
                                            group-hover:text-violet-400 transition"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M11 5h2m-1-1v2m-7 4h14l-1 9H6l-1-9z"/>

                                </svg>

                            </div>

                        </a>

                    </div>

                </div>


                
                {{-- اطلاعات حساب کاربری --}}
                <div class="bg-gray-900/70 border border-gray-800 rounded-3xl p-6">

                    <div class="flex items-center gap-2">
                        <span class="w-2 h-6 bg-violet-500 rounded-full"></span>
                        <h3 class="text-lg font-bold text-white">اطلاعات حساب</h3>
                    </div>

                    <div class="mt-6 space-y-5">

                        <div>
                            <p class="text-xs text-gray-500">ایمیل</p>
                            <p class="mt-1 text-sm text-gray-300 break-all font-mono">
                                {{ auth()->user()->email }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">شماره موبایل</p>
                            <p class="mt-1 text-sm text-gray-300">
                                {{ auth()->user()->phone_number ?? 'ثبت نشده' }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-gray-800">
                            <p class="text-xs text-gray-500">تاریخ عضویت</p>
                            <p class="mt-1 text-sm text-gray-300">
                                {{ jdate(auth()->user()->created_at)->format('Y/m/d') }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>

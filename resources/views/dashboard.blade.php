<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between ">
            <h2 class="font-semibold text-xl text-white leading-tight">
                داشبورد
                <br>
                <span class="text-sm text-gray-400">
                    <span>تاریخ امروز:</span>
                    {{ jdate(now())->format('Y/m/d ') }}
                </span>
            </h2>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- خوش امد گویی به کاربر --}}
            <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg">
                <div class="p-6 flex flex-col gap-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg font-semibold text-white">
                                خوش آمدی، {{ auth()->user()->name }}!
                            </p>
                        </div>

                        <div class="text-xs px-3 py-1 rounded-full
                                    bg-violet-900/40 text-violet-300 border border-violet-800">
                            حساب: فعال
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-800">
                        <p class="text-sm text-gray-400">
                            پنل تست ProPark
                        </p>
                    </div>
                </div>
            </div>

            {{-- اطلاعات اشتراک و لایسن فعال و ... --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-400">اشتراک فعال</p>
                    <p class="mt-2 text-2xl font-bold text-white">—</p>
                    <p class="mt-2 text-xs text-gray-500">به زودی متصل به دیتابیس</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-400">تعداد لایسنس‌ها</p>
                    <p class="mt-2 text-2xl font-bold text-white">—</p>
                    <p class="mt-2 text-xs text-gray-500">به زودی</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-400">درخواست‌های API امروز</p>
                    <p class="mt-2 text-2xl font-bold text-white">—</p>
                    <p class="mt-2 text-xs text-gray-500">به زودی</p>
                </div>

                <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg p-5">
                    <p class="text-xs text-gray-400">نقش کاربر</p>
                    <p class="mt-2 text-2xl font-bold text-white">
                        {{ auth()->user()->role ?? '—' }}
                    </p>
                </div>

            </div>

            {{-- دسترسی های سریع برای خرید اشتراک و ... --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

                <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg p-6 lg:col-span-2">
                    <h3 class="text-base font-semibold text-white">
                        دسترسی سریع
                    </h3>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">

                        <a href="#"
                           class="block rounded-lg border border-gray-800 p-4
                                  bg-gray-950 hover:border-violet-900/60
                                  hover:bg-gray-900 transition">
                            <p class="font-medium text-white">خرید اشتراک</p>
                            <p class="mt-1 text-sm text-gray-400">به زودی</p>
                        </a>

                        <a href="#"
                           class="block rounded-lg border border-gray-800 p-4
                                  bg-gray-950 hover:border-violet-900/60
                                  hover:bg-gray-900 transition">
                            <p class="font-medium text-white">لایسنس‌های من</p>
                            <p class="mt-1 text-sm text-gray-400">به زودی</p>
                        </a>

                        <a href="#"
                           class="block rounded-lg border border-gray-800 p-4
                                  bg-gray-950 hover:border-violet-900/60
                                  hover:bg-gray-900 transition">
                            <p class="font-medium text-white">مستندات API</p>
                            <p class="mt-1 text-sm text-gray-400">به زودی</p>
                        </a>

                        <a href="{{ route('profile.edit') }}"
                           class="block rounded-lg border border-gray-800 p-4
                                  bg-gray-950 hover:border-violet-900/60
                                  hover:bg-gray-900 transition">
                            <p class="font-medium text-white">ویرایش پروفایل</p>
                            <p class="mt-1 text-sm text-gray-400">اطلاعات حساب کاربری</p>
                        </a>

                    </div>
                </div>

                {{-- اطلاعات حساب کاربری --}}
                <div class="bg-gray-900 border border-gray-800 shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-base font-semibold text-white">
                        اطلاعات حساب
                    </h3>

                    <dl class="mt-4 space-y-3">
                        <div>
                            <dt class="text-xs text-gray-500">ایمیل</dt>
                            <dd class="text-sm text-white break-all">
                                {{ auth()->user()->email }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">شماره موبایل</dt>
                            <dd class="text-sm text-white">
                                {{ auth()->user()->phone_number ?? 'ثبت نشده' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-xs text-gray-500">تاریخ عضویت در سایت</dt>
                            <dd class="text-sm text-white">
                                {{ jdate(auth()->user()->created_at)->format('Y/m/d') }}
                            </dd>
                        </div>
                    </dl>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

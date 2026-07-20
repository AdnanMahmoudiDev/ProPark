<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">
                    تنظیمات پروفایل
                </h2>
                <p class="mt-1 text-sm text-gray-400">
                    مدیریت اطلاعات کاربری، شماره تماس و امنیت حساب
                </p>
            </div>

            <a
                href="{{ route('dashboard') }}"
                class="group inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-1 hover:scale-[1.01] hover:shadow-blue-500/40 focus:outline-none focus:ring-2 focus:ring-blue-400/60 whitespace-nowrap"
            >
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4 transition duration-300 group-hover:translate-x-1"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
                <span>بازگشت به داشبورد</span>
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="mx-auto max-w-4xl space-y-6 px-4 sm:px-6 lg:px-8">

            <div class="overflow-hidden rounded-3xl border border-white/5 bg-[#0f1420] shadow-xl shadow-black/20">
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-white/5 bg-[#0f1420] shadow-xl shadow-black/20">
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-phone-number-form')
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-white/5 bg-[#0f1420] shadow-xl shadow-black/20">
                <div class="p-6 sm:p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="overflow-hidden rounded-3xl border border-red-900/10 bg-[#0f1420] shadow-xl shadow-black/20">
                <div class="p-6 sm:p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

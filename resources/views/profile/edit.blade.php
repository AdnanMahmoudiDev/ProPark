<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ __('تنظیمات پروفایل') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">

            {{-- کارت اطلاعات اصلی پروفایل --}}
            <div class="border border-gray-800 bg-gray-900 p-6 shadow sm:rounded-2xl sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- کارت شماره موبایل --}}
            <div class="border border-gray-800 bg-gray-900 p-6 shadow sm:rounded-2xl sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-phone-number-form')
                </div>
            </div>

            {{-- کارت تغییر رمز عبور --}}
            <div class="border border-gray-800 bg-gray-900 p-6 shadow sm:rounded-2xl sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- کارت حذف حساب کاربری --}}
            <div class="border border-gray-800 bg-gray-900 p-6 shadow sm:rounded-2xl sm:p-8">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

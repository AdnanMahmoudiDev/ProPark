<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('تغییر رمز عبور') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('مطمئن شوید که حساب کاربری شما از یک رمز عبور طولانی و تصادفی برای امنیت بیشتر استفاده می‌کند.') }}
        </p>
    </header>

    @if (session('status') === 'password-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="mt-4 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-medium text-green-400"
        >
            {{ __('رمز عبور با موفقیت تغییر کرد.') }}
        </div>
    @endif

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label
                for="update_password_current_password"
                :value="__('رمز عبور فعلی')"
                class="text-gray-300"
            />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                class="mt-1 block w-full border-gray-800 bg-gray-950 text-white"
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label
                for="update_password_password"
                :value="__('رمز عبور جدید')"
                class="text-gray-300"
            />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                class="mt-1 block w-full border-gray-800 bg-gray-950 text-white"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label
                for="update_password_password_confirmation"
                :value="__('تکرار رمز عبور جدید')"
                class="text-gray-300"
            />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                class="mt-1 block w-full border-gray-800 bg-gray-950 text-white"
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-violet-600 hover:bg-violet-500">
                {{ __('ذخیره رمز عبور') }}
            </x-primary-button>
        </div>
    </form>
</section>

<section>
    <header>
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-blue-500/20 bg-blue-500/10 text-blue-300 shadow-lg shadow-blue-950/20">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M16.5 10.5V7.875a4.5 4.5 0 10-9 0V10.5m-.75 0h10.5A2.25 2.25 0 0119.5 12.75v6A2.25 2.25 0 0117.25 21h-10.5A2.25 2.25 0 014.5 18.75v-6A2.25 2.25 0 016.75 10.5z" />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold tracking-tight text-white">
                    {{ __('تغییر رمز عبور') }}
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-400">
                    {{ __('برای امنیت بیشتر، از یک رمز عبور طولانی، قوی و غیرقابل حدس استفاده کنید.') }}
                </p>
            </div>
        </div>
    </header>

    @if (session('status') === 'password-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="mt-5 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm text-emerald-300 shadow-sm"
        >
            <div class="flex items-start gap-3">
                <div class="mt-0.5 rounded-xl bg-emerald-500/15 p-2 text-emerald-400">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <p class="font-medium">
                    {{ __('رمز عبور با موفقیت تغییر کرد.') }}
                </p>
            </div>
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
                class="mt-2 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
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
                class="mt-2 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
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
                class="mt-2 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
                autocomplete="new-password"
            />

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold !text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:from-blue-500 hover:via-sky-500 hover:to-cyan-400 hover:shadow-blue-500/40 focus:ring-2 focus:ring-blue-400/60">
                {{ __('ذخیره رمز عبور') }}
            </x-primary-button>
        </div>
    </form>
</section>

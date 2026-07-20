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
                          d="M3 5.25a2.25 2.25 0 012.25-2.25h2.118c.966 0 1.8.691 1.98 1.64l.547 2.873a2.25 2.25 0 01-.654 2.057l-1.373 1.373a14.117 14.117 0 006.363 6.363l1.373-1.373a2.25 2.25 0 012.057-.654l2.873.547A2.01 2.01 0 0121 16.632v2.118A2.25 2.25 0 0118.75 21h-.75C9.716 21 3 14.284 3 6V5.25z" />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold tracking-tight text-white">
                    {{ __('به‌روزرسانی شماره موبایل') }}
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-400">
                    {{ __('شماره موبایل حساب کاربری خود را وارد و ذخیره کنید.') }}
                </p>
            </div>
        </div>
    </header>

    @if (session('status') === 'phone-number-updated')
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
                    {{ __('شماره موبایل با موفقیت ذخیره شد.') }}
                </p>
            </div>
        </div>
    @endif

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <input type="hidden" name="form_type" value="phone_number">

        <div>
            <x-input-label
                for="phone_number"
                :value="__('شماره موبایل')"
                class="text-gray-300"
            />

            <x-text-input
                id="phone_number"
                name="phone_number"
                type="text"
                class="mt-2 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
                :value="old('phone_number', $user->phone_number)"
                placeholder="09123456789"
                required
                maxlength="11"
                inputmode="numeric"
                autocomplete="tel"
                dir="ltr"
                pattern="09[0-9]{9}"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11)"
            />

            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold !text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:from-blue-500 hover:via-sky-500 hover:to-cyan-400 hover:shadow-blue-500/40 focus:ring-2 focus:ring-blue-400/60">
                {{ __('ذخیره شماره موبایل') }}
            </x-primary-button>
        </div>
    </form>
</section>

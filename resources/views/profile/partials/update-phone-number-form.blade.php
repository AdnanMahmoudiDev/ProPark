<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('به‌روزرسانی شماره موبایل') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('شماره موبایل حساب کاربری خود را وارد و ذخیره کنید.') }}
        </p>
    </header>

    @if (session('status') === 'phone-number-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="mt-4 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-medium text-green-400"
        >
            {{ __('شماره موبایل با موفقیت ذخیره شد.') }}
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
                class="text-gray-200"
            />

            <x-text-input
                id="phone_number"
                name="phone_number"
                type="text"
                class="mt-1 block w-full border-gray-700 bg-gray-950 text-white focus:border-violet-500 focus:ring-violet-500"
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

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-violet-600 hover:bg-violet-500">
                {{ __('ذخیره شماره موبایل') }}
            </x-primary-button>
        </div>
    </form>
</section>

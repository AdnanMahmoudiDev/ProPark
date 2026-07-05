<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-red-400">
            {{ __('حذف حساب کاربری') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('با حذف حساب کاربری، تمامی منابع و داده‌های شما برای همیشه پاک خواهد شد. قبل از حذف، لطفاً از هرگونه داده‌ای که می‌خواهید حفظ شود، نسخه پشتیبان تهیه کنید.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-500"
    >
        {{ __('حذف حساب کاربری') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="border border-gray-800 bg-gray-900 p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                {{ __('آیا مطمئن هستید که می‌خواهید حساب خود را حذف کنید؟') }}
            </h2>

            <p class="mt-1 text-sm text-gray-400">
                {{ __('با حذف حساب کاربری، تمامی منابع و داده‌های شما برای همیشه پاک خواهد شد. لطفاً رمز عبور خود را وارد کنید تا حذف دائمی حساب کاربری تایید شود.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" :value="__('رمز عبور')" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-800 bg-gray-950 text-white"
                    :placeholder="__('رمز عبور')"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    class="bg-gray-800 text-gray-300 hover:bg-gray-700"
                >
                    {{ __('انصراف') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 bg-red-600 hover:bg-red-500">
                    {{ __('حذف حساب کاربری') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

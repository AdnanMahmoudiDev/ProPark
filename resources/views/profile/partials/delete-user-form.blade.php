<section class="space-y-6">
    <header>
        <div class="flex items-start gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-red-500/20 bg-red-500/10 text-red-300 shadow-lg shadow-red-950/20">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="1.8"
                          d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z" />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold tracking-tight text-red-300">
                    {{ __('حذف حساب کاربری') }}
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-400">
                    {{ __('با حذف حساب کاربری، تمامی منابع و داده‌های شما برای همیشه پاک خواهد شد. قبل از حذف، لطفاً از هر اطلاعاتی که می‌خواهید نگه دارید نسخه پشتیبان تهیه کنید.') }}
                </p>
            </div>
        </div>
    </header>

    <div class="rounded-3xl border border-red-900/20 bg-red-950/10 p-5 shadow-xl shadow-black/10 backdrop-blur-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h3 class="text-sm font-semibold text-red-200">
                    {{ __('اقدام غیرقابل بازگشت') }}
                </h3>
                <p class="mt-1 text-sm text-gray-400">
                    {{ __('این عملیات دائمی است و پس از انجام، امکان بازیابی حساب وجود نخواهد داشت.') }}
                </p>
            </div>

            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-red-600 via-red-500 to-rose-500 px-5 py-3 text-sm font-bold !text-white shadow-xl shadow-red-600/20 transition duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:from-red-500 hover:via-rose-500 hover:to-pink-500 hover:shadow-red-500/35 focus:ring-2 focus:ring-red-400/60"
            >
                {{ __('حذف حساب کاربری') }}
            </x-danger-button>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="rounded-3xl border border-white/5 bg-[#0f1420] p-6 shadow-2xl shadow-black/30">
            @csrf
            @method('delete')

            <div class="flex items-start gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-2xl border border-red-500/20 bg-red-500/10 text-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="1.8"
                              d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-bold tracking-tight text-white">
                        {{ __('آیا مطمئن هستید که می‌خواهید حساب خود را حذف کنید؟') }}
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-gray-400">
                        {{ __('با حذف حساب کاربری، تمامی منابع و داده‌های شما برای همیشه پاک خواهد شد. لطفاً رمز عبور خود را وارد کنید تا حذف دائمی حساب کاربری تایید شود.') }}
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="password" :value="__('رمز عبور')" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-red-500 focus:ring-red-500 sm:w-3/4"
                    :placeholder="__('رمز عبور')"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <x-secondary-button
                    x-on:click="$dispatch('close')"
                    class="inline-flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 px-5 py-3 text-sm font-medium text-gray-200 transition duration-300 hover:bg-white/10 focus:ring-2 focus:ring-blue-400/40"
                >
                    {{ __('انصراف') }}
                </x-secondary-button>

                <x-danger-button class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-red-600 via-red-500 to-rose-500 px-5 py-3 text-sm font-bold !text-white shadow-xl shadow-red-600/20 transition duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:from-red-500 hover:via-rose-500 hover:to-pink-500 hover:shadow-red-500/35 focus:ring-2 focus:ring-red-400/60 sm:ms-3">
                    {{ __('حذف حساب کاربری') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

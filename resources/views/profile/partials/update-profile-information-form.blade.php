<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('اطلاعات پروفایل') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('اطلاعات پروفایل و آدرس ایمیل حساب کاربری خود را به‌روزرسانی کنید.') }}
        </p>
    </header>

    @if (session('status') === 'profile-information-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="mt-4 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-medium text-green-400"
        >
            {{ __('اطلاعات پروفایل با موفقیت تغییر کرد.') }}
        </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <input type="hidden" name="form_type" value="profile_information">

        <div>
            <x-input-label for="name" :value="__('نام')" class="text-gray-300" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full border-gray-800 bg-gray-950 text-white"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('ایمیل')" class="text-gray-300" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full border-gray-800 bg-gray-950 text-white"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                dir="ltr"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-gray-400">
                        {{ __('ایمیل شما تایید نشده است.') }}
                        <button
                            form="send-verification"
                            class="ms-1 text-sm text-violet-400 underline hover:text-violet-300"
                        >
                            {{ __('برای ارسال مجدد ایمیل تایید کلیک کنید.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-3 rounded-xl border border-green-500/30 bg-green-500/10 px-4 py-3 text-sm font-medium text-green-400">
                            {{ __('یک لینک تایید جدید به آدرس ایمیل شما ارسال شد.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-violet-600 hover:bg-violet-500">
                {{ __('ذخیره اطلاعات پروفایل') }}
            </x-primary-button>
        </div>
    </form>
</section>

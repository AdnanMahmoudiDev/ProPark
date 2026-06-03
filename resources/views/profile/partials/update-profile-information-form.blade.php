<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('اطلاعات پروفایل') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __("اطلاعات پروفایل و آدرس ایمیل حساب کاربری خود را به‌روزرسانی کنید.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('نام')" class="text-gray-300" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-950 border-gray-800 text-white" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('ایمیل')" class="text-gray-300" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-950 border-gray-800 text-white" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        {{ __('ایمیل شما تایید نشده است.') }}
                        <button form="send-verification" class="underline text-sm text-violet-400 hover:text-violet-300">
                            {{ __('برای ارسال مجدد ایمیل تایید کلیک کنید.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            {{ __('یک لینک تایید جدید به آدرس ایمیل شما ارسال شد.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-violet-600 hover:bg-violet-500">{{ __('ذخیره') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-gray-400">{{ __('ذخیره شد.') }}</p>
            @endif
        </div>
    </form>
</section>

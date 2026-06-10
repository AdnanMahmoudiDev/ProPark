<x-guest-layout>
    <div class="flex flex-col items-center w-full">
         {{-- لوگو  --}}
        <div class="mb-4">
            <x-application-logo class="w-20 h-20 fill-current text-violet-500" />
        </div>

        <h2 class="text-2xl font-bold text-white mb-6">تعیین رمز عبور جدید</h2>

        <div class="w-full sm:max-w-md px-6 py-8   overflow-hidden sm:rounded-2xl">
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                 {{-- توکن ریست پسورد  --}}
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                 {{-- ایمیل  --}}
                <div>
                    <x-input-label for="email" class="text-gray-300" :value="__('ایمیل')" />
                    <x-text-input id="email" class="block mt-2 w-full bg-gray-950 border-gray-800 text-white rounded-xl" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
                </div>

                {{--  پسورد  --}}
                <div class="mt-4">
                    <x-input-label for="password" class="text-gray-300" :value="__('رمز عبور جدید')" />
                    <x-text-input id="password" class="block mt-2 w-full bg-gray-950 border-gray-800 text-white rounded-xl" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                 {{-- تایید پسورد  --}}
                <div class="mt-4">
                    <x-input-label for="password_confirmation" class="text-gray-300" :value="__('تکرار رمز عبور')" />
                    <x-text-input id="password_confirmation" class="block mt-2 w-full bg-gray-950 border-gray-800 text-white rounded-xl" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
                </div>

                <div class="flex items-center justify-end mt-8">
                    <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2 shadow-lg shadow-violet-900/20 transition-all duration-200">
                        {{ __('ذخیره رمز عبور') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

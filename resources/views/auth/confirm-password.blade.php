<x-guest-layout>
    <div class="flex flex-col items-center w-full">
        <!-- لوگو -->
        <div class="mb-4">
            <x-application-logo class="w-20 h-20 fill-current text-violet-500" />
        </div>

        <h2 class="text-2xl font-bold text-white mb-6">تایید امنیتی</h2>

        <!-- کارت اصلی -->
        <div class="w-full sm:max-w-md px-6 py-8 bg-gray-900 border border-gray-800 shadow-xl overflow-hidden sm:rounded-2xl">
            
            <div class="mb-6 text-sm text-gray-400 leading-relaxed">
                {{ __('این یک بخش امن از برنامه است. لطفاً قبل از ادامه، رمز عبور خود را تایید کنید.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- پسورد -->
                <div>
                    <x-input-label for="password" class="text-gray-300" :value="__('رمز عبور')" />
                    <x-text-input id="password" 
                                  class="block mt-2 w-full bg-gray-950 border-gray-800 text-white focus:border-violet-500 focus:ring-violet-500 rounded-xl"
                                  type="password"
                                  name="password"
                                  required 
                                  autocomplete="current-password" />
                    
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
                </div>

                <div class="flex justify-end mt-8">
                    <x-primary-button class="bg-violet-600 hover:bg-violet-500 rounded-xl px-6 py-2 shadow-lg shadow-violet-900/20 transition-all duration-200">
                        {{ __('تایید و ادامه') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

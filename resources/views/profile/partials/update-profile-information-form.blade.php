@php
    $isRtl = app()->getLocale() === 'fa';
    $align = $isRtl ? 'text-right' : 'text-left';
@endphp

<section dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <header>
        <div class="flex items-start gap-3 {{ $align }}">
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl border border-blue-500/20 bg-blue-500/10 text-blue-300 shadow-lg shadow-blue-950/20">
                <svg class="h-6 w-6 text-blue-400"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold tracking-tight text-white">
                    {{ __('profile_info_title') }}
                </h2>

                <p class="mt-1 text-sm leading-6 text-gray-400">
                    {{ __('profile_info_desc') }}
                </p>
            </div>
        </div>
    </header>

    @if (session('status') === 'profile-information-updated')
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            x-init="setTimeout(() => show = false, 3000)"
            class="mt-5 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm text-emerald-300 shadow-sm"
        >
            <div class="flex items-start gap-3 {{ $align }}">
                <div class="mt-0.5 rounded-xl bg-emerald-500/15 p-2 text-emerald-400 flex-shrink-0">
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
                    {{ __('profile_info_success') }}
                </p>
            </div>
        </div>
    @endif

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <input type="hidden" name="form_type" value="profile_information">

        <div class="{{ $align }}">
            <x-input-label for="name" :value="__('profile_name_label')" class="text-gray-300" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-2 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="{{ $align }}">
            <x-input-label for="email" :value="__('profile_email_label')" class="text-gray-300" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-2 block w-full rounded-2xl border-gray-800 bg-gray-950/80 text-white placeholder:text-gray-500 focus:border-blue-500 focus:ring-blue-500"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
                dir="ltr"
            />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 rounded-2xl border border-amber-500/15 bg-amber-500/5 p-4">
                    <p class="text-sm leading-6 text-gray-400 {{ $align }}">
                        {{ __('email_not_verified') }}

                        <button
                            form="send-verification"
                            class="ms-1 font-medium text-blue-400 underline decoration-blue-400/60 underline-offset-4 transition hover:text-blue-300"
                        >
                            {{ __('resend_verification_link') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-4 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-sm text-emerald-300 {{ $align }}">
                            {{ __('verification_link_sent') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-sky-500 px-5 py-3 text-sm font-bold !text-white shadow-xl shadow-blue-600/25 transition duration-300 hover:-translate-y-0.5 hover:scale-[1.01] hover:from-blue-500 hover:via-sky-500 hover:to-cyan-400 hover:shadow-blue-500/40 focus:ring-2 focus:ring-blue-400/60">
                {{ __('profile_info_save_button') }}
            _button') }}
            </x-primary-button>
        </div>
    </form>
@extends('admin.layout.app')

@section('content')

<div class="max-w-3xl mx-auto space-y-6">

    {{-- هدر --}}
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl border border-violet-800/60 bg-violet-900/20 text-violet-300 shadow-lg shadow-violet-950/30">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M16.5 7.5h2.25A2.25 2.25 0 0 1 21 9.75v8.25A2.25 2.25 0 0 1 18.75 20.25H5.25A2.25 2.25 0 0 1 3 18V9.75A2.25 2.25 0 0 1 5.25 7.5H7.5m9 0V6A3 3 0 0 0 13.5 3h-3A3 3 0 0 0 7.5 6v1.5m9 0h-9m4.5 4.5v4.5m-2.25-2.25h4.5"/>
                </svg>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-white leading-tight">
                    صدور اشتراک برای {{ $user->name }}
                </h2>
                <p class="text-sm text-gray-400 mt-1">
                    پلن و بازه زمانی موردنظر را انتخاب کنید تا اشتراک جدید برای این کاربر ایجاد شود.
                </p>
            </div>
        </div>

        <div class="self-start rounded-2xl border border-cyan-800 bg-cyan-900/20 px-4 py-2 text-xs text-cyan-300 break-all">
            کاربر: {{ $user->email }}
        </div>
    </div>

    {{-- ارور ها --}}
    @if($errors->any())
        <div class="rounded-2xl border border-rose-700/70 bg-rose-900/20 p-4 text-rose-300">
            <div class="flex items-start gap-3">
                <div class="mt-0.5 flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-rose-500/10 text-rose-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v3.75m0 3.75h.008v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h3 class="text-sm font-semibold text-rose-200">خطا در ثبت اطلاعات</h3>
                    <p class="mt-1 text-xs text-rose-300/80">
                        لطفاً موارد زیر را بررسی و اصلاح کنید:
                    </p>

                    <ul class="mt-3 space-y-1 text-xs leading-6 list-disc pr-4">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    {{-- فرم کارت --}}
    <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-lg">
        <div class="border-b border-gray-800 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl border border-emerald-800/50 bg-emerald-900/20 text-emerald-300">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-white">اطلاعات اشتراک جدید</h3>
                    <p class="mt-1 text-xs text-gray-500">
                        یکی از پلن‌های موجود را انتخاب کرده و مدت اشتراک را مشخص کنید.
                    </p>
                </div>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.new-licenses.store', $user->id) }}" method="POST" class="space-y-6">
                @csrf

                {{-- یک خلاصه از کاربر --}}
                <div class="rounded-2xl border border-gray-800 bg-black/20 p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl border border-gray-800 bg-gray-800/70 text-gray-300">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                      d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400 mt-1 font-mono break-all">{{ $user->email }}</div>
                            <div class="text-xs text-amber-400 mt-2">این کاربر در حال حاضر اشتراک فعال ندارد.</div>
                        </div>
                    </div>
                </div>

                {{-- پلن --}}
                <div class="space-y-2">
                    <label for="plan_id" class="flex items-center gap-2 text-sm font-medium text-gray-300">
                        <svg class="h-4 w-4 text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h10.5"/>
                        </svg>
                        انتخاب پلن
                    </label>

                    <select
                        name="plan_id"
                        id="plan_id"
                        required
                        class="w-full rounded-2xl border border-gray-800 bg-black/40 px-4 py-3 text-sm text-gray-200 transition focus:border-violet-700 focus:outline-none focus:ring-violet-700"
                    >
                        <option value="" class="bg-gray-900 text-gray-400">انتخاب پلن...</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" class="bg-gray-900 text-gray-200">
                                {{ $plan->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- بازه زمانی --}}
                <div class="space-y-2">
                    <label for="duration_months" class="flex items-center gap-2 text-sm font-medium text-gray-300">
                        <svg class="h-4 w-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 4.5h13.5A1.5 1.5 0 0 1 20.25 6v12.75a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6a1.5 1.5 0 0 1 1.5-1.5Z"/>
                        </svg>
                        مدت اشتراک
                    </label>

                    <select
                        name="duration_months"
                        id="duration_months"
                        required
                        class="w-full rounded-2xl border border-gray-800 bg-black/40 px-4 py-3 text-sm text-gray-200 transition focus:border-violet-700 focus:outline-none focus:ring-violet-700"
                    >
                        <option value="" class="bg-gray-900 text-gray-400">انتخاب مدت...</option>
                        <option value="1" class="bg-gray-900 text-gray-200">۱ ماه</option>
                        <option value="3" class="bg-gray-900 text-gray-200">۳ ماه</option>
                        <option value="6" class="bg-gray-900 text-gray-200">۶ ماه</option>
                        <option value="12" class="bg-gray-900 text-gray-200">۱۲ ماه</option>
                    </select>
                </div>

                
                <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center">
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 w-full sm:w-auto rounded-2xl border border-emerald-800 bg-emerald-900/20 px-6 py-3 text-sm font-medium text-emerald-300 transition duration-200 hover:bg-emerald-800/40 hover:text-white"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M4.5 12.75 10.5 18l9-12"/>
                        </svg>
                        ایجاد اشتراک
                    </button>

                    <a href="{{ route('admin.licenses.create') }}"
                       class="inline-flex items-center justify-center gap-2 w-full sm:w-auto rounded-2xl border border-gray-800 bg-gray-800/40 px-5 py-3 text-sm font-medium text-gray-300 transition duration-200 hover:bg-gray-700/50 hover:text-white">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        بازگشت
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

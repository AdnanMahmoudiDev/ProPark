<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-100">
                    مدیریت دستگاه‌ها
                </h2>
                <p class="mt-1 text-sm text-gray-400">
                    مشاهده و حذف دستگاه‌های متصل به لایسنس شما
                </p>
            </div>

            <a href="{{ route('subscription.details') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-medium text-gray-300 transition-colors duration-200 hover:bg-gray-800 hover:text-white">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15 19l-7-7 7-7" />
                </svg>
                بازگشت به جزئیات اشتراک
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-[#070913] py-8 text-gray-100 sm:py-10">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- پیام موفقیت امیز بودن  --}}
            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-4 py-4 text-emerald-300 shadow-sm">
                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 rounded-xl bg-emerald-500/15 p-2 text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-5 w-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold">
                                عملیات با موفقیت انجام شد
                            </p>
                            <p class="mt-1 text-sm text-emerald-200/90">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- کارت اصلی --}}
            <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/70 shadow-2xl shadow-black/20 backdrop-blur">
                {{-- هدر --}}
                <div class="border-b border-gray-800 bg-gradient-to-r from-[#111827] via-[#0f172a] to-[#111827] px-5 py-6 sm:px-7">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex items-start gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-violet-500/20 bg-violet-500/10 text-violet-300 shadow-lg shadow-violet-950/20">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-7 w-7"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.8"
                                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 13h16M5 5h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                </svg>
                            </div>

                            <div>
                                <h1 class="text-xl font-bold tracking-tight text-white sm:text-2xl">
                                    دستگاه‌های متصل
                                </h1>
                                <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-400">
                                    در این بخش می‌توانید دستگاه‌های متصل به لایسنس خود را مشاهده کرده و در صورت نیاز آن‌ها را حذف کنید.
                                </p>
                            </div>
                        </div>

                        <div class="inline-flex items-center gap-2 self-start rounded-full border border-gray-800 bg-black/20 px-4 py-2 text-xs font-semibold text-gray-300">
                            <span class="inline-block h-2 w-2 rounded-full bg-violet-400"></span>
                            {{ $devices->count() }} دستگاه ثبت‌شده
                        </div>
                    </div>
                </div>

                {{-- بادی --}}
                <div class="p-5 sm:p-7">
                    @if($devices->isEmpty())
                        
                        <div class="rounded-3xl border border-dashed border-gray-800 bg-[#0b1120] px-6 py-14 text-center">
                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl border border-gray-800 bg-gray-900/80 text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-10 w-10"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="1.7"
                                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>

                            <h3 class="mt-6 text-lg font-bold text-white">
                                دستگاهی ثبت نشده است
                            </h3>

                            <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-gray-400">
                                در حال حاضر هیچ دستگاه فعالی برای این حساب شناسایی نشده است. پس از فعال‌سازی لایسنس روی دستگاه‌های مختلف، اطلاعات آن‌ها در این بخش نمایش داده می‌شود.
                            </p>

                            <div class="mt-8">
                                <a href="{{ route('subscription.details') }}"
                                   class="inline-flex items-center gap-2 rounded-2xl border border-violet-800/70 bg-violet-900/20 px-5 py-3 text-sm font-semibold text-violet-300 transition duration-200 hover:border-violet-700 hover:bg-violet-800/30 hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M15 19l-7-7 7-7" />
                                    </svg>
                                    بازگشت به جزئیات اشتراک
                                </a>
                            </div>
                        </div>
                    @else
                        {{-- مخصوص موبایل --}}
                        <div class="space-y-4 md:hidden">
                            @foreach($devices as $index => $device)
                                <div class="rounded-2xl border border-gray-800 bg-[#0b1120] p-4 shadow-sm">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-11 w-11 items-center justify-center rounded-xl border border-gray-800 bg-gray-900 text-violet-300">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-5 w-5"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="1.8"
                                                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 13h16M5 5h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                                </svg>
                                            </div>

                                            <div>
                                                <h3 class="text-sm font-bold text-white">
                                                    کامپیوتر {{ $device->seat_number ?? '—' }}
                                                </h3>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    ردیف {{ $index + 1 }} • ID: {{ $device->id }}
                                                </p>
                                            </div>
                                        </div>

                                        <span class="rounded-full border border-violet-500/20 bg-violet-500/10 px-2.5 py-1 text-[10px] font-semibold text-violet-300">
                                            دستگاه
                                        </span>
                                    </div>

                                    <div class="mt-4 space-y-3">
                                        <div class="rounded-xl bg-gray-900/70 p-3">
                                            <p class="text-[11px] font-bold tracking-wide text-gray-500">
                                                شناسه سخت‌افزاری
                                            </p>
                                            <p class="mt-2 break-all font-mono text-xs leading-6 text-violet-300">
                                                {{ $device->machine_fingerprint ?? 'نامشخص' }}
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-1 gap-3">
                                            <div class="rounded-xl border border-gray-800 bg-gray-900/40 p-3">
                                                <p class="text-[11px] font-bold text-gray-500">
                                                    زمان فعال‌سازی
                                                </p>
                                                <p class="mt-2 text-sm text-gray-200">
                                                    {{ $device->activated_at ? jdate($device->activated_at)->format('Y/m/d H:i') : '—' }}
                                                </p>
                                            </div>

                                            <div class="rounded-xl border border-gray-800 bg-gray-900/40 p-3">
                                                <p class="text-[11px] font-bold text-gray-500">
                                                    تاریخ ثبت
                                                </p>
                                                <p class="mt-2 text-sm text-gray-200">
                                                    {{ $device->created_at ? jdate($device->created_at)->format('Y/m/d H:i') : '—' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 border-t border-gray-800 pt-4">
                                        <form action="{{ route('user.devices.destroy', $device) }}"
                                              method="POST"
                                              onsubmit="return confirm('آیا از حذف این دستگاه مطمئن هستید؟');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-red-900/60 bg-red-950/30 px-4 py-3 text-sm font-semibold text-red-300 transition duration-200 hover:border-red-700 hover:bg-red-900/30 hover:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0h8m-1-2a1 1 0 00-1-1h-2a1 1 0 00-1 1l-.2 1h4.4L15 5z" />
                                                </svg>
                                                حذف دستگاه
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- مخصوص دسکتاپ --}}
                        <div class="hidden overflow-hidden rounded-2xl border border-gray-800 bg-[#0b1120] md:block">
                            <div class="overflow-x-auto">
                                <table class="w-full table-fixed divide-y divide-gray-800">
                                    <thead class="bg-[#0f172a]">
                                        <tr>
                                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                                #
                                            </th>
                                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                                شماره کامپیوتر
                                            </th>
                                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                                شناسه سخت‌افزاری (Fingerprint)
                                            </th>
                                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                                زمان فعال‌سازی
                                            </th>
                                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                                تاریخ ثبت
                                            </th>
                                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-[0.18em] text-gray-500">
                                                عملیات
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="divide-y divide-gray-800">
                                        @foreach($devices as $index => $device)
                                            <tr class="transition-colors duration-200 hover:bg-white/[0.02]">
                                                <td class="px-4 py-5 text-sm font-semibold text-gray-300">
                                                    {{ $index + 1 }}
                                                </td>

                                                <td class="px-4 py-5">
                                                    <div class="flex items-center gap-3">
                                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-gray-800 bg-gray-900 text-violet-300">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-5 w-5"
                                                                 fill="none"
                                                                 viewBox="0 0 24 24"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      stroke-width="1.8"
                                                                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M4 13h16M5 5h14a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                                            </svg>
                                                        </div>

                                                        <div>
                                                            <p class="text-sm font-semibold text-white">
                                                                کامپیوتر {{ $device->seat_number ?? '—' }}
                                                            </p>
                                                            <p class="mt-1 text-xs text-gray-500">
                                                                ID: {{ $device->id }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-4 py-5">
                                                    <code class="inline-block max-w-[320px] truncate rounded-lg bg-gray-900 px-3 py-2 font-mono text-xs text-violet-300 ring-1 ring-white/5"
                                                          title="{{ $device->machine_fingerprint }}">
                                                        {{ $device->machine_fingerprint ?? 'نامشخص' }}
                                                    </code>
                                                </td>

                                                <td class="whitespace-nowrap px-4 py-5 text-sm text-gray-300">
                                                    {{ $device->activated_at ? jdate($device->activated_at)->format('Y/m/d H:i') : '—' }}
                                                </td>

                                                <td class="whitespace-nowrap px-4 py-5 text-sm text-gray-300">
                                                    {{ $device->created_at ? jdate($device->created_at)->format('Y/m/d H:i') : '—' }}
                                                </td>

                                                <td class="px-4 py-5">
                                                    <form action="{{ route('user.devices.destroy', $device) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('آیا از حذف این دستگاه مطمئن هستید؟');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                                class="inline-flex items-center gap-2 whitespace-nowrap rounded-xl border border-red-900/60 bg-red-950/30 px-4 py-2.5 text-sm font-semibold text-red-300 transition duration-200 hover:border-red-700 hover:bg-red-900/30 hover:text-white">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                 class="h-4 w-4"
                                                                 fill="none"
                                                                 viewBox="0 0 24 24"
                                                                 stroke="currentColor">
                                                                <path stroke-linecap="round"
                                                                      stroke-linejoin="round"
                                                                      stroke-width="2"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0h8m-1-2a1 1 0 00-1-1h-2a1 1 0 00-1 1l-.2 1h4.4L15 5z" />
                                                            </svg>
                                                            حذف دستگاه
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                        <div class="mt-6 rounded-2xl border border-amber-500/10 bg-amber-500/5 p-5">
                            <div class="flex items-start gap-3">
                                <div class="rounded-xl bg-amber-500/10 p-2 text-amber-400">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M13 16h-1v-4h-1m1-4h.01M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-sm font-bold text-amber-300">
                                        توجه مهم
                                    </p>
                                    <p class="mt-1 text-sm leading-6 text-gray-400">
                                        با حذف یک دستگاه، دسترسی آن سیستم به لایسنس شما لغو می‌شود. در صورت نیاز به استفاده مجدد، باید مجدداً لایسنس را بر روی آن سیستم فعال‌سازی کنید.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- باکس نکنه مهم --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    اگر دستگاهی را نمی‌شناسید یا مشکوک به استفاده غیرمجاز هستید، آن را حذف کنید و در صورت نیاز با
                    <a href="#" class="text-violet-400 transition-colors hover:text-violet-300 hover:underline">
                        پشتیبانی
                    </a>
                    تماس بگیرید.
                </p>
            </div>
        </div>
    </div>
</x-app-layout>

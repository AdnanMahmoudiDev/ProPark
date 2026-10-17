@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- هدر صفحه با هاله نوری و استایل یکپارچه --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-gray-900 via-gray-900/90 to-gray-950 p-6 md:p-8 border border-gray-800/80 shadow-2xl backdrop-blur-xl">
        {{-- هاله‌های نور پس‌زمینه نئونی --}}
        <div class="absolute -top-16 -left-16 w-56 h-56 bg-blue-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-indigo-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/3 -translate-y-1/2 w-48 h-48 bg-purple-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-2xl text-blue-400 border border-blue-500/30 shadow-inner">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M16.5 7.5h2.25A2.25 2.25 0 0 1 21 9.75v8.25A2.25 2.25 0 0 1 18.75 20.25H5.25A2.25 2.25 0 0 1 3 18V9.75A2.25 2.25 0 0 1 5.25 7.5H7.5m9 0V6A3 3 0 0 0 13.5 3h-3A3 3 0 0 0 7.5 6v1.5m9 0h-9m4.5 4.5v4.5m-2.25-2.25h4.5"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-white tracking-tight">
                        کاربران بدون اشتراک فعال
                    </h1>
                    <p class="text-xs md:text-sm text-gray-400 mt-1">
                        برای کاربرانی که هنوز پلن فعال ندارند، اشتراک جدید صادر کنید.
                    </p>
                </div>
            </div>

            
        </div>
    </div>

    {{-- موفقیت بودن --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-400 text-sm backdrop-blur-md">
            <div class="mt-0.5 flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <div class="leading-7 font-medium">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if($users->isEmpty())
        <div class="rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md p-10 text-center shadow-lg">
            <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-3xl border border-gray-800 bg-gray-800/70 text-gray-400">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>

            <h3 class="text-base font-bold text-white">
                همه کاربران دارای اشتراک هستند
            </h3>
            <p class="mt-2 text-sm text-gray-500 leading-7">
                در حال حاضر هیچ کاربری برای صدور اشتراک جدید در این بخش وجود ندارد.
            </p>
        </div>
    @else
        <div class="overflow-hidden rounded-3xl border border-gray-800 bg-gray-900/60 backdrop-blur-md shadow-lg">
            <div class="border-b border-gray-800 bg-gradient-to-r from-gray-900 via-gray-950 to-gray-900 px-6 py-4">
                <div class="flex items-center gap-3">
                    <div>
                        <h3 class="text-sm font-semibold text-white">
                            لیست کاربران قابل صدور اشتراک
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            از این جدول می‌توانید مستقیماً فرآیند ایجاد اشتراک را برای هر کاربر آغاز کنید.
                        </p>
                    </div>
                </div>
            </div>

            {{-- مخصوص دسکتاپ --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead class="bg-gray-950/60">
                        <tr class="border-b border-gray-800">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400">شناسه</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400">کاربر</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400">ایمیل</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-400">عملیات</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-800/60">
                        @foreach($users as $user)
                            <tr class="transition duration-150 hover:bg-gray-800/40">
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-lg bg-gray-800/80 px-2.5 py-1 text-xs font-mono text-gray-300 border border-gray-700/60">
                                        #{{ $user->id }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-2xl border border-gray-800 bg-gray-800/70 text-gray-300">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                      d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">کاربر بدون اشتراک فعال</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm font-mono text-gray-400 break-all">
                                    {{ $user->email }}
                                </td>

                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.new-licenses.create', $user->id) }}"
                                       class="inline-flex items-center gap-2 rounded-xl border border-blue-500/30 bg-blue-600/20 px-4 py-2.5 text-xs font-medium text-blue-300 transition duration-200 hover:bg-blue-600 hover:text-white shadow-lg shadow-blue-600/10">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                  d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        ایجاد اشتراک
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- مخصوص موبایل --}}
            <div class="block md:hidden divide-y divide-gray-800/60">
                @foreach($users as $user)
                    <div class="p-5 space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="inline-flex rounded-lg bg-gray-800/80 px-2.5 py-1 text-xs font-mono text-gray-300 border border-gray-700/60">
                                #{{ $user->id }}
                            </span>
                            <span class="text-xs text-gray-500">کاربر بدون اشتراک فعال</span>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl border border-gray-800 bg-gray-800/70 text-gray-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-medium text-white truncate">{{ $user->name }}</div>
                                <div class="text-xs text-gray-400 font-mono mt-0.5 break-all">{{ $user->email }}</div>
                            </div>
                        </div>

                        <div>
                            <a href="{{ route('admin.new-licenses.create', $user->id) }}"
                               class="flex items-center justify-center gap-2 w-full rounded-xl border border-blue-500/30 bg-blue-600/20 py-3 text-xs font-medium text-blue-300 transition duration-200 hover:bg-blue-600 hover:text-white shadow-lg shadow-blue-600/10">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                                ایجاد اشتراک
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection

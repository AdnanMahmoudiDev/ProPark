@extends('admin.layout.app')

@section('content')
<div class="space-y-6">

    {{-- هدر صفحه --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-800 pb-5">
        <div>
            <h1 class="text-xl font-bold text-white flex items-center gap-2">
                <div class="p-2 bg-blue-500/10 rounded-xl text-blue-400 border border-blue-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                </div>
                مرکز داده و مدیریت پشتیبان‌گیری
            </h1>
            <p class="text-xs text-gray-400 mt-1">مانیتورینگ وضعیت جداول، داده‌های آماری و عملیات تخلیه و بارگذاری داده‌ها</p>
        </div>

        <div class="flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                وضعیت اتصال: متصل
            </span>
            <span class="px-3 py-1.5 rounded-full text-xs font-mono font-medium bg-gray-800 text-gray-300 border border-gray-700">
                {{ $stats['mysql_version'] }}
            </span>
        </div>
    </div>

    {{-- پیام‌های وضعیت --}}
    @if (session('success'))
        <div class="p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-emerald-400 flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="p-4 bg-rose-500/10 border border-rose-500/30 rounded-xl text-rose-400 flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ردیف اول: آمار بیزینسی نرم‌افزار --}}
    <div>
        <h2 class="text-sm font-semibold text-gray-400 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            شاخص‌های کلیدی سیستم
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
            
            {{-- کارت کاربران --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-blue-500/40 transition">
                <div class="flex items-center justify-between">
                    <div class="text-xs font-medium text-gray-400">کل کاربران ثبت‌نامی</div>
                    <div class="p-2 bg-blue-500/10 rounded-lg text-blue-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-bold text-white font-mono">{{ number_format($stats['business']['users']) }}</div>
                <div class="mt-1 text-[11px] text-gray-500">حساب‌های کاربری فعال در پایگاه داده</div>
            </div>

            {{-- کارت اشتراک‌ها --}}
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-5 shadow-lg relative overflow-hidden group hover:border-indigo-500/40 transition">
                <div class="flex items-center justify-between">
                    <div class="text-xs font-medium text-gray-400">اشتراک‌ها / پلن‌ها</div>
                    <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-3 text-2xl font-bold text-indigo-400 font-mono">{{ number_format($stats['business']['subscriptions']) }}</div>
                <div class="mt-1 text-[11px] text-gray-500">سوابق اشتراک ثبت شده</div>
            </div>

        </div>
    </div>

    {{-- ردیف دوم: متادیتای دیتابیس --}}
    <div>
        <h2 class="text-sm font-semibold text-gray-400 mb-3 flex items-center gap-2">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4" />
            </svg>
            مشخصات فنی پایگاه داده
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-5 shadow-lg">
                <div class="text-xs font-medium text-gray-400">نام دیتابیس فعال</div>
                <div class="mt-2 text-xl font-bold text-white tracking-wide font-mono">{{ $stats['database'] }}</div>
            </div>
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-5 shadow-lg">
                <div class="text-xs font-medium text-gray-400">تعداد جداول</div>
                <div class="mt-2 text-xl font-bold text-blue-400 font-mono">{{ number_format($stats['tables_count']) }}</div>
            </div>
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-5 shadow-lg">
                <div class="text-xs font-medium text-gray-400">کل رکوردهای داده</div>
                <div class="mt-2 text-xl font-bold text-indigo-400 font-mono">{{ number_format($stats['total_rows']) }}</div>
            </div>
            <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-5 shadow-lg">
                <div class="text-xs font-medium text-gray-400">حجم کلی دیتابیس</div>
                <div class="mt-2 text-xl font-bold text-emerald-400 font-mono">{{ $stats['size_mb'] }} <span class="text-xs font-normal text-gray-400">مگابایت</span></div>
            </div>
        </div>
    </div>

    {{-- پنل عملیات دانلود و بازگردانی --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- بخش خروجی و دانلود --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 text-lg font-semibold text-white mb-2">
                    <div class="p-2 bg-blue-500/10 rounded-xl text-blue-400 border border-blue-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <h3>پشتیبان‌گیری کامل (Export SQL)</h3>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed mb-6">
                    با کلیک روی دکمه زیر، یک نسخه کامل و استاندارد از تمامی جداول، کلیدهای خارجی و سطرها در قالب یک فایل <code class="text-blue-400 bg-gray-950 px-1.5 py-0.5 rounded border border-gray-800">.sql</code> تولید شده و دانلود می‌شود.
                </p>
            </div>

            <a href="{{ route('admin.database.export') }}" 
               class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-medium transition shadow-lg shadow-blue-600/20 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span>دانلود فایل پشتیبان SQL</span>
            </a>
        </div>

        {{-- بخش بازگردانی و آپلود --}}
        <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl p-6 shadow-lg flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 text-lg font-semibold text-white mb-2">
                    <div class="p-2 bg-amber-500/10 rounded-xl text-amber-400 border border-amber-500/20">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12" />
                        </svg>
                    </div>
                    <h3>بازیابی و ریستور دیتابیس (Restore)</h3>
                </div>
                <p class="text-rose-400/90 text-sm leading-relaxed mb-4 bg-rose-500/10 p-3.5 rounded-xl border border-rose-500/20">
                    <strong>هشدار بحرانی:</strong> اجرای فایل بک‌آپ ساختار و داده‌های قبلی را رونویسی خواهد کرد. پیش از عملیات مطمئن شوید یک فایل پشتیبان ذخیره کرده‌اید.
                </p>
            </div>

            <form action="{{ route('admin.database.import') }}" method="POST" enctype="multipart/form-data" id="restore-form" class="space-y-4">
                @csrf
                <div>
                    <input type="file" name="backup_file" id="backup_file" accept=".sql,.txt" required
                           class="block w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-gray-800 file:text-gray-200 hover:file:bg-gray-700 cursor-pointer border border-gray-800 rounded-xl bg-gray-950 focus:outline-none" />
                </div>

                <button type="button" onclick="confirmRestore()"
                        class="inline-flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl bg-amber-600 hover:bg-amber-500 text-white font-medium transition shadow-lg shadow-amber-600/20 active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l4-4m0 0l4 4m-4-4v12" />
                    </svg>
                    <span>اجرای عملیات بازگردانی</span>
                </button>
            </form>
        </div>
    </div>

    {{-- لیست و جزئیات جدول‌ها --}}
    <div class="bg-gray-900/60 backdrop-blur border border-gray-800 rounded-2xl shadow-lg overflow-hidden">
        <div class="p-5 border-b border-gray-800 flex items-center justify-between">
            <h3 class="font-semibold text-white text-base flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                </svg>
                وضعیت و متادیتای جداول
            </h3>
            <span class="text-xs text-gray-400 font-mono">تعداد جداول: {{ count($stats['tables']) }}</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right text-sm text-gray-300">
                <thead class="bg-gray-950/60 text-gray-400 text-xs uppercase font-medium">
                    <tr>
                        <th class="px-6 py-3.5">نام جدول</th>
                        <th class="px-6 py-3.5">Engine</th>
                        <th class="px-6 py-3.5">تعداد سطرها</th>
                        <th class="px-6 py-3.5">حجم داده (KB)</th>
                        <th class="px-6 py-3.5">حجم ایندکس (KB)</th>
                        <th class="px-6 py-3.5">Collation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800/60">
                    @foreach ($stats['tables'] as $tbl)
                        <tr class="hover:bg-gray-800/40 transition-colors">
                            <td class="px-6 py-3.5 font-mono text-white font-medium">{{ $tbl->Name }}</td>
                            <td class="px-6 py-3.5 font-mono text-gray-400">{{ $tbl->Engine }}</td>
                            <td class="px-6 py-3.5 font-mono text-blue-400">{{ number_format($tbl->Rows) }}</td>
                            <td class="px-6 py-3.5 font-mono text-gray-400">{{ round($tbl->Data_length / 1024, 2) }}</td>
                            <td class="px-6 py-3.5 font-mono text-gray-400">{{ round($tbl->Index_length / 1024, 2) }}</td>
                            <td class="px-6 py-3.5 font-mono text-xs text-gray-500">{{ $tbl->Collation }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    function confirmRestore() {
        const fileInput = document.getElementById('backup_file');
        if (!fileInput.value) {
            alert('لطفاً ابتدا یک فایل .sql انتخاب کنید.');
            return;
        }

        if (confirm('آیا از بازگردانی دیتابیس اطمینان کامل دارید؟\nتمام داده‌های فعلی رونویسی خواهند شد!')) {
            document.getElementById('restore-form').submit();
        }
    }
</script>
@endsection

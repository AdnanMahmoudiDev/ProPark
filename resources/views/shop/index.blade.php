<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center">
            {{-- دکمه ی بازگشت --}}
            <div class="absolute right-0">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" 
                   class="flex items-center gap-1.5 px-2 py-2 bg-gray-800 border border-gray-700 text-white rounded-lg hover:bg-gray-700 hover:border-violet-500 transition-all text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="text-violet-400">بازگشت</span>
                </a>
            </div>

            {{-- عنوان صفحه که فروشگاه است --}}
            <div class="w-full text-center">
                <h2 class="font-bold text-xl text-white leading-tight">
                    فروشگاه ProPark
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">

             {{-- بخش مقدمه  --}}
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-white">
                    انتخاب پلان مناسب
                </h1>
                <p class="text-gray-400 mt-3 text-lg">
                    با انتخاب یکی از پلن‌ها، امکانات بیشتری در ProPark دریافت کنید
                </p>
            </div>

            {{-- پکیچ ها --}}
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-5xl mx-auto">

                    {{-- eco --}}
                    <div class="bg-gray-900 border border-gray-500 rounded-2xl p-8 text-center hover:border-gray-700 transition-colors flex flex-col h-full min-h-[420px]">
                        <h3 class="text-xl font-semibold text-gray-400">پلن اکو</h3>
                        <p class="text-3xl font-bold text-white mt-6">50,000 <span class="text-sm text-gray-400">تومان</span></p>
                        <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> 10 رزرو پارکینگ</li>
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی معمولی</li>
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 30 روزه</li>
                        </ul>
                        <a href="#"
                            class="mt-auto w-full block bg-gray-500 hover:bg-gray-400 text-gray py-2 rounded-lg font-bold transition-all text-center shadow-md shadow-gray-500/20">
                             انتخاب پلن
                        </a>

                    </div>

                    {{-- pro --}}
                    <div class="bg-gray-900 border border-violet-500 rounded-2xl p-8 text-center hover:border-violet-800 transition-colors flex flex-col h-full min-h-[420px]">
                        <h3 class="text-xl font-semibold text-violet-400">پلن پرو</h3>
                        <div class="flex justify-center my-2">
                            <span class="bg-purple-600 text-black text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                             محبوب
                            </span>
                        </div>
                        <p class="text-3xl font-bold text-white mt-2">150,000 <span class="text-sm text-gray-400">تومان</span></p>

                        <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> 100 رزرو پارکینگ</li>
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی VIP</li>
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 90 روزه</li>
                        </ul>

                        <a href="#"
                            class="mt-auto w-full block bg-purple-600 hover:bg-purple-500 text-white py-2 rounded-lg font-bold transition-all text-center shadow-md shadow-violet-500/20">
                             انتخاب پلن
                        </a>

                    </div>

                    {{-- sazmani --}}
                    <div class="bg-gray-900 border border-blue-500 rounded-2xl p-8 text-center hover:border-blue-800 transition-colors flex flex-col h-full min-h-[420px]">
                        <h3 class="text-xl font-semibold text-blue-300">پلن سازمانی</h3>
                        <p class="text-3xl font-bold text-white mt-6">220,000 <span class="text-sm text-gray-400">تومان</span></p>
                        <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> 30 رزرو پارکینگ</li>
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی vip سریع</li>
                            <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 60 روزه</li>
                        </ul>
                        <a href="#"
                            class="mt-auto w-full block bg-blue-600 hover:bg-blue-500 text-white py-2 rounded-lg font-bold transition-all text-center shadow-md shadow-blue-500/20">
                             انتخاب پلن
                        </a>

                    </div>

                </div>

        </div>
    </div>
</x-app-layout>

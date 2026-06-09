<x-app-layout>
    <x-slot name="header">
        <div class="relative flex items-center">
            {{-- دکمه ی بازگشت --}}
            <div class="absolute right-0">
                <a href="{{ route("home") }}" 
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
                    انتخاب پکیج مناسب
                </h1>
                <p class="text-gray-400 mt-3 text-lg">
                    با انتخاب یکی از پلن‌ها، امکانات بیشتری در ProPark دریافت کنید
                </p>
            </div>

            {{-- پکیچ ها --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- bronze --}}
                <div class="bg-gray-900 border border-yellow-500 rounded-2xl p-6 text-center hover:border-yellow-500 transition-colors flex flex-col h-full">
                    <h3 class="text-xl font-semibold text-orange-400">پکیج برنزی</h3>
                    <p class="text-3xl font-bold text-white mt-4">50,000 <span class="text-sm text-gray-400">تومان</span></p>
                    <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> 10 رزرو پارکینگ</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی معمولی</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 30 روزه</li>
                    </ul>
                    <button class="mt-auto w-full bg-orange-500 hover:bg-orange-400 text-white py-2 rounded-lg font-bold transition-all shadow-md shadow-orange-500/20">خرید پکیج</button>
                </div>

                {{-- silver --}}
                <div class="bg-gray-900 border border-gray-500 rounded-2xl p-6 text-center hover:border-gray-400 transition-colors flex flex-col h-full">
                    <h3 class="text-xl font-semibold text-gray-300">پکیج نقره‌ای</h3>
                    <p class="text-3xl font-bold text-white mt-4">120,000 <span class="text-sm text-gray-400">تومان</span></p>
                    <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> 30 رزرو پارکینگ</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی سریع</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 60 روزه</li>
                    </ul>
                    <button class="mt-auto w-full bg-gray-500 hover:bg-gray-500 text-white py-2 rounded-lg font-bold transition-all">خرید پکیج</button>
                </div>

                {{-- gold --}}
                <div class="bg-gray-900 border border-yellow-500 rounded-2xl p-6 text-center hover:border-gray-400 transition-colors flex flex-col h-full">
                    <h3 class="text-xl  font-semibold text-yellow-400">پکیج طلایی</h3>
                    {{-- برچسب محبوب --}}
                    <div class="flex justify-center mb-2">
                        <span class="bg-yellow-500 text-black text-xs font-bold px-3 py-1 rounded-full whitespace-nowrap">
                         محبوب
                        </span>
                    </div>

                    <p class="text-3xl font-bold text-white mt-4">250,000 <span class="text-sm text-gray-400">تومان</span></p>

                    <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> 100 رزرو پارکینگ</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی VIP</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 90 روزه</li>
                    </ul>

                    <button class="mt-auto w-full bg-yellow-500 hover:bg-yellow-400 text-black py-2 rounded-lg font-bold transition-all">خرید پکیج</button>
                </div>

                {{-- pro --}}
                <div class="bg-gray-900 border border-purple-500 rounded-2xl p-6 text-center hover:border-purple-500 transition-colors flex flex-col h-full">
                    <h3 class="text-xl font-semibold text-purple-400">پکیج پرو</h3>
                    <p class="text-3xl font-bold text-white mt-4">500,000 <span class="text-sm text-gray-400">تومان</span></p>
                    <ul class="text-gray-400 mt-6 space-y-3 text-sm text-right px-4 flex-grow">
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> رزرو نامحدود</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> پشتیبانی ویژه</li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">.</span> اعتبار 6 ماهه</li>
                    </ul><br><br>
                    <button class="mt-auto w-full bg-purple-600 hover:bg-purple-600 text-white py-2 rounded-lg font-bold transition-all">خرید پکیج</button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

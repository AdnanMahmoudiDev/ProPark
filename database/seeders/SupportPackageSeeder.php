<?php

namespace Database\Seeders;

use App\Models\SupportPackage;
use Illuminate\Database\Seeder;

class SupportPackageSeeder extends Seeder
{
    public function run(): void
    {
        SupportPackage::updateOrCreate(
            ['duration_months' => 6],
            [
                'title' => 'پشتیبانی ۶ ماهه',
                'price' => 1500000,
                'sort_order' => 1,
                'is_active' => true,
                'features' => [
                    '۱۸۰ روز دسترسی به کلیه آپدیت‌ها',
                    'پاسخ‌گویی به تیکت‌ها و رفع اشکالات فنی',
                ],
            ]
        );

        SupportPackage::updateOrCreate(
            ['duration_months' => 12],
            [
                'title' => 'پشتیبانی ۱ ساله',
                'price' => 2600000,
                'sort_order' => 2,
                'is_active' => true,
                'features' => [
                    '۳۶۵ روز دسترسی نامحدود به آپدیت‌ها',
                    'اولویت در بررسی تیکت‌ها و پشتیبانی اختصاصی',
                ],
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('plans')->updateOrInsert(
            ['slug' => 'eco'],
            [
                'title' => 'اکو',
                'description' => 'پلن اقتصادی برای کاربران معمولی',
                'facilities' => json_encode([
                    'مناسب استفاده روزمره',
                    'دسترسی به امکانات پایه',
                    'پشتیبانی استاندارد',
                ]),
                'max_devices' => 2, // اضافه شد
                'sort_order' => 1,
                'is_active' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('plans')->updateOrInsert(
            ['slug' => 'pro'],
            [
                'title' => 'پرو',
                'description' => 'پلن حرفه‌ای با امکانات کامل',
                'facilities' => json_encode([
                    'تمام امکانات پلن اکو',
                    'امکانات حرفه‌ای‌تر',
                    'اولویت در پشتیبانی',
                ]),
                'max_devices' => 4,
                'sort_order' => 2,
                'is_active' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );

        DB::table('plans')->updateOrInsert(
            ['slug' => 'sazmani'],
            [
                'title' => 'سازمانی',
                'description' => 'مناسب شرکت‌ها و سازمان‌ها',
                'facilities' => json_encode([
                    'مناسب تیم‌ها و سازمان‌ها',
                    'مدیریت گسترده‌تر',
                    'پشتیبانی ویژه',
                ]),
                'max_devices' => 8,
                'sort_order' => 3,
                'is_active' => true,
                'updated_at' => now(),
                'created_at' => now(),
            ]
        );
    }
}

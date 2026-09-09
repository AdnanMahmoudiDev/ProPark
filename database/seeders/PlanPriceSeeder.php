<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PlanPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{

        $eco = DB::table('plans')->where('slug','eco')->first()->id;
        $pro = DB::table('plans')->where('slug','pro')->first()->id;
        $sazmani = DB::table('plans')->where('slug','sazmani')->first()->id;

        DB::table('plan_prices')->insert([

            // اکو
            [
                'plan_id' => $eco,
                'duration_months' => 1,
                'price' => 100000,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $eco,
                'duration_months' => 3,
                'price' => 270000,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $eco,
                'duration_months' => 6,
                'price' => 500000,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $eco,
                'duration_months' => 12,
                'price' => 900000,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // پرو
            [
                'plan_id' => $pro,
                'duration_months' => 1,
                'price' => 250000,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $pro,
                'duration_months' => 3,
                'price' => 700000,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $pro,
                'duration_months' => 6,
                'price' => 1300000,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $pro,
                'duration_months' => 12,
                'price' => 2400000,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // سازمانی
            [
                'plan_id' => $sazmani,
                'duration_months' => 1,
                'price' => 500000,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $sazmani,
                'duration_months' => 3,
                'price' => 1350000,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $sazmani,
                'duration_months' => 6,
                'price' => 2500000,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plan_id' => $sazmani,
                'duration_months' => 12,
                'price' => 4500000,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);

    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('support_packages', function (Blueprint $table) {
            // قیمت اصلی محصول (قبل از تخفیف)
            $table->unsignedBigInteger('original_price')
                  ->nullable()
                  ->after('price');

            // درصد تخفیف (۰ تا ۱۰۰)
            $table->unsignedTinyInteger('discount_percent')
                  ->default(0)
                  ->after('original_price');
        });

        // مقداردهی اولیه: قیمت فعلی هر ردیف به عنوان قیمت اصلی در نظر گرفته شود
        DB::table('support_packages')->whereNull('original_price')->update([
            'original_price' => DB::raw('`price`'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('support_packages', function (Blueprint $table) {
            $table->dropColumn(['original_price', 'discount_percent']);
        });
    }
};

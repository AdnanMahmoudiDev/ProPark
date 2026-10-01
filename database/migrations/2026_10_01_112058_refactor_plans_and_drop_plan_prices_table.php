<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ۱. حذف کلید خارجی و ستون plan_price_id از جدول subscriptions (در صورت وجود)
        if (Schema::hasColumn('subscriptions', 'plan_price_id')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                // نام پیش‌فرض کلید خارجی در لاراول
                $table->dropForeign(['plan_price_id']);
                $table->dropColumn('plan_price_id');
            });
        }

        // ۲. حذف کلید خارجی و ستون plan_price_id از جدول carts (در صورت وجود)
        if (Schema::hasTable('carts') && Schema::hasColumn('carts', 'plan_price_id')) {
            Schema::table('carts', function (Blueprint $table) {
                $table->dropForeign(['plan_price_id']);
                $table->dropColumn('plan_price_id');
            });
        }

        // ۳. افزودن فیلدهای قیمت به جدول plans
        Schema::table('plans', function (Blueprint $table) {
            $table->unsignedBigInteger('price')->default(0)->after('facilities');
            $table->unsignedTinyInteger('discount_percent')->default(0)->after('price');
            $table->unsignedBigInteger('original_price')->default(0)->after('discount_percent');
        });

        // ۴. حذف کامل جدول plan_prices
        Schema::dropIfExists('plan_prices');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // بازسازی جدول plan_prices در صورت نیاز به Rollback
        Schema::create('plan_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('plan_id')->constrained('plans')->cascadeOnDelete();
            $table->unsignedSmallInteger('duration_months')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedTinyInteger('discount_percent')->default(0);
            $table->unsignedBigInteger('original_price')->default(0);
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // حذف ستون‌های اضافه‌شده از plans
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['price', 'discount_percent', 'original_price']);
        });

        // بازگرداندن ستون plan_price_id به subscriptions
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('plan_price_id')->nullable()->after('plan_id')->constrained('plan_prices')->nullOnDelete();
        });
    }
};

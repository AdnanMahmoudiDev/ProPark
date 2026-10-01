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
        Schema::table('carts', function (Blueprint $table) {
            // 1. تغییر فیلد plan_id به نال‌پذیر
            // نکته: برای استفاده از change() باید پکیج doctrine/dbal نصب باشد (در لاراول 10+ نیازی نیست)
            $table->unsignedBigInteger('plan_id')->nullable()->change();

            // 2. اضافه کردن فیلد پکیج پشتیبانی
            // این فیلد را بعد از plan_id اضافه می‌کنیم که ساختار مرتب بماند
            $table->unsignedBigInteger('support_package_id')->nullable()->after('plan_id');
            
            // اگر می‌خواهی رابطه دیتابیسی (Foreign Key) هم داشته باشد، این خط را از کامنت خارج کن:
            // $table->foreign('support_package_id')->references('id')->on('support_packages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // برگشت به حالت قبل (اجباری کردن دوباره plan_id)
            $table->unsignedBigInteger('plan_id')->nullable(false)->change();

            // حذف ستون اضافه شده
            $table->dropColumn('support_package_id');
        });
    }
};

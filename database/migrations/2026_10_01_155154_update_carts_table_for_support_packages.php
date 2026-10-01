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
            // ۱. نال‌پذیر کردن plan_id جهت جلوگیری از خطای 1364 MySQL
            $table->unsignedBigInteger('plan_id')->nullable()->change();

            // ۲. افزودن ستون جدید برای ذخیره آیدی پکیج پشتیبانی
            if (!Schema::hasColumn('carts', 'support_package_id')) {
                $table->unsignedBigInteger('support_package_id')->nullable()->after('plan_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->nullable(false)->change();
            
            if (Schema::hasColumn('carts', 'support_package_id')) {
                $table->dropColumn('support_package_id');
            }
        });
    }
};

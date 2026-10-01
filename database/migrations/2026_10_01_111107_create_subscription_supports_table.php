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
        Schema::create('subscription_supports', function (Blueprint $table) {
            $table->id();

            // ارتباط با جدول subscriptions
            $table->foreignId('subscription_id')
                ->constrained('subscriptions')
                ->cascadeOnDelete();

            // بازه زمانی معتبر بودن دوره پشتیبانی
            $table->dateTime('starts_at');
            $table->dateTime('expires_at');

            // وضعیت پشتیبانی: active, expired, disabled
            $table->string('status', 20)->default('active');

            $table->timestamps();

            // ایندکس‌ها برای بهینه‌سازی کوئری‌های بررسی اعتبار پشتیبانی
            $table->index(['subscription_id', 'status']);
            $table->index(['expires_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_supports');
    }
};

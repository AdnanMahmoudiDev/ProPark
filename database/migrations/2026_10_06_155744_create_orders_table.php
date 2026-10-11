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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('order_number')->unique();
            
            // مبالغ مالی بر حسب واحد انتخابی
            $table->unsignedBigInteger('subtotal_amount')->default(0); // جمع کل قبل تخفیف
            $table->unsignedBigInteger('discount_amount')->default(0); // مجموع تخفیف
            $table->unsignedBigInteger('payable_amount')->default(0);  // مبلغ نهایی قابل پرداخت
            $table->string('currency', 10)->default('IRT');           // مثلا IRT (تومان) یا IRR (ریال)
            
            // وضعیت‌های سفارش: pending, paid, failed, canceled
            $table->string('status')->default('pending')->index();
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

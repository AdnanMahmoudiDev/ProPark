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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            
            $table->string('gateway'); // zarinpal, zibal, saman, ...
            $table->unsignedBigInteger('amount');
            $table->string('currency', 10)->default('IRT');
            
            // وضعیت‌های تراکنش: pending, successful, failed
            $table->string('status')->default('pending')->index();
            
            $table->string('authority')->nullable()->index();     // شناسه درخواست اولیه درگاه
            $table->string('reference_id')->nullable()->index(); // کد پیگیری نهایی شاپرک/بانک
            $table->string('card_pan', 30)->nullable();          // شماره کارت ماسک‌شده
            
            $table->string('failure_code')->nullable();
            $table->text('failure_message')->nullable();
            
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

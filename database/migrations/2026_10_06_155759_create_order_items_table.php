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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            
            // رابطه چندریختی (Polymorphic) با Plan یا SupportPackage
            $table->nullableMorphs('purchasable'); 
            
            $table->string('title'); // عنوان محصول در لحظه خرید
            $table->unsignedBigInteger('unit_price')->default(0);       // قیمت پایه
            $table->unsignedBigInteger('discount_amount')->default(0);   // تخفیف ایتم
            $table->unsignedBigInteger('final_amount')->default(0);      // قیمت نهایی بعد از تخفیف
            $table->unsignedInteger('quantity')->default(1);
            
            $table->json('metadata')->nullable(); // نگهداری جزییات اضافه مانند مدت اعتبار یا سطوح
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

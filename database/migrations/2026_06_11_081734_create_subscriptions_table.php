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
        Schema::create('subscriptions', function (Blueprint $table) {
       $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
        $table->foreignId('plan_price_id')->constrained('plan_prices')->cascadeOnDelete();
        $table->timestamp('started_at')->useCurrent();
        $table->timestamp('expires_at')->nullable();         
        $table->string('status')->default('active')->index();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

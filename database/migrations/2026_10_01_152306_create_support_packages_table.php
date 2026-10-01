<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('support_packages', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->unsignedSmallInteger('duration_months')->unique(); // 6, 12, ...
            $table->unsignedBigInteger('price');

            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);

            $table->string('description')->nullable();
            $table->json('features')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_packages');
    }
};

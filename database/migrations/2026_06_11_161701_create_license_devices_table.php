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
        Schema::create('license_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('license_id')->constrained()->cascadeOnDelete();
            $table->string('machine_fingerprint')->index();
            $table->timestamp('activated_at')->useCurrent();
            $table->timestamps();
    
            // یک لایسنس نباید یک دستگاه تکراری را دوباره ثبت کند
            $table->unique(['license_id', 'machine_fingerprint']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_devices');
    }
};

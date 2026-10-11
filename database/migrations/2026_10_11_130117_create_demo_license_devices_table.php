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
        Schema::create('demo_license_devices', function (Blueprint $table) {
            $table->id();
            $table->string('machine_fingerprint')->unique();
            $table->dateTime('trial_started_at');
            $table->dateTime('trial_expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demo_license_devices');
    }
};

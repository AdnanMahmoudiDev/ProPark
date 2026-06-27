<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('license_devices', function (Blueprint $table) {
            $table->unique(['license_id', 'seat_number'], 'license_devices_license_id_seat_number_unique');
        });
    }

    public function down(): void
    {
        Schema::table('license_devices', function (Blueprint $table) {
            $table->dropUnique('license_devices_license_id_seat_number_unique');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        /*
         * Convert old values to the new business values.
         * Even if carts table is empty, this keeps migration safe.
         */
        DB::table('carts')
            ->where('type', 'new')
            ->update(['type' => 'purchase']);

        DB::table('carts')
            ->where('status', 'active')
            ->update(['status' => 'pending']);

        /*
         * Update column defaults.
         */
        DB::statement("ALTER TABLE carts MODIFY type VARCHAR(255) NOT NULL DEFAULT 'purchase'");
        DB::statement("ALTER TABLE carts MODIFY status VARCHAR(255) NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        /*
         * Restore old defaults.
         */
        DB::statement("ALTER TABLE carts MODIFY type VARCHAR(255) NOT NULL DEFAULT 'new'");
        DB::statement("ALTER TABLE carts MODIFY status VARCHAR(255) NOT NULL DEFAULT 'active'");

        /*
         * Convert values back to previous naming.
         */
        DB::table('carts')
            ->where('type', 'purchase')
            ->update(['type' => 'new']);

        DB::table('carts')
            ->where('status', 'pending')
            ->update(['status' => 'active']);
    }
};

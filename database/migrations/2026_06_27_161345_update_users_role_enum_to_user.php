<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'guard', 'user') NOT NULL DEFAULT 'user'");

        DB::table('users')
            ->where('role', 'guard')
            ->update(['role' => 'user']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user') NOT NULL DEFAULT 'user'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'user', 'guard') NOT NULL DEFAULT 'guard'");

        DB::table('users')
            ->where('role', 'user')
            ->update(['role' => 'guard']);

        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'guard') NOT NULL DEFAULT 'guard'");
    }
};

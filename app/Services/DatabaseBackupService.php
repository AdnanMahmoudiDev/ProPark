<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

class DatabaseBackupService
{
    /**
     * خروجی گرفتن کامل از دیتابیس به فرمت استاندارد SQL
     */
    public function export(): string
    {
        $databaseName = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLES');

        $sql = "-- AvaPark Database Backup\n";
        $sql .= "-- Generated at: " . now()->toDateTimeString() . "\n";
        $sql .= "-- Database: " . $databaseName . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
        $sql .= "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
        $sql .= "SET AUTOCOMMIT = 0;\n";
        $sql .= "START TRANSACTION;\n\n";

        foreach ($tables as $table) {
            $tableArray = get_object_vars($table);
            $tableName = reset($tableArray);

            if (empty($tableName)) {
                continue;
            }

            // دریافت ساختار جدول (DDL)
            $createTableQuery = DB::select("SHOW CREATE TABLE `{$tableName}`");
            $sql .= "-- --------------------------------------------------\n";
            $sql .= "-- Table structure for `{$tableName}`\n";
            $sql .= "-- --------------------------------------------------\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTableQuery[0]->{'Create Table'} . ";\n\n";

            // دریافت داده‌های جدول (DML)
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                $sql .= "-- Dumping data for table `{$tableName}`\n";
                foreach ($rows as $row) {
                    $rowArray = (array) $row;
                    $columns = array_map(fn($col) => "`{$col}`", array_keys($rowArray));
                    $values = array_map(function ($value) {
                        if (is_null($value)) {
                            return 'NULL';
                        }
                        return DB::getPdo()->quote($value);
                    }, array_values($rowArray));

                    $sql .= "INSERT INTO `{$tableName}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        $sql .= "COMMIT;\n";

        return $sql;
    }

    /**
     * بازگردانی و اجرای فایل SQL
     */
    public function import(string $sqlContent): void
    {
        if (empty(trim($sqlContent))) {
            throw new Exception("فایل SQL انتخاب‌شده خالی است.");
        }

        DB::unprepared("SET FOREIGN_KEY_CHECKS=0;");
        
        try {
            DB::unprepared($sqlContent);
        } catch (Exception $e) {
            DB::unprepared("SET FOREIGN_KEY_CHECKS=1;");
            throw new Exception("خطا در بازگردانی دیتابیس: " . $e->getMessage());
        }

        DB::unprepared("SET FOREIGN_KEY_CHECKS=1;");
    }

    /**
     * دریافت اطلاعات و متادیتای آماری دیتابیس
     */
    public function getStats(): array
    {
        $databaseName = DB::getDatabaseName();
        $tables = DB::select('SHOW TABLE STATUS');

        $totalSize = 0;
        $totalRows = 0;

        foreach ($tables as $table) {
            $totalSize += ($table->Data_length + $table->Index_length);
            $totalRows += $table->Rows;
        }

        // نسخه MySQL
        $mysqlVersion = DB::select("SELECT VERSION() as version")[0]->version ?? 'MySQL';

        // شمارش‌های بیزینسی (فقط کاربران و اشتراک‌ها)
        $usersCount = Schema::hasTable('users') ? DB::table('users')->count() : 0;
        
        $subscriptionsCount = 0;
        if (Schema::hasTable('subscriptions')) {
            $subscriptionsCount = DB::table('subscriptions')->count();
        } elseif (Schema::hasTable('user_plans')) {
            $subscriptionsCount = DB::table('user_plans')->count();
        }

        return [
            'database' => $databaseName,
            'tables_count' => count($tables),
            'total_rows' => $totalRows,
            'size_mb' => round($totalSize / (1024 * 1024), 2),
            'mysql_version' => $mysqlVersion,
            'business' => [
                'users' => $usersCount,
                'subscriptions' => $subscriptionsCount,
            ],
            'tables' => $tables
        ];
    }
}

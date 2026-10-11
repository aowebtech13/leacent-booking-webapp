<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL enum alteration is required only on MySQL.
        // This project may run on SQLite in dev environments (e.g. CI/containers),
        // where ALTER TABLE ... MODIFY ... ENUM is not supported.
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE user_roles MODIFY role ENUM('admin','user','vendor') NOT NULL DEFAULT 'user'");
        }

    }

    /**
     * Reverse the migration.
     */


    public function down(): void
    {
        DB::statement("ALTER TABLE user_roles MODIFY role ENUM('admin','user') NOT NULL DEFAULT 'user'");
    }
};


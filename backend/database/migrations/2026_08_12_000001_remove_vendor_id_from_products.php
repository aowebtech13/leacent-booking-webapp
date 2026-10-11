<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'vendor_id')) {
                $foreignKeys = DB::select("
                    SELECT CONSTRAINT_NAME
                    FROM information_schema.KEY_COLUMN_USAGE
                    WHERE TABLE_SCHEMA = DATABASE()
                    AND TABLE_NAME = 'products'
                    AND COLUMN_NAME = 'vendor_id'
                    AND REFERENCED_TABLE_NAME IS NOT NULL
                ");

                if (!empty($foreignKeys)) {
                    $table->dropForeign(['vendor_id']);
                }

                $table->dropIndex(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'vendor_id')) {
                $table->foreignId('vendor_id')->nullable()->after('category_id');
                $table->index('vendor_id');

                try {
                    $table->foreign('vendor_id')->references('id')->on('users')->nullOnDelete();
                } catch (\Throwable $e) {
                    // no-op
                }
            }
        });
    }
};

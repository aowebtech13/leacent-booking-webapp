<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'vendor_id')) {
                $table->foreignId('vendor_id')->nullable()->after('category_id');
                $table->index('vendor_id');
            }

            // Add FK constraint if missing by attempting to create it.
            // Note: Laravel may throw if constraint exists; ignore at runtime.
            try {
                $table->foreign('vendor_id')->references('id')->on('users')->nullOnDelete();
            } catch (\Throwable $e) {
                // no-op
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'vendor_id')) {
                $table->dropForeign(['vendor_id']);
                $table->dropIndex(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
        });
    }
};


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
        Schema::table('email_logs', function (Blueprint $table) {
            // Safely drop the foreign key only if the column exists
            if (Schema::hasColumn('email_logs', 'compliance_report_id')) {
                try {
                    $table->dropForeign(['compliance_report_id']);
                } catch (\Exception $e) {
                    // Foreign key might already be gone, safely ignore
                }

                try {
                    $table->dropColumn('compliance_report_id');
                } catch (\Exception $e) {
                    // Column might already be gone, safely ignore
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('email_logs', 'compliance_report_id')) {
                $table->unsignedBigInteger('compliance_report_id')->nullable();
            }
        });
    }
};
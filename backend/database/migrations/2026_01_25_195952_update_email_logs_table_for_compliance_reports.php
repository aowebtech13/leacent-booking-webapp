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
            $table->foreignId('case_reminder_id')->nullable()->change();
            $table->foreignId('compliance_report_id')->nullable()->after('case_reminder_id')->constrained('compliance_reports')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('email_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('compliance_report_id');
            $table->foreignId('case_reminder_id')->nullable(false)->change();
        });
    }
};

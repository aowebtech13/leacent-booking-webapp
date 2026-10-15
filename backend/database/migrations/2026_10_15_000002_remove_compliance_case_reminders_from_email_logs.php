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
        // Remove compliance/case-reminder foreign keys from email_logs first
        // so the referenced tables can be dropped.
        Schema::table('email_logs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('compliance_report_id');
            $table->dropConstrainedForeignId('case_reminder_id');
        });

        Schema::dropIfExists('compliance_reports');
        Schema::dropIfExists('case_reminders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('case_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('case_id')->nullable();
            $table->string('case_name');
            $table->string('recipient_email');
            $table->string('subject');
            $table->text('body');
            $table->json('payload')->nullable();
            $table->string('type');
            $table->string('status')->default('scheduled');
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('processing_started_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });

        Schema::create('compliance_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('jurisdiction');
            $table->json('industries');
            $table->string('frequency');
            $table->longText('content');
            $table->json('sources')->nullable();
            $table->string('recipient_email');
            $table->timestamps();
        });

        Schema::table('email_logs', function (Blueprint $table) {
            $table->foreignId('case_reminder_id')->nullable()->change();
            $table->foreignId('compliance_report_id')->nullable()->after('case_reminder_id')->constrained('compliance_reports')->cascadeOnDelete();
        });
    }
};

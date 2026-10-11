<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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
    }

    public function down(): void
    {
        Schema::dropIfExists('case_reminders');
    }
};

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
        Schema::create('book_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('book_plan_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('payment_type', ['subscription', 'single_book', 'plan']);
            $table->enum('status', ['pending', 'active', 'failed', 'refunded', 'expired'])->default('pending');
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('currency', 3)->default('NGN');
            $table->string('payment_method')->nullable(); // flutterwave, bank_transfer, etc.
            $table->string('flutterwave_tx_ref')->nullable()->unique();
            $table->string('flutterwave_transaction_id')->nullable();
            $table->string('payment_reference')->nullable();
            $table->string('payment_receipt')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('auto_renew')->default(false);
            $table->timestamp('cancelled_at')->nullable();
            $table->string('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index(['book_plan_id', 'status']);
            $table->index(['flutterwave_tx_ref']);
            $table->index(['expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_payments');
    }
};
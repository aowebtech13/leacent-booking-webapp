<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The `transactions` table is the canonical Ledger: a complete audit trail
     * of every financial interaction in the system (order payments, manual
     * payments awaiting verification, refunds, wallet credits, subscriptions).
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // order_payment | manual_payment | refund | wallet_credit | subscription
            // Fixed: Set maximum length to 50 to prevent key length error in composite index
            $table->string('type', 50);

            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency', 10)->default('NGN');

            $table->string('payment_method')->nullable();

            // pending | accepted | rejected | completed | failed
            // Fixed: Set maximum length to 50 to prevent key length error in composite index
            $table->string('status', 50);

            $table->string('reference')->nullable();
            $table->text('description')->nullable();
            $table->json('meta')->nullable();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            // This composite index will now compile successfully:
            $table->index(['type', 'status']);
            $table->index('created_at');
            $table->index('reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
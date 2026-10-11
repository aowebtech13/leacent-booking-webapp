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
        Schema::table('orders', function (Blueprint $table) {
            // Receipt uploaded by the customer for offline/manual payments.
            $table->string('payment_receipt')->nullable()->after('notes');
            // Customer-supplied reference / teller number for the manual payment.
            $table->string('payment_reference')->nullable()->after('payment_receipt');
            // Amount the customer claims to have paid (used for verification).
            $table->decimal('amount_paid', 12, 2)->nullable()->after('payment_reference');
            // When the customer claims to have made the payment.
            $table->timestamp('paid_at')->nullable()->after('amount_paid');
            // Admin who verified/rejected the manual payment.
            $table->foreignId('payment_verified_by')->nullable()->after('paid_at')->constrained('users')->nullOnDelete();
            $table->timestamp('payment_verified_at')->nullable()->after('payment_verified_by');
            // Reason supplied by the admin when rejecting a manual payment.
            $table->text('payment_rejection_reason')->nullable()->after('payment_verified_at');

            $table->index('payment_verified_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['payment_verified_by']);
            $table->dropForeign(['payment_verified_by']);
            $table->dropColumn([
                'payment_receipt',
                'payment_reference',
                'amount_paid',
                'paid_at',
                'payment_verified_by',
                'payment_verified_at',
                'payment_rejection_reason',
            ]);
        });
    }
};

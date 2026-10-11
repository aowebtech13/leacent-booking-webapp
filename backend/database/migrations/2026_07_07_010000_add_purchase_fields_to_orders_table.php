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
            $table->string('currency', 8)->default('NGN')->after('total');
            $table->decimal('shipping_cost', 12, 2)->default(0)->after('tax');
            $table->string('billing_name')->nullable()->after('shipping_address');
            $table->string('billing_email')->nullable()->after('billing_name');
            $table->string('billing_phone')->nullable()->after('billing_email');
            $table->string('payment_method')->default('flutterwave')->after('billing_phone');
            $table->string('payment_status')->default('unpaid')->after('payment_method'); // unpaid|paid|failed|refunded
            $table->string('flutterwave_tx_ref')->nullable()->after('payment_status');
            $table->string('flutterwave_transaction_id')->nullable()->after('flutterwave_tx_ref');
            $table->text('notes')->nullable()->after('flutterwave_transaction_id');

            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['payment_status']);
            $table->dropColumn([
                'currency',
                'shipping_cost',
                'billing_name',
                'billing_email',
                'billing_phone',
                'payment_method',
                'payment_status',
                'flutterwave_tx_ref',
                'flutterwave_transaction_id',
                'notes',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('subscriptions', 'billing_cycle')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->enum('billing_cycle', ['monthly', 'yearly'])->default('monthly')->after('status');
            });
        }

        if (!Schema::hasColumn('subscriptions', 'cancelled_at')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->timestamp('cancelled_at')->nullable()->after('auto_renew');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('subscriptions', 'billing_cycle')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('billing_cycle');
            });
        }

        if (Schema::hasColumn('subscriptions', 'cancelled_at')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->dropColumn('cancelled_at');
            });
        }
    }
};

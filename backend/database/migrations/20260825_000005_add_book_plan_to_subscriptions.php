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
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->foreignId('book_plan_id')->nullable()->after('plan')
                ->constrained('book_plans')->onDelete('set null');
            $table->string('plan')->default('free')->change();
            $table->string('status')->default('pending')->change();
            $table->string('billing_cycle')->default('monthly')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropForeign(['book_plan_id']);
            $table->dropColumn('book_plan_id');
        });
    }
};
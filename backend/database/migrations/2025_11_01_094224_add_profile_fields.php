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
        Schema::table('profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('profiles', 'company_name')) {
                $table->string('company_name')->nullable()->after('full_name');
            }

            if (!Schema::hasColumn('profiles', 'phone_number')) {
                $table->string('phone_number', 20)->nullable()->after('company_name');
            }

            if (!Schema::hasColumn('profiles', 'address')) {
                $table->string('address')->nullable()->after('phone_number');
            }

            if (!Schema::hasColumn('profiles', 'city')) {
                $table->string('city', 100)->nullable()->after('address');
            }

            if (!Schema::hasColumn('profiles', 'state')) {
                $table->string('state', 100)->nullable()->after('city');
            }

            if (!Schema::hasColumn('profiles', 'country')) {
                $table->string('country', 100)->nullable()->after('state');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'country')) {
                $table->dropColumn('country');
            }

            if (Schema::hasColumn('profiles', 'state')) {
                $table->dropColumn('state');
            }

            if (Schema::hasColumn('profiles', 'city')) {
                $table->dropColumn('city');
            }

            if (Schema::hasColumn('profiles', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('profiles', 'phone_number')) {
                $table->dropColumn('phone_number');
            }

            if (Schema::hasColumn('profiles', 'company_name')) {
                $table->dropColumn('company_name');
            }
        });
    }
};

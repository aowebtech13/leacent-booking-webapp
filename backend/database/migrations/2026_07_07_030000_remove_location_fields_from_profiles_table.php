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
            if (Schema::hasColumn('profiles', 'city')) {
                $table->dropColumn('city');
            }

            if (Schema::hasColumn('profiles', 'state')) {
                $table->dropColumn('state');
            }

            if (Schema::hasColumn('profiles', 'country')) {
                $table->dropColumn('country');
            }

            if (Schema::hasColumn('profiles', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 100)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('country');
        });
    }
};

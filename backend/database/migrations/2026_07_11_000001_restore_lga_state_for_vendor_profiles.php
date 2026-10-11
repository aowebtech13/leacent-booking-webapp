<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('profiles', 'lga')) {
                $table->string('lga', 120)->nullable()->after('address');
            }

            if (! Schema::hasColumn('profiles', 'state')) {
                $table->string('state', 100)->nullable()->after('lga');
            }
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'lga')) {
                $table->dropColumn('lga');
            }
            if (Schema::hasColumn('profiles', 'state')) {
                $table->dropColumn('state');
            }
        });
    }
};


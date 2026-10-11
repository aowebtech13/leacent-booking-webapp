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
            if (!Schema::hasColumn('profiles', 'postal_code')) {
                $table->string('postal_code')->nullable()->after('country');
            }

            if (!Schema::hasColumn('profiles', 'about_me')) {
                $table->text('about_me')->nullable()->after('postal_code');
            }

            if (!Schema::hasColumn('profiles', 'facebook_url')) {
                $table->string('facebook_url')->nullable()->after('about_me');
            }

            if (!Schema::hasColumn('profiles', 'twitter_url')) {
                $table->string('twitter_url')->nullable()->after('facebook_url');
            }

            if (!Schema::hasColumn('profiles', 'linkedin_url')) {
                $table->string('linkedin_url')->nullable()->after('twitter_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            if (Schema::hasColumn('profiles', 'linkedin_url')) {
                $table->dropColumn('linkedin_url');
            }

            if (Schema::hasColumn('profiles', 'twitter_url')) {
                $table->dropColumn('twitter_url');
            }

            if (Schema::hasColumn('profiles', 'facebook_url')) {
                $table->dropColumn('facebook_url');
            }

            if (Schema::hasColumn('profiles', 'about_me')) {
                $table->dropColumn('about_me');
            }

            if (Schema::hasColumn('profiles', 'postal_code')) {
                $table->dropColumn('postal_code');
            }
        });
    }
};

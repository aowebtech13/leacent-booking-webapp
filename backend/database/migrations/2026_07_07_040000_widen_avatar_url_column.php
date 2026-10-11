<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * The SPA uploads avatars as base64 data URLs (data:image/...;base64,...),
     * which easily exceed the previous VARCHAR(255) column. Widen the column
     * to TEXT so the encoded image can be persisted. Uses the Schema builder
     * so it works on both SQLite and MySQL.
     */
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('avatar_url')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('avatar_url')->nullable()->change();
        });
    }
};

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
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'isbn')) {
                $table->dropUnique(['isbn']);
                $table->dropColumn('isbn');
            }
            if (Schema::hasColumn('books', 'price')) {
                $table->dropColumn('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('isbn')->nullable()->unique()->after('author');
            $table->decimal('price', 10, 2)->default(0)->after('preview_path');
        });
    }
};

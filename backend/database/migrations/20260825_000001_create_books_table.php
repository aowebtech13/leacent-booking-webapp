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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('author')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->string('publisher')->nullable();
            $table->string('language')->default('en');
            $table->string('category')->nullable();
            $table->integer('publication_year')->nullable();
            $table->integer('page_count')->nullable();
            $table->string('format')->default('pdf'); // pdf, epub, audio, print
            $table->string('file_path')->nullable();
            $table->string('cover_image_path')->nullable();
            $table->string('preview_path')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('read_count')->default(0);
            $table->integer('download_count')->default(0);
            $table->decimal('rating', 3, 1)->default(0);
            $table->integer('reviews_count')->default(0);
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'is_premium']);
            $table->index(['category', 'is_active']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
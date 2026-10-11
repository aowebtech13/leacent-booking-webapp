<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('size')->nullable()->after('stock');
            $table->string('color')->nullable()->after('size');
            $table->string('product_type')->nullable()->after('color');
            $table->string('brand')->nullable()->after('product_type');
            $table->unsignedInteger('reviews_count')->default(0)->after('brand');
            $table->unsignedInteger('sold_count')->default(0)->after('reviews_count');
            $table->boolean('is_bestseller')->default(false)->after('sold_count');
            $table->boolean('is_featured')->default(false)->after('is_bestseller');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'size',
                'color',
                'product_type',
                'brand',
                'reviews_count',
                'sold_count',
                'is_bestseller',
                'is_featured',
            ]);
        });
    }
};

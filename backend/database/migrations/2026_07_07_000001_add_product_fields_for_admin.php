<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->unique()->after('slug');
            $table->decimal('cost_price', 12, 2)->default(0)->after('description');
            $table->decimal('sale_price', 12, 2)->default(0)->after('cost_price');
            $table->unsignedInteger('low_stock_threshold')->default(0)->after('stock');

            // Keep old columns for backwards compatibility.
            // - price: storefront price (may be synced with sale_price)
            // - stock: inventory (alias for quantity)
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sku', 'cost_price', 'sale_price', 'low_stock_threshold']);
        });
    }
};


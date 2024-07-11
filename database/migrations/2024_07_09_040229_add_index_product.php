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
        Schema::table('products', function (Blueprint $table) {
            $table->index('category_id', 'idx_product_category');
            $table->index('supplier_id', 'idx_product_supplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_product_category');
            $table->dropIndex('idx_product_supplier');
        });

        Schema::table('sale_orders', function (Blueprint $table) {
            $table->dropIndex('idx_sales_order_customer');
        });

        Schema::table('return_orders', function (Blueprint $table) {
            $table->dropIndex('idx_return_order_sales_order');
        });
    }
};

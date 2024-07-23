<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('product_id')->primary();
            $table->foreignId('category_id')->nullable()->constrained('categories', 'category_id')->onDelete('set null');
            $table->foreignUuid('supplier_id')->constrained('suppliers', 'supplier_id')->onDelete('restrict');
            $table->string('barcode')->unique()->nullable();
            $table->string('sku')->unique()->nullable();
            $table->string('name');
            $table->unsignedInteger('current_stock')->default(0);
            $table->unsignedInteger('min_stock')->default(0);
            $table->unsignedInteger('max_stock')->default(0);
            $table->text('description')->nullable();
            $table->unsignedInteger('sale_price')->default(0);
            $table->unsignedInteger('purchase_price')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignUuid('user_id')->nullable()->constrained('users', 'user_id')->onDelete('restrict');

            // Check constraints
            $table->timestamps();
        });


        DB::statement('ALTER TABLE IF EXISTS products ADD CHECK (current_stock >= 0)');
        DB::statement('ALTER TABLE IF EXISTS products ADD CHECK (min_stock >= 0)');
        DB::statement('ALTER TABLE IF EXISTS products ADD CHECK (max_stock >= min_stock)');
        DB::statement('ALTER TABLE IF EXISTS products ADD CHECK (sale_price >= 0)');
        DB::statement('ALTER TABLE IF EXISTS products ADD CHECK (purchase_price >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

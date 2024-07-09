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
        Schema::create('return_orders', function (Blueprint $table) {
            $table->uuid('return_order_id')->primary();
            $table->foreignUuid('sales_order_id')->constrained('sale_orders', 'sale_order_id')->onDelete('restrict');
            $table->foreignUuid('customer_id')->constrained('customers', 'customer_id')->onDelete('restrict');
            $table->foreignUuid('user_id')->constrained('users', 'user_id')->onDelete('restrict');
            $table->json('items');
            $table->integer('total_item')->default(0);
            $table->integer('total_quantity')->default(0);
            $table->integer('total_amount')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();
        });

        if (env('DB_CONNECTION') !== 'pgsql') return;
        DB::statement('ALTER TABLE IF EXISTS return_orders ADD CHECK (total_item >= 0)');
        DB::statement('ALTER TABLE IF EXISTS return_orders ADD CHECK (total_quantity >= 0)');
        DB::statement('ALTER TABLE IF EXISTS return_orders ADD CHECK (total_amount >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_orders');
    }
};

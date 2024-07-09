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
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->uuid('sale_order_id')->primary();
            $table->timestampTz('return_date')->nullable();
            $table->string('customer_type', 100)->nullable();
            $table->foreignUuid('customer_id')->constrained('customers', 'customer_id')->onDelete('restrict');
            $table->json('items')->nullable();
            $table->integer('subtotal')->default(0);
            $table->json('discount_items')->nullable();
            $table->integer('discount_rate')->default(0);
            $table->integer('discount_value')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('total_amount')->default(0);
            $table->json('payment_details');
            $table->string('status', 50)->nullable();
            $table->text('note')->nullable();
            $table->foreignUuid('user_id')->constrained('users', 'user_id')->onDelete('restrict');
            $table->timestamps();
        });

        if (env('DB_CONNECTION') !== 'pgsql') return;
        DB::statement('ALTER TABLE IF EXISTS sale_orders ADD CHECK (subtotal >= 0)');
        DB::statement('ALTER TABLE IF EXISTS sale_orders ADD CHECK (discount_rate >= 0)');
        DB::statement('ALTER TABLE IF EXISTS sale_orders ADD CHECK (discount_value >= 0)');
        DB::statement('ALTER TABLE IF EXISTS sale_orders ADD CHECK (discount_amount >= 0)');
        DB::statement('ALTER TABLE IF EXISTS sale_orders ADD CHECK (tax >= 0)');
        DB::statement('ALTER TABLE IF EXISTS sale_orders ADD CHECK (total_amount >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_orders');
    }
};

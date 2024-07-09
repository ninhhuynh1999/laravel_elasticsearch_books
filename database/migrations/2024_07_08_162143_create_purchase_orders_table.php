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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('purchase_order_id')->primary();
            $table->foreignUuid('supplier_id')->constrained('suppliers', 'supplier_id')->onDelete('restrict');
            $table->json('items');
            $table->integer('sub_total')->default(0);
            $table->integer('tax')->default(0);
            $table->json('discount_items')->nullable();
            $table->integer('discount_rate')->default(0);
            $table->integer('discount_value')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->integer('total_amount')->default(0);
            $table->json('payment_details')->nullable();
            $table->string('status', 50)->nullable();
            $table->text('note')->nullable();
            $table->json('tags')->nullable();
            $table->foreignUuid('user_id')->constrained('users', 'user_id')->onDelete('restrict');
            $table->timestamps();
        });

        if (env('DB_CONNECTION') !== 'pgsql') return;
        DB::statement('ALTER TABLE IF EXISTS purchase_orders ADD CHECK (sub_total >= 0)');
        DB::statement('ALTER TABLE IF EXISTS purchase_orders ADD CHECK (tax >= 0)');
        DB::statement('ALTER TABLE IF EXISTS purchase_orders ADD CHECK (discount_rate >= 0 AND discount_rate <= 100)');
        DB::statement('ALTER TABLE IF EXISTS purchase_orders ADD CHECK (discount_value >= 0)');
        DB::statement('ALTER TABLE IF EXISTS purchase_orders ADD CHECK (discount_amount >= 0)');
        DB::statement('ALTER TABLE IF EXISTS purchase_orders ADD CHECK (total_amount >= 0)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};

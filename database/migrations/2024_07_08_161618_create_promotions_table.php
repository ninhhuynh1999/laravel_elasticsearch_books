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
        Schema::create('promotions', function (Blueprint $table) {
            $table->uuid('promotion_id')->primary();
            $table->string('name');
            $table->string('type', 100)->nullable();
            $table->string('type_name')->nullable();
            $table->integer('apply_to_quantity')->nullable();
            $table->integer('used_quantity')->default(0);
            $table->integer('remain_quantity')->nullable();
            $table->integer('apply_from_amount')->default(0);
            $table->integer('apply_to_amount')->nullable();
            $table->integer('discount_rate')->default(0);
            $table->integer('discount_value')->default(0);
            $table->timestampTz('start_at');
            $table->timestampTz('close_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('status', 50)->nullable();
            $table->foreignUuid('user_id')->constrained('users', 'user_id')->onDelete('restrict');
            $table->timestamps();
        });

        if (env('DB_CONNECTION') !== 'pgsql') return;
        // Check constraints
        DB::statement('ALTER TABLE IF EXISTS promotions ADD CHECK (used_quantity >= 0)');
        DB::statement('ALTER TABLE IF EXISTS promotions ADD CHECK (apply_from_amount >= 0)');
        DB::statement('ALTER TABLE IF EXISTS promotions ADD CHECK (apply_to_amount > apply_from_amount)');
        DB::statement('ALTER TABLE IF EXISTS promotions ADD CHECK (discount_rate >= 0 AND discount_rate <= 100)');
        DB::statement('ALTER TABLE IF EXISTS promotions ADD CHECK (discount_value >= 0)');
        DB::statement('ALTER TABLE IF EXISTS promotions ADD CHECK (close_at > start_at)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};

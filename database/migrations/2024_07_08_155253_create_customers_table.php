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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('customer_id')->primary();
            $table->string('name');
            $table->string('sex', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->json('sales_order_information')->nullable();
            $table->text('address')->nullable();
            $table->string('type', 100)->nullable();
            $table->text('note')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('tags')->nullable();
            $table->timestamps();

            $table->foreignUuid('user_id')->nullable()->constrained('users', 'user_id')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

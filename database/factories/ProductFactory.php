<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salePrice = fake()->numberBetween(5, 50);
        $purchasePrice = $salePrice - fake()->numberBetween(1, 4);
        return [
            'category_id' => Category::inRandomOrder()->first()->category_id,
            'supplier_id' => Supplier::inRandomOrder()->first()->supplier_id,
            'barcode' => null,
            'sku' => null,
            'name' => fake()->realTextBetween(10, 200, 5),
            'current_stock' => fake()->numberBetween(0, 500),
            'min_stock' => fake()->numberBetween(1, 20),
            'max_stock' => fake()->numberBetween(600, 1000),
            'description' => fake()->realTextBetween(500, 1000),
            'sale_price' => $salePrice,
            'purchase_price' => $purchasePrice,
            'is_active' => fake()->numberBetween(0, 10) ? true : false,
        ];
    }

    public function userUpdated(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::inRandomOrder()->first()->user_id,
        ]);
    }
}

<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => fake()->company(),
            'email' => fake()->companyEmail(),
            'address' => fake()->address(),
            'description' => fake()->paragraph(),
            'is_active' => fake()->boolean(),
            'user_id' => null,
        ];
    }

    public function userUpdated(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::inRandomOrder()->first()->user_id,
        ]);
    }
}

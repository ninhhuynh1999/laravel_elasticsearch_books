<?php

namespace Database\Factories;

use App\Common\Enums\Gender;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = [
            Gender::MALE->value,
            Gender::FEMALE->value,
            Gender::OTHER->value,
        ];

        return [
            'name' => fake()->firstName() . ' ' . fake()->lastName(),
            'gender' => $gender[fake()->numberBetween(0, 2)],
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake('ro_RO')->phoneNumber(),
            'address' => fake()->address(),
            'note' => fake()->paragraph(),
            'is_active' => fake()->boolean(),
        ];
    }

    public function userUpdated(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => User::inRandomOrder()->first()->user_id,
        ]);
    }
}

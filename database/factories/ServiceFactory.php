<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-2years');

        return [
            'name' => fake()->text(60),
            'description' => fake()->text(1500),
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt)
        ];
    }
}

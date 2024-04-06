<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
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
            'title' => fake()->text(30),
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt)
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = $this->faker->image(storage_path('app/public'));

        try {
            $addCaption = random_int(0, 1);
        } catch (\Exception) {
            $addCaption = 0;
        }

        return [
            'post_id' => null,
            'file_path' => 'storage/' . basename($fileName),
            'caption' => $addCaption ? fake()->sentence() : null,
            'display_order' => null
        ];
    }
}

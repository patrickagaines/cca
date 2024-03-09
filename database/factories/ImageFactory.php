<?php

namespace Database\Factories;

use App\Models\Image;
use Exception;
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
        $filePath = $this->faker->image(storage_path('app/public/images'));
        $fileName = basename($filePath);

        try {
            $addCaption = random_int(0, 1);
        } catch (Exception) {
            $addCaption = 0;
        }

        return [
            'post_id'   => null,
            'file_name' => $fileName,
            'file_path' => "storage/images/$fileName",
            'caption'   => $addCaption ? fake()->sentence() : null,
            'position'  => null
        ];
    }
}

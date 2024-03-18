<?php

namespace Database\Factories;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\Factory;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

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
        $imagesDirectory = storage_path('app/public/images');
        $isPortrait = (bool) (rand() % 2);
        $hasCaption = (bool) (rand() % 2);
        $width = $isPortrait ? 1440 : 1920;
        $height = $isPortrait ? 1920 : 1440;

        $filePath = $this->faker->image(
            dir: $imagesDirectory,
            width: $width,
            height: $height
        );

        $fileName = basename($filePath);

        $interventionImage = InterventionImage::read($filePath);

        if($isPortrait) {
            $interventionImage->scaleDown(width: 600);
        } else {
            $interventionImage->scaleDown(height: 600);
        }

        $interventionImage->resizeCanvas(width: 600, height: 600);
        $thumbnailFileName = substr_replace($fileName, '-600x600', strpos($fileName, '.'), 0);
        $interventionImage->save("$imagesDirectory/$thumbnailFileName");

        return [
            'post_id'   => null,
            'file_name' => $fileName,
            'file_path' => "storage/images/$fileName",
            'thumbnail_path' => "storage/images/$thumbnailFileName",
            'caption'   => $hasCaption ? fake()->sentence() : null,
            'position'  => null
        ];
    }
}

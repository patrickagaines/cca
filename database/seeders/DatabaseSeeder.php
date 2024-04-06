<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Post;
use App\Models\Service;
use Exception;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Post::factory(20)->create()->each(function (Post $post) {
            try {
                $numImages = random_int(5, 10);
            } catch (Exception) {
                $numImages = 5;
            }

            for ($i = 1; $i <= $numImages; $i++) {
                Image::factory()->for($post)
                    ->state([
                        'position' => $i,
                        'created_at' => $post->created_at,
                        'updated_at' => fake()->dateTimeBetween($post->created_at)
                    ])
                    ->create();
            }
        });

        Service::factory(20)->create();
    }
}

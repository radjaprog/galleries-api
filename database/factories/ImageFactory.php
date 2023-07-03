<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
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
        $galleryIds = Gallery::pluck('id')->toArray();

        return [
            'image_url'  => fake()->imageUrl($width = 640, $height = 320),
            'gallery_id' => fake()->randomElement($galleryIds),
        ];
    }
}

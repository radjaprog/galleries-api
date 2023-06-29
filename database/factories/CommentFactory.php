<?php

namespace Database\Factories;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIds = User::pluck('id')->toArray();
        $galleryIds = Gallery::pluck('id')->toArray();

        return [
            'content' => fake()->text($maxNbChar = 50),
            'user_id' => fake()->randomElement($userIds),
            'gallery_id' => fake()->randomElement($galleryIds),
        ];
    }
}

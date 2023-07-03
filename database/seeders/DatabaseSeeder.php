<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class
        ]);
        $this->call([
            GallerySeeder::class
        ]);
        $this->call([
            ImageSeeder::class
        ]);
        $this->call([
            CommentSeeder::class
        ]);
    }
}

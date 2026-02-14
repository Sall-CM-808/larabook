<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'Science-Fiction', 'slug' => 'science-fiction'],
            ['nom' => 'Littérature classique', 'slug' => 'litterature-classique'],
            ['nom' => 'Histoire', 'slug' => 'histoire'],
            ['nom' => 'Sciences', 'slug' => 'sciences'],
            ['nom' => 'Philosophie', 'slug' => 'philosophie'],
            ['nom' => 'Roman', 'slug' => 'roman'],
            ['nom' => 'Informatique', 'slug' => 'informatique'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}

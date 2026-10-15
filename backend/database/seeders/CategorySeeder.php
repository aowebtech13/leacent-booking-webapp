<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\DatabaseSeeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => "Men's Clothing",
                'slug' => 'mens-clothing',
                'description' => 'Stylish and comfortable clothing for men.',
                'order' => 1,
            ],
            [
                'name' => "Women's Clothing",
                'slug' => 'womens-clothing',
                'description' => 'Trendy and elegant clothing for women.',
                'order' => 2,
            ],
            [
                'name' => "Kids' Clothing",
                'slug' => 'kids-clothing',
                'description' => 'Fun and durable clothing for kids.',
                'order' => 3,
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Complete your look with our accessories.',
                'order' => 4,
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
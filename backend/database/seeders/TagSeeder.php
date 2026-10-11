<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'New Arrival', 'slug' => 'new-arrival', 'description' => 'Just landed in our store.'],
            ['name' => 'Sale', 'slug' => 'sale', 'description' => 'Currently on sale at a discounted price.'],
            ['name' => 'Premium', 'slug' => 'premium', 'description' => 'High-quality premium materials.'],
            ['name' => 'Casual', 'slug' => 'casual', 'description' => 'Perfect for everyday casual wear.'],
            ['name' => 'Formal', 'slug' => 'formal', 'description' => 'Elegant formal attire for special occasions.'],
            ['name' => 'Summer', 'slug' => 'summer', 'description' => 'Light and breathable for summer.'],
            ['name' => 'Winter', 'slug' => 'winter', 'description' => 'Warm and cozy for winter.'],
            ['name' => 'Cotton', 'slug' => 'cotton', 'description' => 'Made from 100% cotton.'],
            ['name' => 'Denim', 'slug' => 'denim', 'description' => 'Classic denim fabric.'],
            ['name' => 'Limited Edition', 'slug' => 'limited-edition', 'description' => 'Exclusive limited edition piece.'],
            ['name' => 'Fast', 'slug' => 'fast', 'description' => 'Fast performance and charging.'],
            ['name' => 'Powerful', 'slug' => 'powerful', 'description' => 'Powerful and high-performance.'],
            ['name' => 'Reliable', 'slug' => 'reliable', 'description' => 'Reliable and durable build.'],
            ['name' => 'Compact', 'slug' => 'compact', 'description' => 'Compact and portable design.'],
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }
}

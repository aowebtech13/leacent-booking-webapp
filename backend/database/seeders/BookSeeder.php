<?php

namespace Database\Seeders;

use App\Models\BookPlan;
use Illuminate\Database\Seeder;

class BookPlanSeeder extends Seeder
{
    /**
     * Seed the point packages offered on the pricing page.
     * Idempotent: existing plans (matched by slug) are refreshed.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter Pack',
                'slug' => 'starter-pack',
                'points' => 50,
                'price' => 4.99,
                'description' => 'Get started with a few extra reads.',
                'is_active' => true,
                'is_popular' => false,
            ],
            [
                'name' => 'Reader Bundle',
                'slug' => 'reader-bundle',
                'points' => 150,
                'price' => 12.99,
                'description' => 'Our most popular choice for avid readers.',
                'is_active' => true,
                'is_popular' => true,
            ],
            [
                'name' => 'Library Pass',
                'slug' => 'library-pass',
                'points' => 400,
                'price' => 29.99,
                'description' => 'Maximum value for heavy bookworms.',
                'is_active' => true,
                'is_popular' => false,
            ],
        ];

        foreach ($plans as $plan) {
            BookPlan::updateOrCreate(
                ['slug' => $plan['slug']],
                $plan
            );
        }
    }
}
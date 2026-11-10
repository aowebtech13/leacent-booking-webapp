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
        $currency = config('ecommerce.currency', 'NGN');

        $plans = [
            [
                'name' => 'Starter Pack',
                'slug' => 'starter-pack',
                'points' => 50,
                'price' => 4.99,
                'description' => 'Get started with a few extra reads.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    'Standard web reader access',
                    'Lifetime point validity',
                ],
            ],
            [
                'name' => 'Reader Bundle',
                'slug' => 'reader-bundle',
                'points' => 150,
                'price' => 12.99,
                'description' => 'Our most popular choice for avid readers.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    'Standard web reader access',
                    'Offline in-app reading',
                    'Basic bookmarking',
                ],
            ],
            [
                'name' => 'Library Pass',
                'slug' => 'library-pass',
                'points' => 400,
                'price' => 29.99,
                'description' => 'Maximum value for heavy bookworms.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    '5% bonus reader credit',
                    'Early access to new releases',
                    'VIP reader badge',
                ],
            ],
        ];

        // Remove stale plans (old slugs) so only current packages remain.
        $validSlugs = collect($plans)->pluck('slug')->toArray();
        BookPlan::whereNotIn('slug', $validSlugs)->delete();

        foreach ($plans as $plan) {
            BookPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}

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
                'name' => 'Mini Pack',
                'slug' => 'mini-pack',
                'points' => 3,
                'price' => 450,
                'description' => 'Try us out with a small boost.',
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
                'name' => 'Basic Pack',
                'slug' => 'basic-pack',
                'points' => 10,
                'price' => 1500,
                'description' => 'A little more reading fuel.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 2,
                'features' => [
                    'Standard web reader access',
                    'Lifetime point validity',
                ],
            ],
            [
                'name' => 'Starter Pack',
                'slug' => 'starter-pack',
                'points' => 15,
                'price' => 2250,
                'description' => 'Great value for casual readers.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 3,
                'features' => [
                    'Standard web reader access',
                    'Offline in-app reading',
                    'Basic bookmarking',
                ],
            ],
            [
                'name' => 'Reader Bundle',
                'slug' => 'reader-bundle',
                'points' => 30,
                'price' => 4500,
                'description' => 'Our most popular choice for avid readers.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 4,
                'features' => [
                    'Standard web reader access',
                    'Offline in-app reading',
                    'Basic bookmarking',
                ],
            ],
            [
                'name' => 'Library Pass',
                'slug' => 'library-pass',
                'points' => 45,
                'price' => 6750,
                'description' => 'Maximum value for heavy bookworms.',
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 5,
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

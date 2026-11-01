<?php

namespace Database\Seeders;

use App\Models\BookPlan;
use Illuminate\Database\Seeders\Seeders;

class BookPlanSeeder extends Seeders
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
                'description' => '3 points for occasional readers.',
                'price' => 450,
                'points' => 3,
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    '3 leacent book points',
                    'Unlock books permanently',
                    'One-time payment',
                ],
            ],
            [
                'name' => 'Popular Pack',
                'slug' => 'popular-pack',
                'description' => '10 points for regular readers.',
                'price' => 1500,
                'points' => 10,
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    '10 leacent book points',
                    'Unlock books permanently',
                    'One-time payment',
                ],
            ],
            [
                'name' => 'Pro Pack',
                'slug' => 'pro-pack',
                'description' => '20 points for heavy readers.',
                'price' => 3000,
                'points' => 20,
                'currency' => $currency,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    '20 leacent book points',
                    'Unlock books permanently',
                    'One-time payment',
                ],
            ],
        ];

        foreach ($plans as $plan) {
            BookPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}

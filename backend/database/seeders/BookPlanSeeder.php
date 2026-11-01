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
                'name' => 'Quick Read',
                'slug' => 'quick-read',
                'description' => 'Casual readers testing out a chapter or short story.',
                'price' => 450,
                'points' => 3,
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
                'name' => 'Story Pack',
                'slug' => 'story-pack',
                'description' => 'Readers diving into a full short book or novella.',
                'price' => 1050,
                'points' => 7,
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
                'name' => 'Collector Tier',
                'slug' => 'collector-tier',
                'description' => 'Power readers unlocking full series or high-tier books.',
                'price' => 1500,
                'points' => 10,
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

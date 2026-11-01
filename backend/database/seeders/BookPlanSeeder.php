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
                'description' => '100 points for occasional readers.',
                'price' => 1000,
                'points' => 100,
                'currency' => $currency,
                'billing_cycle' => 'one_time',
                'access_duration_days' => 0,
                'unlimited_books' => false,
                'book_limit' => 0,
                'can_download' => false,
                'can_read_offline' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    '100 leacent book points',
                    'Unlock books permanently',
                    'One-time payment',
                ],
            ],
            [
                'name' => 'Popular Pack',
                'slug' => 'popular-pack',
                'description' => '500 points for regular readers.',
                'price' => 4500,
                'points' => 500,
                'currency' => $currency,
                'billing_cycle' => 'one_time',
                'access_duration_days' => 0,
                'unlimited_books' => false,
                'book_limit' => 0,
                'can_download' => false,
                'can_read_offline' => false,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    '500 leacent book points',
                    'Unlock books permanently',
                    'Save 10% vs Starter Pack',
                    'Priority support',
                ],
            ],
            [
                'name' => 'Pro Pack',
                'slug' => 'pro-pack',
                'description' => '2000 points for heavy readers.',
                'price' => 16000,
                'points' => 2000,
                'currency' => $currency,
                'billing_cycle' => 'one_time',
                'access_duration_days' => 0,
                'unlimited_books' => false,
                'book_limit' => 0,
                'can_download' => true,
                'can_read_offline' => true,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    '2000 leacent book points',
                    'Unlock books permanently',
                    'Download books for offline reading',
                    'Read offline',
                    'Save 20% vs Popular Pack',
                ],
            ],
        ];

        foreach ($plans as $plan) {
            BookPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
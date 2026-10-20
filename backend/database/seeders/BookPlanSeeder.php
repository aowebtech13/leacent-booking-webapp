<?php

namespace Database\Seeders;

use App\Models\BookPlan;
use Illuminate\Database\Seeder;

class BookPlanSeeder extends Seeder
{
    /**
     * Seed the subscription plans offered on the pricing page.
     * Idempotent: existing plans (matched by slug) are refreshed.
     */
    public function run(): void
    {
        $currency = config('ecommerce.currency', 'NGN');

        $plans = [
            [
                'name' => 'Monthly Access',
                'slug' => 'monthly-access',
                'description' => 'Read the full library for 30 days.',
                'price' => 3000,
                'currency' => $currency,
                'billing_cycle' => 'monthly',
                'access_duration_days' => 30,
                'unlimited_books' => true,
                'book_limit' => 0,
                'can_download' => true,
                'can_read_offline' => false,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 1,
                'features' => [
                    'Unlimited book access',
                    'Download books for offline reading',
                    'Valid for 30 days',
                    'Priority email support',
                ],
            ],
            [
                'name' => 'Quarterly Access',
                'slug' => 'quarterly-access',
                'description' => 'Read the full library for 90 days.',
                'price' => 8000,
                'currency' => $currency,
                'billing_cycle' => 'monthly',
                'access_duration_days' => 90,
                'unlimited_books' => true,
                'book_limit' => 0,
                'can_download' => true,
                'can_read_offline' => true,
                'is_active' => true,
                'is_featured' => true,
                'sort_order' => 2,
                'features' => [
                    'Unlimited book access',
                    'Download books for offline reading',
                    'Read offline',
                    'Valid for 90 days',
                    'Priority support',
                ],
            ],
            [
                'name' => 'Yearly Access',
                'slug' => 'yearly-access',
                'description' => 'Read the full library for a full year.',
                'price' => 30000,
                'currency' => $currency,
                'billing_cycle' => 'yearly',
                'access_duration_days' => 365,
                'unlimited_books' => true,
                'book_limit' => 0,
                'can_download' => true,
                'can_read_offline' => true,
                'is_active' => true,
                'is_featured' => false,
                'sort_order' => 3,
                'features' => [
                    'Unlimited book access',
                    'Download books for offline reading',
                    'Read offline',
                    'Valid for 365 days',
                    'Best value for heavy readers',
                ],
            ],
        ];

        foreach ($plans as $plan) {
            BookPlan::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}

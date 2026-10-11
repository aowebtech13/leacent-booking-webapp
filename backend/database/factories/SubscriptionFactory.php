<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition(): array
    {
        $user = User::factory();
        $plan = $this->faker->randomElement(['Free', 'Student', 'Pro', 'Max', 'Team']);
        $billingCycle = $this->faker->randomElement(['monthly', 'yearly']);

        $planPrices = [
            'Free' => 0,
            'Student' => 4 * 1500,
            'Pro' => 10 * 1500,
            'Max' => 14 * 1500,
            'Team' => 25 * 1500,
        ];

        return [
            'user_id' => $user,
            'plan' => $plan,
            'status' => $this->faker->randomElement(['active', 'pending', 'cancelled', 'expired']),
            'billing_cycle' => $billingCycle,
            'amount' => $planPrices[$plan],
            'currency' => 'NGN',
            'flutterwave_transaction_id' => $this->faker->numerify('########'),
            'flutterwave_tx_ref' => 'sub_' . $this->faker->numberBetween(1, 9999) . '_' . time(),
            'start_date' => now()->subDays(30),
            'end_date' => $billingCycle === 'monthly' ? now()->addMonth() : now()->addYear(),
            'auto_renew' => true,
            'cancelled_at' => null,
        ];
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
            'auto_renew' => true,
            'start_date' => now()->subDays(10),
        ]);
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
            'auto_renew' => false,
            'start_date' => null,
            'end_date' => null,
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'auto_renew' => false,
            'cancelled_at' => now()->subDays(5),
        ]);
    }

    public function free(): static
    {
        return $this->state(fn (array $attributes) => [
            'plan' => 'Free',
            'amount' => 0,
            'status' => 'active',
        ]);
    }
}

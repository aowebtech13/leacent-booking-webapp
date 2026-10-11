<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentSubscriptionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        config([
            'services.flutterwave.secret_key' => 'test_secret_key',
            'services.flutterwave.webhook_secret' => 'test_webhook_secret',
        ]);
    }

    public function test_user_can_initialize_payment_for_paid_plan()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/test_link',
                    'id' => '123456',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'basic',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'payment_link',
                    'tx_ref',
                ]
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
        ]);
    }

    public function test_user_can_activate_free_plan()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'free',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Free plan activated',
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'free',
            'status' => 'active',
            'billing_cycle' => 'monthly',
        ]);
    }

    public function test_user_can_verify_successful_payment()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => [
                    'status' => 'successful',
                    'id' => '123456',
                    'amount' => 21000,
                    'currency' => 'NGN',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $response = $this->actingAs($user)->postJson('/api/payment/verify', [
            'tx_ref' => $txRef,
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'active',
            'flutterwave_tx_ref' => $txRef,
        ]);
    }

    public function test_user_can_view_active_subscription()
    {
        $user = User::factory()->create();

        Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $response = $this->actingAs($user)->getJson('/api/subscription');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'plan' => 'premium',
                    'status' => 'active',
                ]
            ]);
    }

    public function test_user_can_cancel_active_subscription()
    {
        $user = User::factory()->create();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $response = $this->actingAs($user)->postJson('/api/subscription/cancel');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'status' => 'cancelled',
                ]
            ]);

        $subscription->refresh();
        $this->assertEquals('cancelled', $subscription->status);
    }

    public function test_webhook_confirms_payment_automatically()
    {
        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $payload = [
            'event' => 'charge.completed',
            'data' => [
                'tx_ref' => $txRef,
                'status' => 'successful',
                'id' => '123456',
                'amount' => 21000,
                'currency' => 'NGN',
            ]
        ];

        $response = $this->postJson('/api/payment/webhook', $payload, [
            'verif-hash' => config('services.flutterwave.webhook_secret'),
        ]);

        $response->assertStatus(200);

        $subscription->refresh();
        $this->assertEquals('active', $subscription->status);
        $this->assertNotNull($subscription->start_date);
        $this->assertNotNull($subscription->end_date);
    }

    public function test_only_one_active_subscription_per_user()
    {
        $user = User::factory()->create();

        $subscription1 = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 495,
            'currency' => 'NGN',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $txRef = 'sub_' . $user->id . '_' . time();
        $subscription2 = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $payload = [
            'event' => 'charge.completed',
            'data' => [
                'tx_ref' => $txRef,
                'status' => 'successful',
                'id' => '123456',
                'amount' => 21000,
                'currency' => 'NGN',
            ]
        ];

        $this->postJson('/api/payment/webhook', $payload, [
            'verif-hash' => config('services.flutterwave.webhook_secret'),
        ]);

        $subscription1->refresh();
        $subscription2->refresh();

        $this->assertEquals('expired', $subscription1->status);
        $this->assertEquals('active', $subscription2->status);
    }

    public function test_user_can_view_subscription_history()
    {
        $user = User::factory()->create();

        Subscription::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/subscription/history');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_admin_can_view_all_subscriptions()
    {
        $admin = User::factory()->create();
        $admin->roles()->create(['role' => 'admin']);

        User::factory()->count(5)->create()->each(function ($user) {
            Subscription::factory()->create(['user_id' => $user->id]);
        });

        $response = $this->actingAs($admin)->getJson('/api/admin/subscriptions');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }

    public function test_admin_can_update_subscription_status()
    {
        $admin = User::factory()->create();
        $admin->roles()->create(['role' => 'admin']);

        $subscription = Subscription::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->putJson(
            "/api/admin/subscriptions/{$subscription->id}/status",
            ['status' => 'active']
        );

        $response->assertStatus(200);

        $subscription->refresh();
        $this->assertEquals('active', $subscription->status);
    }

    public function test_payment_initialization_creates_pending_subscription()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/premium_monthly',
                    'id' => '999888',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('data.payment_link', 'https://checkout.flutterwave.com/pay/premium_monthly');

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
        ]);
    }

    public function test_payment_initialization_includes_transaction_reference()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/test',
                    'id' => '123',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'basic',
            'billing_cycle' => 'yearly',
        ]);

        $response->assertStatus(200);
        $txRef = $response->json('data.tx_ref');

        $this->assertStringStartsWith('sub_' . $user->id . '_', $txRef);
        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'flutterwave_tx_ref' => $txRef,
        ]);
    }

    public function test_payment_initialization_fails_without_secret_key()
    {
        config(['services.flutterwave.secret_key' => null]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(500)
            ->assertJson([
                'success' => false,
                'message' => 'Failed to initialize payment',
            ]);
    }

    public function test_payment_initialization_handles_flutterwave_api_error()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'error',
                'message' => 'Invalid API key',
            ], 401)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid API key',
            ]);
    }

    public function test_payment_initialization_handles_network_timeout()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'error',
                'message' => 'Connection timeout',
            ], 503)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(400)
            ->assertJson(['success' => false]);
    }

    public function test_payment_initialization_requires_authentication()
    {
        $response = $this->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(401);
    }

    public function test_payment_initialization_validates_plan_parameter()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'invalid_plan',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('plan');
    }

    public function test_payment_initialization_validates_billing_cycle_parameter()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'invalid_cycle',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('billing_cycle');
    }

    public function test_payment_initialization_handles_missing_payment_link_in_response()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'id' => '123456',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'data' => ['payment_link', 'tx_ref']
            ]);
    }

    public function test_yearly_billing_uses_correct_pricing()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/premium_yearly',
                    'id' => '123456',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'yearly',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'premium',
            'billing_cycle' => 'yearly',
            'amount' => 231000,
        ]);
    }

    public function test_enterprise_plan_initialization()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/enterprise_monthly',
                    'id' => '123456',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'enterprise',
            'billing_cycle' => 'monthly',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'enterprise',
            'amount' => 37500,
        ]);
    }

    public function test_payment_initialization_with_yearly_billing_for_enterprise()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/test',
                    'id' => '123456',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'enterprise',
            'billing_cycle' => 'yearly',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'enterprise',
            'status' => 'pending',
            'billing_cycle' => 'yearly',
            'amount' => 412500,
        ]);
    }

    public function test_multiple_payment_initializations_for_same_user()
    {
        Http::fake([
            'https://api.flutterwave.com/v3/payments' => Http::response([
                'status' => 'success',
                'data' => [
                    'link' => 'https://checkout.flutterwave.com/pay/test',
                    'id' => '123456',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $response1 = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'basic',
            'billing_cycle' => 'monthly',
        ]);

        sleep(1);

        $response2 = $this->actingAs($user)->postJson('/api/payment/initialize', [
            'plan' => 'premium',
            'billing_cycle' => 'monthly',
        ]);

        $response1->assertStatus(200);
        $response2->assertStatus(200);

        $this->assertDatabaseCount('subscriptions', 2);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
        ]);
    }

    public function test_user_receives_updated_subscription_after_payment_verification()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => [
                    'status' => 'successful',
                    'id' => '123456',
                    'amount' => 21000,
                    'currency' => 'NGN',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $user->refresh();

        $response = $this->actingAs($user)->postJson('/api/payment/verify', [
            'tx_ref' => $txRef,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonPath('data.active_subscription.plan', 'premium')
            ->assertJsonPath('data.active_subscription.status', 'active');

        $subscription->refresh();
        $this->assertEquals('active', $subscription->status);
        $this->assertNotNull($subscription->start_date);
        $this->assertNotNull($subscription->end_date);
    }

    public function test_admin_can_view_updated_subscription()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => [
                    'status' => 'successful',
                    'id' => '123456',
                    'amount' => 21000,
                    'currency' => 'NGN',
                ]
            ], 200)
        ]);

        $admin = User::factory()->create();
        $admin->roles()->create(['role' => 'admin']);

        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $this->actingAs($user)->postJson('/api/payment/verify', [
            'tx_ref' => $txRef,
        ]);

        $response = $this->actingAs($admin)->getJson('/api/admin/subscriptions');

        $response->assertStatus(200)
            ->assertJson(['success' => true])
            ->assertJsonFragment(['plan' => 'premium', 'status' => 'active']);
    }

    public function test_previous_active_subscription_marked_as_expired_on_new_payment()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'success',
                'data' => [
                    'status' => 'successful',
                    'id' => '123456',
                    'amount' => 21000,
                    'currency' => 'NGN',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $previousSubscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 495,
            'currency' => 'NGN',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $txRef = 'sub_' . $user->id . '_' . time();
        sleep(1);

        $newSubscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $this->actingAs($user)->postJson('/api/payment/verify', [
            'tx_ref' => $txRef,
        ]);

        $previousSubscription->refresh();
        $newSubscription->refresh();

        $this->assertEquals('expired', $previousSubscription->status);
        $this->assertEquals('active', $newSubscription->status);
    }

    public function test_webhook_automatically_updates_subscription_visible_to_admin()
    {
        $admin = User::factory()->create();
        $admin->roles()->create(['role' => 'admin']);

        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $this->postJson('/api/payment/webhook', [
            'event' => 'charge.completed',
            'data' => [
                'tx_ref' => $txRef,
                'status' => 'successful',
                'id' => '123456',
                'amount' => 21000,
                'currency' => 'NGN',
            ]
        ], [
            'verif-hash' => config('services.flutterwave.webhook_secret'),
        ]);

        $subscription->refresh();

        $this->assertEquals('active', $subscription->status);

        $adminResponse = $this->actingAs($admin)->getJson('/api/admin/subscriptions?plan=premium&status=active');

        $adminResponse->assertStatus(200)
            ->assertJsonFragment(['plan' => 'premium', 'status' => 'active']);
    }

    public function test_admin_can_view_subscription_with_payment_details()
    {
        $admin = User::factory()->create();
        $admin->roles()->create(['role' => 'admin']);

        $user = User::factory()->create();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_transaction_id' => 'FW_TXN_123456',
            'flutterwave_tx_ref' => 'sub_' . $user->id . '_' . time(),
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $response = $this->actingAs($admin)->getJson('/api/admin/subscriptions');

        $response->assertStatus(200);

        $foundSubscription = collect($response->json('data.data'))->first(function($item) use ($subscription) {
            return $item['id'] === $subscription->id;
        });

        $this->assertNotNull($foundSubscription);
        $this->assertEquals('premium', $foundSubscription['plan']);
        $this->assertEquals('active', $foundSubscription['status']);
        $this->assertEquals(21000, $foundSubscription['amount']);
    }

    public function test_user_subscription_endpoint_returns_active_subscription_only()
    {
        $user = User::factory()->create();

        Subscription::create([
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'expired',
            'billing_cycle' => 'monthly',
            'amount' => 495,
            'currency' => 'NGN',
            'start_date' => now()->subMonth(),
            'end_date' => now(),
            'auto_renew' => true,
        ]);

        $activeSubscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $response = $this->actingAs($user)->getJson('/api/subscription');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'plan' => 'premium',
                    'status' => 'active',
                ]
            ]);

        $this->assertEquals($activeSubscription->id, $response->json('data.id'));
    }

    public function test_webhook_processes_failed_payment_gracefully()
    {
        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $response = $this->postJson('/api/payment/webhook', [
            'event' => 'charge.completed',
            'data' => [
                'tx_ref' => $txRef,
                'status' => 'failed',
                'id' => '123456',
                'amount' => 21000,
                'currency' => 'NGN',
            ]
        ], [
            'verif-hash' => config('services.flutterwave.webhook_secret'),
        ]);

        $response->assertStatus(200);

        $subscription->refresh();

        $this->assertEquals('pending', $subscription->status);
    }

    public function test_payment_failure_reverts_user_to_free_plan()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'error',
                'data' => [
                    'status' => 'failed',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();
        $txRef = 'sub_' . $user->id . '_' . time();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $response = $this->actingAs($user)->postJson('/api/payment/verify', [
            'tx_ref' => $txRef,
        ]);

        $response->assertStatus(400)
            ->assertJson(['success' => false]);

        $this->assertDatabaseMissing('subscriptions', [
            'id' => $subscription->id,
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'free',
            'status' => 'active',
        ]);
    }

    public function test_payment_failure_with_existing_active_subscription()
    {
        Http::fake([
            '*' => Http::response([
                'status' => 'error',
                'data' => [
                    'status' => 'failed',
                ]
            ], 200)
        ]);

        $user = User::factory()->create();

        $existingSubscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'basic',
            'status' => 'active',
            'billing_cycle' => 'monthly',
            'amount' => 495,
            'currency' => 'NGN',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'auto_renew' => true,
        ]);

        $txRef = 'sub_' . $user->id . '_' . time();
        $pendingSubscription = Subscription::create([
            'user_id' => $user->id,
            'plan' => 'premium',
            'status' => 'pending',
            'billing_cycle' => 'monthly',
            'amount' => 21000,
            'currency' => 'NGN',
            'flutterwave_tx_ref' => $txRef,
            'auto_renew' => false,
        ]);

        $response = $this->actingAs($user)->postJson('/api/payment/verify', [
            'tx_ref' => $txRef,
        ]);

        $response->assertStatus(400);

        $this->assertDatabaseMissing('subscriptions', [
            'id' => $pendingSubscription->id,
        ]);

        $existingSubscription->refresh();
        $this->assertEquals('active', $existingSubscription->status);
        $this->assertEquals('basic', $existingSubscription->plan);

        $this->assertDatabaseMissing('subscriptions', [
            'user_id' => $user->id,
            'plan' => 'free',
        ]);
    }
}

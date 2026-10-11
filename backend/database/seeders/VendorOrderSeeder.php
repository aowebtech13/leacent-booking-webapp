<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VendorOrderSeeder extends Seeder
{
    public function run(): void
    {
        // Create a small customer base (customers are attributed to orders)
        $customerData = [
            [
                'first_name' => 'Chinelo',
                'last_name' => 'Okafor',
                'phone' => '08030000001',
                'shop_location' => 'Lekki',
                'shop_notes' => 'Fast delivery please',
            ],
            [
                'first_name' => 'Ayo',
                'last_name' => 'Bello',
                'phone' => '08030000002',
                'shop_location' => 'Ikeja',
                'shop_notes' => null,
            ],
            [
                'first_name' => 'Zainab',
                'last_name' => 'Mohammed',
                'phone' => '08030000003',
                'shop_location' => 'Abuja (Wuse)',
                'shop_notes' => null,
            ],
        ];

        $customers = [];
        foreach ($customerData as $idx => $c) {
            $user = User::firstOrCreate(
                ['email' => 'customer_seed_' . ($idx + 1) . '@example.com'],
                [
                    'name' => $c['first_name'] . ' ' . ($c['last_name'] ?? ''),
                    'email' => 'customer_seed_' . ($idx + 1) . '@example.com',
                    'password' => Hash::make('customer123'),
                    'email_verified_at' => now(),
                ]
            );

            Profile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'full_name' => $user->name,
                    'balance' => 0,
                ]
            );

            // Create customer record. We treat Customer->user_id as optional, but it works for our seed.
            $customer = Customer::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'first_name' => $c['first_name'],
                    'last_name' => $c['last_name'],
                    'phone' => $c['phone'],
                    'shop_location' => $c['shop_location'],
                    'shop_notes' => $c['shop_notes'],
                ]
            );

            $customers[] = $customer;
        }

        // Pick products for order items (ensure ProductSeeder has run, but make this robust)
        $products = Product::query()->where('is_active', true)->get();
        if ($products->isEmpty()) {
            // Nothing to seed orders with.
            return;
        }

        // Orders: paid, pending verification (manual), failed
        $orderScenarios = [
            ['key' => 'paid_1', 'payment_method' => 'flutterwave', 'payment_status' => Order::PAYMENT_PAID, 'status' => Order::STATUS_PAID],
            ['key' => 'paid_2', 'payment_method' => 'flutterwave', 'payment_status' => Order::PAYMENT_PAID, 'status' => Order::STATUS_COMPLETED],
            ['key' => 'pending_verify_1', 'payment_method' => 'bank_transfer', 'payment_status' => Order::PAYMENT_PENDING_VERIFICATION, 'status' => Order::STATUS_PENDING],
            ['key' => 'pending_verify_2', 'payment_method' => 'cash_on_delivery', 'payment_status' => Order::PAYMENT_PENDING_VERIFICATION, 'status' => Order::STATUS_PROCESSING],
            ['key' => 'failed_1', 'payment_method' => 'flutterwave', 'payment_status' => Order::PAYMENT_FAILED, 'status' => Order::STATUS_PENDING],
        ];

        foreach ($orderScenarios as $scenarioIdx => $s) {
            $buyer = $customers[$scenarioIdx % count($customers)];

            $billingEmail = $buyer->user?->email ?? ('buyer_seed_' . ($scenarioIdx + 1) . '@example.com');
            $billingName = trim(($buyer->first_name ?? '') . ' ' . ($buyer->last_name ?? '')) ?: 'Buyer ' . ($scenarioIdx + 1);
            $billingPhone = $buyer->phone ?? '0803000000' . ($scenarioIdx + 1);

            $buyerUserId = $buyer->user_id ?? $buyer->user?->id;


            // Build deterministic amounts from order items.
            $chosen = $products->random(min(3, max(1, $products->count())))->values()->all();
            $items = [];
            $subtotal = 0.0;
            foreach (array_slice($chosen, 0, 3) as $p) {
                $qty = random_int(1, 4);
                $unit = (float) $p->sale_price;
                if ($unit <= 0) {
                    $unit = (float) $p->price;
                }
                $line = round($unit * $qty, 2);
                $items[] = [
                    'product_id' => $p->id,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'line_total' => $line,
                ];
                $subtotal += $line;
            }

            $taxRate = (float) config('ecommerce.tax_rate', 0.0);
            $tax = round($subtotal * $taxRate, 2);

            $shippingCost = 0.0; // Shipping is free for all orders.

            $total = round($subtotal + $tax + $shippingCost, 2);

            $uniqueKey = 'vendor_order_' . $s['key'];
            // Idempotency key: use flutterwave_tx_ref for online orders and payment_reference for manual.
            $flutterwaveTxRef = $s['payment_method'] === 'flutterwave' ? ('ordseed_' . $uniqueKey) : null;
            $paymentReference = $s['payment_method'] !== 'flutterwave' ? ('ref_' . $uniqueKey) : null;

            $order = Order::query()->when($flutterwaveTxRef, fn ($q) => $q->where('flutterwave_tx_ref', $flutterwaveTxRef))
                ->when(!$flutterwaveTxRef, fn ($q) => $q->where('payment_reference', $paymentReference))
                ->first();

            if (! $order) {
                $order = Order::create([
                    'user_id' => $buyerUserId,
                    // customer_id column may not exist in all environments; omit if absent.
                    'status' => $s['status'],

                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'shipping_cost' => $shippingCost,
                    'total' => $total,
                    'currency' => config('ecommerce.currency', 'NGN'),
                    'shipping_address' => 'No. 1, Demo address',
                    'billing_name' => $billingName,
                    'billing_email' => $billingEmail,
                    'billing_phone' => $billingPhone,
                    'payment_method' => $s['payment_method'],
                    'payment_status' => $s['payment_status'],
                    'flutterwave_tx_ref' => $flutterwaveTxRef,
                    'flutterwave_transaction_id' => $flutterwaveTxRef ? ('tx_' . Str::random(10)) : null,
                    'payment_receipt' => null,
                    'payment_reference' => $paymentReference,
                    'notes' => 'Seed order ' . $s['key'],
                    'amount_paid' => $s['payment_status'] === Order::PAYMENT_PAID ? $total : ($s['payment_status'] === Order::PAYMENT_PENDING_VERIFICATION ? $total : null),
                    'paid_at' => $s['payment_status'] === Order::PAYMENT_PAID ? now()->subDays(10 + $scenarioIdx) : null,
                    'payment_verified_by' => $s['payment_status'] === Order::PAYMENT_PAID ? null : null,
                    'payment_verified_at' => $s['payment_status'] === Order::PAYMENT_PAID ? now()->subDays(9 + $scenarioIdx) : null,
                    'payment_rejection_reason' => $s['payment_status'] === Order::PAYMENT_FAILED ? 'Payment verification failed (seed)' : null,
                ]);
            }

            // Sync order items for idempotency: delete and recreate for this seed order key.
            $order->items()->delete();
            foreach ($items as $it) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $it['product_id'],
                    'quantity' => $it['quantity'],
                    'unit_price' => $it['unit_price'],
                    'line_total' => $it['line_total'],
                ]);
            }
        }
    }
}


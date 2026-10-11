<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentTransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Seed wallet-like transactions based on orders payment states.
        // This keeps the existing frontend transactions UI working without schema changes.

        $users = User::query()->get();

        foreach ($users as $user) {
            // Orders seeded in VendorOrderSeeder attach user_id to the buyer.
            $orders = Order::query()
                ->where('user_id', $user->id)
                ->whereIn('payment_status', [
                    Order::PAYMENT_PAID,
                    Order::PAYMENT_PENDING_VERIFICATION,
                    Order::PAYMENT_FAILED,
                ])
                ->get();

            foreach ($orders as $order) {
                // Paid => credit; pending_verification/failed => debit
                $type = $order->payment_status === Order::PAYMENT_PAID ? 'credit' : 'debit';

                $reference = 'order_pay_' . $order->id . '_' . $order->payment_status;

                $amount = (float) ($order->amount_paid ?? $order->total ?? 0);
                if ($amount <= 0) {
                    $amount = (float) ($order->total ?? 0);
                }

                WalletTransaction::firstOrCreate(
                    ['user_id' => $user->id, 'reference' => $reference],
                    [
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'type' => $type,
                        'description' => 'Order payment seed for order #' . $order->id,
                        'reference' => $reference,
                    ]
                );
            }
        }
    }
}





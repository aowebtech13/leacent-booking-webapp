<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Seeder;


class LedgerSeeder extends Seeder
{
    public function run(): void
    {
        $orders = Order::query()->with(['user'])->get();

        foreach ($orders as $order) {
            $type = $order->payment_method === 'flutterwave'
                ? Transaction::TYPE_ORDER_PAYMENT
                : Transaction::TYPE_MANUAL_PAYMENT;

            $status = match ($order->payment_status) {
                Order::PAYMENT_PAID => Transaction::STATUS_COMPLETED,
                Order::PAYMENT_PENDING_VERIFICATION => Transaction::STATUS_PENDING,
                Order::PAYMENT_FAILED => Transaction::STATUS_REJECTED,
                Order::PAYMENT_REFUNDED => Transaction::STATUS_COMPLETED,
                default => Transaction::STATUS_PENDING,
            };

            // Avoid duplicate ledger entries for the same order/type.
            $exists = Transaction::query()
                ->where('order_id', $order->id)
                ->where('type', $type)
                ->exists();

            if ($exists) {
                continue;
            }

            Transaction::create([
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'type' => $type,
                'amount' => $order->amount_paid ?? $order->total,
                'currency' => $order->currency,
                'payment_method' => $order->payment_method,
                'status' => $status,
                'reference' => $order->payment_reference ?? $order->flutterwave_tx_ref,
                'description' => 'Order #' . $order->id . ' payment (backfilled)',
                'meta' => [
                    'billing_name' => $order->billing_name,
                    'billing_email' => $order->billing_email,
                    'backfilled' => true,
                ],
                'verified_by' => $order->payment_verified_by,
                'verified_at' => $order->payment_verified_at,
                'rejection_reason' => $order->payment_rejection_reason,
            ]);
        }
    }
}

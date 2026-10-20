<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PaymentVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * GET /api/payment/methods
     * Return available payment methods with labels and descriptions.
     */
    public function methods(Request $request)
    {
        $bank = config('ecommerce.bank_transfer');

        $methods = [
            [
                'id' => 'bank_transfer',
                'label' => 'Pay Little By Little',
                'description' => 'Pay in installments via direct bank transfer. Upload your payment receipt for verification.',
                'icon' => 'bank',
                'features' => [
                    'Flexible installment payments',
                    'Bank transfer verification',
                    'Payment tracking',
                ],
                'bank_account_number' => $bank['account_number'],
                'bank_account_name' => $bank['account_name'],
                'bank_name' => $bank['bank_name'],
            ],
            [
                'id' => 'cash_on_delivery',
                'label' => 'Pay All At Once',
                'description' => 'Pay the full amount when your order is delivered. No upfront payment required.',
                'icon' => 'cash',
                'features' => [
                    'Pay on delivery',
                    'No upfront payment',
                    'Inspect before paying',
                ],
                'bank_account_number' => $bank['account_number'],
                'bank_account_name' => $bank['account_name'],
                'bank_name' => $bank['bank_name'],
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $methods,
        ]);
    }

    /**
     * GET /api/payment/order/{id}
     * Return order details for the payment page.
     */
    public function order(Request $request, int $id)
    {
        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->with(['items.product', 'customer'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * POST /api/payment/upload-receipt
     * Upload a manual payment receipt for verification.
     * Accepts an optional order_id to link the receipt to an existing order.
     */
    public function uploadReceipt(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'receipt' => 'required|file|image|max:5120', // up to 5MB
            'order_id' => 'nullable|integer|exists:orders,id',
            'payment_reference' => 'nullable|string|max:255',
            'amount_paid' => 'required|numeric|min:0|max:999999999999',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $order = null;
        if ($request->filled('order_id')) {
            $order = \App\Models\Order::query()
                ->where('user_id', $request->user()->id)
                ->findOrFail($request->get('order_id'));

            if ($order->isPaid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This order has already been paid',
                ], 422);
            }

            if ($order->payment_method === 'flutterwave') {
                return response()->json([
                    'success' => false,
                    'message' => 'Online payments are verified automatically',
                ], 422);
            }

            if ($order->isPendingVerification()) {
                return response()->json([
                    'success' => false,
                    'message' => 'A payment receipt is already awaiting verification for this order',
                ], 422);
            }

            // Replace any previously uploaded receipt.
            if ($order->payment_receipt) {
                Storage::disk('public')->delete($order->payment_receipt);
            }

            $path = $request->file('receipt')->store('receipts', 'public');

            $order->payment_receipt = $path;
            $order->payment_reference = $request->get('payment_reference');
            $order->amount_paid = $request->get('amount_paid');
            $order->paid_at = $request->get('paid_at');
            $order->payment_status = \App\Models\Order::PAYMENT_PENDING_VERIFICATION;
            $order->payment_rejection_reason = null;

            if ($request->has('notes')) {
                $order->notes = $request->get('notes');
            }

            $order->save();

            // Record the manual payment submission in the Ledger.
            Transaction::findOrCreateForOrder(
                $order,
                Transaction::TYPE_MANUAL_PAYMENT,
                Transaction::STATUS_PENDING
            );

            $order->user->notify(new \App\Notifications\ManualPaymentSubmittedNotification(
                orderId: $order->id,
                amount: $order->amount_paid ?? $order->total,
                currency: $order->currency,
            ));

            return response()->json([
                'success' => true,
                'data' => $order->load(['items.product']),
                'message' => 'Payment receipt submitted successfully. Awaiting admin verification.',
            ], 201);
        }

        // Standalone receipt upload (no order linked).
        $path = $request->file('receipt')->store('receipts', 'public');

        return response()->json([
            'success' => true,
            'data' => [
                'receipt_path' => $path,
                'receipt_url' => Storage::disk('public')->url($path),
                'payment_reference' => $request->get('payment_reference'),
                'amount_paid' => $request->get('amount_paid'),
                'paid_at' => $request->get('paid_at'),
                'notes' => $request->get('notes'),
            ],
            'message' => 'Payment receipt uploaded successfully.',
        ], 201);
    }
}

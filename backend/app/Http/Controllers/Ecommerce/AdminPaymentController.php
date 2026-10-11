<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\ManualPaymentRejectedNotification;
use App\Notifications\ManualPaymentVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminPaymentController
{
    use RestoresStockOnRejection;
   
    public function index(Request $request)
    {
        $query = Order::query()->with(['user', 'items.product', 'verifier']);

        $paymentStatus = $request->get('payment_status', Order::PAYMENT_PENDING_VERIFICATION);
        $query->paymentStatus($paymentStatus);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('billing_name', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%")
                    ->orWhere('payment_reference', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($from = $request->get('date_from')) {
            $query->whereDate('paid_at', '>=', $from);
        }
        if ($to = $request->get('date_to')) {
            $query->whereDate('paid_at', '<=', $to);
        }

        $payments = $query->orderBy('updated_at', 'desc')
            ->paginate((int) $request->get('per_page', 15));

        // Expose a direct, viewable URL for the uploaded receipt so the admin
        // UI can render it inline (image/PDF) without downloading the binary.
        $payments->getCollection()->each->append('receiptUrl');

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

   
    public function show(Request $request, int $id)
    {
        $order = Order::query()
            ->with(['user', 'items.product', 'verifier'])
            ->findOrFail($id);

        // Expose a direct, viewable URL for the uploaded receipt so the admin
        // UI can render it inline (image/PDF) without downloading the binary.
        $order->append('receiptUrl');

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

   
    public function receipt(Request $request, int $id)
    {
        $order = Order::query()->findOrFail($id);

        if (! $order->payment_receipt || ! Storage::disk('public')->exists($order->payment_receipt)) {
            return response()->json([
                'success' => false,
                'message' => 'Receipt not found',
            ], 404);
        }

        return response()->file(Storage::disk('public')->path($order->payment_receipt));
    }

   
    public function verify(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $order = Order::query()->with(['items.product'])->findOrFail($id);

        if ($order->isPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Payment has already been verified',
            ], 422);
        }

        if (! $order->isPendingVerification()) {
            return response()->json([
                'success' => false,
                'message' => 'There is no pending payment to verify for this order',
            ], 422);
        }

        $admin = $request->user();
        $order->markVerified($admin->id, $request->get('notes'));

        // Keep the Ledger in sync with the admin's verification.
        Transaction::findOrCreateForOrder(
            $order,
            Transaction::TYPE_MANUAL_PAYMENT,
            Transaction::STATUS_PENDING
        )->settle(Transaction::STATUS_ACCEPTED, $admin->id);

        $order->user->notify(new ManualPaymentVerifiedNotification(
            orderId: $order->id,
            amount: $order->amount_paid ?? $order->total,
            currency: $order->currency,
        ));

        return response()->json([
            'success' => true,
            'data' => $order->load(['items.product', 'verifier']),
            'message' => 'Payment verified successfully',
        ]);
    }

   
    public function reject(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:2000',
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $order = Order::query()->with(['items.product'])->findOrFail($id);

        if ($order->payment_status === Order::PAYMENT_FAILED) {
            return response()->json([
                'success' => false,
                'message' => 'Payment has already been rejected',
            ], 422);
        }

        if (! $order->isPendingVerification()) {
            return response()->json([
                'success' => false,
                'message' => 'There is no pending payment to reject for this order',
            ], 422);
        }

        $admin = $request->user();
        $order->markRejected(
            $admin->id,
            $request->get('rejection_reason'),
            $request->get('notes')
        );

        // Restore reserved stock so the product is available again.
        $this->restoreStock($order);

        // Keep the Ledger in sync with the admin's rejection.
        Transaction::findOrCreateForOrder(
            $order,
            Transaction::TYPE_MANUAL_PAYMENT,
            Transaction::STATUS_PENDING
        )->settle(Transaction::STATUS_REJECTED, $admin->id, $request->get('rejection_reason'));

        $order->user->notify(new ManualPaymentRejectedNotification(
            orderId: $order->id,
            reason: $request->get('rejection_reason'),
        ));

        return response()->json([
            'success' => true,
            'data' => $order->load(['items.product', 'verifier']),
            'message' => 'Payment rejected',
        ]);
    }
}

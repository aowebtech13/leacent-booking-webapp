<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\ManualPaymentRejectedNotification;
use App\Notifications\ManualPaymentVerifiedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait RestoresStockOnRejection
{
    protected function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->increment('stock', $item->quantity);
            }
        }
    }
}


class TransactionController extends Controller
{
    use RestoresStockOnRejection;
    /**
     * GET /transactions
     * List the ledger with filtering and search.
     */
    public function index(Request $request)
    {
        $query = Transaction::query()->with(['user', 'order.items.product', 'verifier']);

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        if ($method = $request->get('payment_method')) {
            $query->where('payment_method', $method);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('id', $search)
                    ->orWhereHas('order', function ($o) use ($search) {
                        $o->where('billing_name', 'like', "%{$search}%")
                            ->orWhere('billing_email', 'like', "%{$search}%")
                            ->orWhere('payment_reference', 'like', "%{$search}%")
                            ->orWhere('id', $search);
                    })
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($from = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $transactions = $query->orderBy('created_at', 'desc')
            ->paginate((int) $request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ]);
    }

   
    public function show(Request $request, int $id)
    {
        $transaction = Transaction::query()
            ->with(['user', 'order.items.product', 'order.verifier', 'verifier'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $transaction,
        ]);
    }

    
    public function accept(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $transaction = Transaction::query()
            ->with(['order.items.product', 'user'])
            ->findOrFail($id);

        if ($transaction->isAccepted()) {
            return response()->json([
                'success' => false,
                'message' => 'This transaction has already been accepted',
            ], 422);
        }

        if ($transaction->isRejected()) {
            return response()->json([
                'success' => false,
                'message' => 'This transaction was rejected and cannot be accepted',
            ], 422);
        }

        $admin = $request->user();

        $transaction->settle(Transaction::STATUS_ACCEPTED, $admin->id);

        $order = $transaction->order;
        if ($order && ! $order->isPaid()) {
            $order->markVerified($admin->id, $request->get('notes'));
        }

        $this->notifyAccepted($transaction);

        return response()->json([
            'success' => true,
            'data' => $transaction->load(['user', 'order.items.product', 'verifier']),
            'message' => 'Transaction accepted',
        ]);
    }

   
    public function reject(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:2000',
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $transaction = Transaction::query()
            ->with(['order.items.product', 'user'])
            ->findOrFail($id);

        if ($transaction->isRejected()) {
            return response()->json([
                'success' => false,
                'message' => 'This transaction has already been rejected',
            ], 422);
        }

        if ($transaction->isAccepted()) {
            return response()->json([
                'success' => false,
                'message' => 'This transaction was already accepted and cannot be rejected',
            ], 422);
        }

        $admin = $request->user();
        $reason = $request->get('rejection_reason');

        $transaction->settle(Transaction::STATUS_REJECTED, $admin->id, $reason);

        $order = $transaction->order;
        if ($order && $order->payment_status !== Order::PAYMENT_FAILED) {
            $order->markRejected($admin->id, $reason, $request->get('notes'));

            // Restore reserved stock so the product is available again.
            $this->restoreStock($order);
        }

        $this->notifyRejected($transaction, $reason);

        return response()->json([
            'success' => true,
            'data' => $transaction->load(['user', 'order.items.product', 'verifier']),
            'message' => 'Transaction rejected',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */
    protected function notifyAccepted(Transaction $transaction): void
    {
        $order = $transaction->order;
        $user = $transaction->user;

        if ($user) {
            $user->notify(new ManualPaymentVerifiedNotification(
                orderId: $order?->id ?? $transaction->id,
                amount: $transaction->amount,
                currency: $transaction->currency,
            ));
        }
    }

    protected function notifyRejected(Transaction $transaction, string $reason): void
    {
        $order = $transaction->order;
        $user = $transaction->user;

        if ($user) {
            $user->notify(new ManualPaymentRejectedNotification(
                orderId: $order?->id ?? $transaction->id,
                reason: $reason,
            ));
        }
    }
}

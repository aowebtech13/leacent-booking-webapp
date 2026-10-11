<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminOrderController
{
    /**
     * GET /admin/orders
     * List all purchases submitted to the admin area, with filtering.
     */
    public function index(Request $request)
    {
        $query = Order::query()->with(['user', 'items.product']);

        $query->status($request->get('status'))
            ->paymentStatus($request->get('payment_status'));

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('billing_name', 'like', "%{$search}%")
                    ->orWhere('billing_email', 'like', "%{$search}%")
                    ->orWhere('id', $search)
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

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate((int) $request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

   
    public function stats(Request $request)
    {
        $base = Order::query();

        if ($from = $request->get('date_from')) {
            $base->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->get('date_to')) {
            $base->whereDate('created_at', '<=', $to);
        }

        $byStatus = (clone $base)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $revenue = (clone $base)
            ->where('payment_status', Order::PAYMENT_PAID)
            ->sum('total');

        $totalOrders = (clone $base)->count();
        $pendingOrders = (clone $base)->where('status', Order::STATUS_PENDING)->count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_orders' => $totalOrders,
                'pending_orders' => $pendingOrders,
                'revenue' => (float) $revenue,
                'by_status' => $byStatus,
                'currency' => Config::get('ecommerce.currency', 'NGN'),
            ],
        ]);
    }

   
    public function show(Request $request, int $id)
    {
        $order = Order::query()
            ->with(['user', 'items.product'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    
    public function updateStatus(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:' . implode(',', Order::validStatuses()),
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $order = Order::query()->with(['items.product'])->findOrFail($id);
        $newStatus = $request->get('status');

        $wasPaid = $order->isPaid();
        $wasCancelled = $order->isCancelled();

        $order->status = $newStatus;

        if ($newStatus === Order::STATUS_PAID && ! $wasPaid) {
            $order->payment_status = Order::PAYMENT_PAID;
        }

        if ($request->has('notes')) {
            $order->notes = $request->get('notes');
        }

        $order->save();

        // Keep the Ledger in sync when an admin marks an order as paid.
        if ($newStatus === Order::STATUS_PAID && ! $wasPaid) {
            $type = $order->payment_method === 'flutterwave'
                ? Transaction::TYPE_ORDER_PAYMENT
                : Transaction::TYPE_MANUAL_PAYMENT;

            Transaction::findOrCreateForOrder(
                $order,
                $type,
                Transaction::STATUS_PENDING
            )->settle(Transaction::STATUS_COMPLETED, $request->user()->id);
        }

        // Restore reserved stock when an order is cancelled.
        if ($newStatus === Order::STATUS_CANCELLED && ! $wasCancelled) {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                }
            }
        }

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order status updated',
        ]);
    }
}

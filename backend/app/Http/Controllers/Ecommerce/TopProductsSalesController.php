<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopProductsSalesController
{
    public function __invoke(Request $request)
    {
        $range = $request->get('range', 'week');
        $limit = (int) $request->get('limit', 5);
        $limit = $limit > 0 ? min($limit, 20) : 5;

        [$start, $end] = $this->rangeWindow($range);

        // Paid orders in the date window. We prefer paid_at if present.
        // Fallback to created_at when paid_at is null.
        $base = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.payment_status', 'paid')
            ->where('products.is_active', true);

        if ($start !== null && $end !== null) {
            $base->where(function ($q) use ($start, $end) {
                $q->whereBetween('orders.paid_at', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->whereNull('orders.paid_at')
                            ->whereBetween('orders.created_at', [$start, $end]);
                    });
            });
        }

        // Sum sales by product.
        // Using order_items.line_total to attribute sales per product.
        $rows = $base
            ->select([
                'products.id as product_id',
                'products.name as product_name',
                'products.slug as product_slug',
                'products.sale_price',
                'products.price',
                DB::raw('SUM(order_items.line_total) as sales'),
                DB::raw('SUM(order_items.quantity) as units_sold'),
            ])
            ->groupBy('products.id', 'products.name', 'products.slug', 'products.sale_price', 'products.price')
            ->orderByDesc('sales')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rows,
            'meta' => [
                'range' => $range,
                'limit' => $limit,
            ],
        ]);
    }

    private function rangeWindow(string $range): array
    {
        $now = now();

        return match (strtolower(trim($range))) {
            'week', 'weekly' => [
                $now->copy()->startOfWeek(),
                $now->copy()->endOfWeek(),
            ],
            'month', 'monthly' => [
                $now->copy()->startOfMonth(),
                $now->copy()->endOfMonth(),
            ],
            'year', 'yearly' => [
                $now->copy()->startOfYear(),
                $now->copy()->endOfYear(),
            ],
            '6 month', '6_month', '6months', '6_months', 'six_months' => [
                $now->copy()->subMonthsNoOverflow(6)->startOfDay(),
                $now->copy()->endOfDay(),
            ],
            default => [
                $now->copy()->startOfWeek(),
                $now->copy()->endOfWeek(),
            ],
        };
    }
}

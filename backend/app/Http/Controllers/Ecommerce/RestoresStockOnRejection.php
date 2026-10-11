<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Order;

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

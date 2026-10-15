<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Order::with(['items.product'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($order) {
                $customerName = $order->billing_name ?? 'Guest';

                $statusLabel = ucfirst($order->status);
                $statusClass = 'badge-light-info';

                switch ($order->status) {
                    case Order::STATUS_COMPLETED:
                    case Order::STATUS_PAID:
                        $statusLabel = 'Paid';
                        $statusClass = 'badge-light-success';
                        break;
                    case Order::STATUS_PROCESSING:
                    case Order::STATUS_SHIPPED:
                        $statusLabel = 'In Progress';
                        $statusClass = 'badge-light-warning';
                        break;
                    case Order::STATUS_CANCELLED:
                        $statusLabel = 'Canceled';
                        $statusClass = 'badge-light-danger';
                        break;
                    case Order::STATUS_PENDING:
                    default:
                        $statusLabel = 'Pending';
                        $statusClass = 'badge-light-info';
                        break;
                }

                return (object) [
                    'id' => $order->id,
                    'invoice_number' => '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'date' => $order->created_at->format('d M, Y'),
                    'customer_name' => $customerName,
                    'total' => (float) $order->total,
                    'status' => $statusLabel,
                    'status_class' => $statusClass,
                    'payment_status' => ucfirst(str_replace('_', ' ', $order->payment_status)),
                ];
            });

        return view('ecommerce.invoices.invoice_1', compact('invoices'));
    }

    public function show(int $id)
    {
        $order = Order::with(['items.product.images'])
            ->findOrFail($id);

        $customerName = $order->billing_name ?? 'Guest';

        if (empty(trim($customerName))) {
            $customerName = 'Guest';
        }

        $customerEmail = $order->billing_email ?? 'N/A';
        $customerPhone = $order->billing_phone ?? 'N/A';
        $customerAddress = $order->shipping_address ?? 'N/A';

        $statusLabel = ucfirst($order->status);
        $statusClass = 'badge-light-info';

        switch ($order->status) {
            case Order::STATUS_COMPLETED:
            case Order::STATUS_PAID:
                $statusLabel = 'Paid';
                $statusClass = 'badge-light-success';
                break;
            case Order::STATUS_PROCESSING:
            case Order::STATUS_SHIPPED:
                $statusLabel = 'In Progress';
                $statusClass = 'badge-light-warning';
                break;
            case Order::STATUS_CANCELLED:
                $statusLabel = 'Canceled';
                $statusClass = 'badge-light-danger';
                break;
            case Order::STATUS_PENDING:
            default:
                $statusLabel = 'Pending';
                $statusClass = 'badge-light-info';
                break;
        }

        $items = $order->items->map(function ($item) {
            $product = $item->product;
            $price = (float) ($product?->sale_price ?: $product?->price);
            $lineTotal = (float) $item->line_total;

            return (object) [
                'name' => $product?->name ?? 'N/A',
                'rate' => $price,
                'quantity' => (int) $item->quantity,
                'line_total' => $lineTotal,
            ];
        });

        $subtotal = (float) $order->subtotal;
        $tax = (float) $order->tax;
        $total = (float) $order->total;

        return response()->json([
            'id' => $order->id,
            'invoice_number' => '#' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'date' => $order->created_at->format('d M, Y'),
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'customer_phone' => $customerPhone,
            'customer_address' => $customerAddress,
            'status' => $statusLabel,
            'status_class' => $statusClass,
            'payment_status' => ucfirst(str_replace('_', ' ', $order->payment_status)),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'items' => $items,
        ]);
    }
}

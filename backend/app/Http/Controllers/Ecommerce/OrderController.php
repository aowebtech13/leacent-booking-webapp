<?php

namespace App\Http\Controllers\Ecommerce;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\OrderPlacedNotification;
use App\Notifications\PaymentFailedNotification;
use App\Notifications\PaymentVerifiedNotification;
use App\Notifications\ManualPaymentSubmittedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OrderController
{
    use RestoresStockOnRejection;
    private const FLUTTERWAVE_BASE_URL = 'https://api.flutterwave.com/v3';

    /**
     * GET /checkout
     * Returns a computed summary of the current cart for the checkout page.
     */
    public function checkout(Request $request)
    {
        $cart = Cart::query()
            ->where('user_id', $request->user()->id)
            ->with(['items.product'])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty',
                'data' => [
                    'items' => [],
                    'subtotal' => 0,
                    'tax' => 0,
                    'shipping_cost' => 0,
                    'total' => 0,
                    'shipping_methods' => $this->shippingMethods(),
                    'payment_methods' => Config::get('ecommerce.payment_methods', []),
                ],
            ], 422);
        }

        $summary = $this->buildSummary($cart->items);

        return response()->json([
            'success' => true,
            'data' => array_merge($summary, [
                'shipping_methods' => $this->shippingMethods(),
                'payment_methods' => Config::get('ecommerce.payment_methods', []),
                'currency' => Config::get('ecommerce.currency', 'NGN'),
            ]),
        ]);
    }

    /**
     * GET /orders
     * List the authenticated user's purchases.
     */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->where('user_id', $request->user()->id)
            ->with(['customer', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate((int) $request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * GET /orders/{id}
     * Show a single purchase belonging to the user.
     */
    public function show(Request $request, int $id)
    {
        $order = Order::query()
            ->where('user_id', $request->user()->id)
            ->with(['customer', 'items.product'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * POST /orders
     * Place an order from the cart (checkout submission).
     */
    public function store(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'customer_id' => [
                'nullable',
                'integer',
                'exists:customers,id',
            ],
            // Keep strict-ish validation, but allow frontend to send either:
            // - shipping_address (preferred)
            // - street/address_line (fallback)
            'shipping_address' => 'nullable|string|min:5',
            'street' => 'nullable|string|min:2',
            'address_line' => 'nullable|string|min:2',
            'billing_name' => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
            'billing_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|in:' . implode(',', Config::get('ecommerce.payment_methods', [])),
            'shipping_method' => 'nullable|string|in:' . implode(',', array_keys(Config::get('ecommerce.shipping_methods', []))),
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        $shippingAddress = trim((string) ($request->get('shipping_address')
            ?? $request->get('street')
            ?? $request->get('address_line')
            ?? ''));

        if (! $shippingAddress) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping address is required',
            ], 422);
        }

        $validator->validate();

        // Ensure the attributed customer belongs to the authenticated user.
        $customerId = $request->input('customer_id');
        if ($customerId) {
            $ownsCustomer = Customer::query()
                ->where('id', $customerId)
                ->where('user_id', $user->id)
                ->exists();

            if (! $ownsCustomer) {
                return response()->json([
                    'success' => false,
                    'message' => 'The selected customer does not belong to you.',
                ], 422);
            }
        }

        $paymentMethod = $request->get('payment_method');

        return DB::transaction(function () use ($request, $user, $paymentMethod, $customerId) {
            $cart = Cart::query()
                ->where('user_id', $user->id)
                ->with(['items.product'])
                ->first();

            if (! $cart || $cart->items->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty',
                ], 422);
            }

            // Validate stock for every item before committing.
            foreach ($cart->items as $item) {
                $product = $item->product;
                if (! $product || ! $product->is_active) {
                    return response()->json([
                        'success' => false,
                        'message' => 'A product in your cart is no longer available',
                    ], 422);
                }
                if ($product->stock > 0 && $item->quantity > $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$product->name}",
                    ], 422);
                }
            }

            $summary = $this->buildSummary($cart->items, $request->get('shipping_method'));

            $order = Order::create([
                'user_id' => $user->id,
                'customer_id' => $customerId ?: null,
                'status' => Order::STATUS_PENDING,
                'subtotal' => $summary['subtotal'],
                'tax' => $summary['tax'],
                'shipping_cost' => $summary['shipping_cost'],
                'total' => $summary['total'],
                'currency' => Config::get('ecommerce.currency', 'NGN'),
                'shipping_address' => $request->get('shipping_address'),
                'billing_name' => $request->get('billing_name', $user->profile->full_name ?? $user->name ?? null),
                'billing_email' => $request->get('billing_email', $user->email),
                'billing_phone' => $request->get('billing_phone'),
                'payment_method' => $paymentMethod,
                'payment_status' => Order::PAYMENT_UNPAID,
                'notes' => $request->get('notes'),
            ]);

            $user->notify(new OrderPlacedNotification(
                orderId: $order->id,
                total: $order->total,
                currency: $order->currency,
                paymentMethod: $paymentMethod,
            ));

            foreach ($cart->items as $item) {
                $price = (float) $item->unit_price;
                $qty = (int) $item->quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'line_total' => $price * $qty,
                ]);
            }

            // Reserve stock immediately to prevent overselling.
            $order->load('items.product');
            $this->decrementStock($order);

            // Record the order placement in the Ledger so there is a complete
            // audit trail from the moment the order exists.
            $type = $paymentMethod === 'flutterwave'
                ? Transaction::TYPE_ORDER_PAYMENT
                : Transaction::TYPE_MANUAL_PAYMENT;

            Transaction::findOrCreateForOrder(
                $order,
                $type,
                Transaction::STATUS_PENDING
            );

            // Clear the cart now that it has been converted into an order.
            $cart->items()->delete();

            // For offline payment methods the order waits for admin confirmation.
            if ($paymentMethod === 'flutterwave') {
                $payment = $this->initializeFlutterwave($order, $user);

                if (! $payment['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Could not initialize payment',
                        'details' => $payment['message'] ?? 'Payment gateway error',
                    ], 502);
                }

                $order->flutterwave_tx_ref = $payment['tx_ref'];
                $order->save();

                return response()->json([
                    'success' => true,
                    'data' => $order->load(['items.product']),
                    'payment' => [
                        'tx_ref' => $payment['tx_ref'],
                        'payment_link' => $payment['payment_link'],
                        'checkout_url' => $payment['payment_link'],
                        'link' => $payment['payment_link'],
                    ],
                    'message' => 'Order created. Complete payment to confirm.',
                ], 201);
            }

            return response()->json([
                'success' => true,
                'data' => $order->load(['items.product']),
                'message' => 'Order placed. Awaiting payment confirmation.',
            ], 201);
        });
    }

    /**
     * POST /orders/guest
     * Place an order as a guest (no authentication required).
     * Accepts cart items directly in the payload since there is no
     * authenticated user cart to read from.
     */
    public function storeGuest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address' => 'nullable|string|min:5',
            'street' => 'nullable|string|min:2',
            'address_line' => 'nullable|string|min:2',
            'billing_name' => 'nullable|string|max:255',
            'billing_email' => 'nullable|email|max:255',
            'billing_phone' => 'nullable|string|max:50',
            'payment_method' => 'required|in:' . implode(',', Config::get('ecommerce.payment_methods', [])),
            'shipping_method' => 'nullable|string|in:' . implode(',', array_keys(Config::get('ecommerce.shipping_methods', []))),
            'notes' => 'nullable|string|max:2000',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);
        $validator->validate();

        $shippingAddress = trim((string) ($request->get('shipping_address')
            ?? $request->get('street')
            ?? $request->get('address_line')
            ?? ''));

        if (! $shippingAddress) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping address is required',
            ], 422);
        }

        $paymentMethod = $request->get('payment_method');
        $items = $request->input('items');

        return DB::transaction(function () use ($request, $paymentMethod, $items, $shippingAddress) {
            // Validate stock for every item before committing.
            foreach ($items as $item) {
                $product = Product::query()->find($item['product_id']);
                if (! $product || ! $product->is_active) {
                    return response()->json([
                        'success' => false,
                        'message' => 'A product in your cart is no longer available',
                    ], 422);
                }
                if ($product->stock > 0 && $item['quantity'] > $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$product->name}",
                    ], 422);
                }
            }

            // Build a summary from the submitted items.
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += (float) $item['unit_price'] * (int) $item['quantity'];
            }

            $taxRate = (float) Config::get('ecommerce.tax_rate', 0);
            $tax = round($subtotal * $taxRate, 2);
            $shippingCost = 0; // Free shipping for all orders.
            $total = $subtotal + $tax + $shippingCost;

            $order = Order::create([
                'user_id' => null,
                'customer_id' => null,
                'status' => Order::STATUS_PENDING,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping_cost' => $shippingCost,
                'total' => $total,
                'currency' => Config::get('ecommerce.currency', 'NGN'),
                'shipping_address' => $shippingAddress,
                'billing_name' => $request->get('billing_name') ?: 'Guest',
                'billing_email' => $request->get('billing_email'),
                'billing_phone' => $request->get('billing_phone'),
                'payment_method' => $paymentMethod,
                'payment_status' => Order::PAYMENT_UNPAID,
                'notes' => $request->get('notes'),
            ]);

            foreach ($items as $item) {
                $price = (float) $item['unit_price'];
                $qty = (int) $item['quantity'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $qty,
                    'unit_price' => $price,
                    'line_total' => $price * $qty,
                ]);
            }

            // Reserve stock immediately to prevent overselling.
            $order->load('items.product');
            $this->decrementStock($order);

            // Record the order placement in the Ledger.
            $type = $paymentMethod === 'flutterwave'
                ? Transaction::TYPE_ORDER_PAYMENT
                : Transaction::TYPE_MANUAL_PAYMENT;

            Transaction::findOrCreateForOrder(
                $order,
                $type,
                Transaction::STATUS_PENDING
            );

            // For online payment methods, initialize the payment gateway.
            if ($paymentMethod === 'flutterwave') {
                $payment = $this->initializeFlutterwave($order, null);

                if (! $payment['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Could not initialize payment',
                        'details' => $payment['message'] ?? 'Payment gateway error',
                    ], 502);
                }

                $order->flutterwave_tx_ref = $payment['tx_ref'];
                $order->save();

                return response()->json([
                    'success' => true,
                    'data' => $order->load(['items.product']),
                    'payment' => [
                        'tx_ref' => $payment['tx_ref'],
                        'payment_link' => $payment['payment_link'],
                        'checkout_url' => $payment['payment_link'],
                        'link' => $payment['payment_link'],
                    ],
                    'message' => 'Order created. Complete payment to confirm.',
                ], 201);
            }

            return response()->json([
                'success' => true,
                'data' => $order->load(['items.product']),
                'message' => 'Order placed. Awaiting payment confirmation.',
            ], 201);
        });
    }

    /**
     * POST /orders/{id}/pay
     * Initialize (or re-initialize) Flutterwave payment for a pending order.
     */
    public function pay(Request $request, int $id)
    {
        $order = Order::query()
            ->where(function ($query) use ($request) {
                if ($request->user()) {
                    $query->where('user_id', $request->user()->id);
                } else {
                    $query->whereNull('user_id');
                }
            })
            ->findOrFail($id);

        if (! $order->canBePaid()) {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be paid online',
            ], 422);
        }

        $payment = $this->initializeFlutterwave($order, $request->user());

        if (! $payment['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Could not initialize payment',
                'details' => $payment['message'] ?? 'Payment gateway error',
            ], 502);
        }

        $order->flutterwave_tx_ref = $payment['tx_ref'];
        $order->save();

        return response()->json([
            'success' => true,
            'data' => $order,
            'payment' => [
                'tx_ref' => $payment['tx_ref'],
                'payment_link' => $payment['payment_link'],
                'checkout_url' => $payment['payment_link'],
                'link' => $payment['payment_link'],
            ],
        ]);
    }

    /**
     * POST /orders/{id}/manual-payment
     * Submit a manual/offline payment receipt for admin verification.
     * Used for non-gateway payment methods (e.g. bank transfer).
     */
    public function submitManualPayment(Request $request, int $id)
    {
        $order = Order::query()
            ->where(function ($query) use ($request) {
                if ($request->user()) {
                    $query->where('user_id', $request->user()->id);
                } else {
                    $query->whereNull('user_id');
                }
            })
            ->findOrFail($id);

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
                'message' => 'A payment receipt is already awaiting verification',
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'receipt' => 'required|file|image|max:5120', // up to 5MB
            'payment_reference' => 'nullable|string|max:255',
            'amount_paid' => 'required|numeric|min:0|max:999999999999',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string|max:2000',
        ]);
        $validator->validate();

        // Replace any previously uploaded receipt (e.g. a rejected submission).
        if ($order->payment_receipt) {
            Storage::disk('public')->delete($order->payment_receipt);
        }

        $path = $request->file('receipt')->store('receipts', 'public');

        $order->payment_receipt = $path;
        $order->payment_reference = $request->get('payment_reference');
        $order->amount_paid = $request->get('amount_paid');
        $order->paid_at = $request->get('paid_at');
        $order->payment_status = Order::PAYMENT_PENDING_VERIFICATION;
        $order->payment_rejection_reason = null;

        if ($request->has('notes')) {
            $order->notes = $request->get('notes');
        }

        $order->save();

        // Record the pending manual payment in the Ledger.
        Transaction::findOrCreateForOrder(
            $order,
            Transaction::TYPE_MANUAL_PAYMENT,
            Transaction::STATUS_PENDING
        );

        if ($order->user) {
            $order->user->notify(new ManualPaymentSubmittedNotification(
                orderId: $order->id,
                amount: $order->amount_paid ?? $order->total,
                currency: $order->currency,
            ));
        }

        return response()->json([
            'success' => true,
            'data' => $order->load(['items.product']),
            'message' => 'Payment receipt submitted. Awaiting admin verification.',
        ], 201);
    }

    /**
     * POST /orders/{id}/cancel
     * Cancel a pending order and restore stock.
     */
    public function cancel(Request $request, int $id)
    {
        $order = Order::query()
            ->where(function ($query) use ($request) {
                if ($request->user()) {
                    $query->where('user_id', $request->user()->id);
                } else {
                    $query->whereNull('user_id');
                }
            })
            ->with('items.product')
            ->findOrFail($id);

        if ($order->isPaid()) {
            return response()->json([
                'success' => false,
                'message' => 'Paid orders cannot be cancelled',
            ], 422);
        }

        if ($order->isCancelled()) {
            return response()->json([
                'success' => false,
                'message' => 'Order is already cancelled',
            ], 422);
        }

        $order->status = Order::STATUS_CANCELLED;
        $order->save();

        // Restore reserved stock.
        $this->restoreStock($order);

        return response()->json([
            'success' => true,
            'data' => $order->load(['items.product']),
            'message' => 'Order cancelled successfully',
        ]);
    }

    /**
     * POST /orders/verify
     * Verify a Flutterwave transaction and mark the order as paid.
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tx_ref' => 'required|string',
        ]);
        $validator->validate();

        $txRef = $request->get('tx_ref');
        $secretKey = config('services.flutterwave.secret_key');

        if (! $secretKey) {
            return response()->json([
                'success' => false,
                'message' => 'Payment gateway not configured',
            ], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
            ])->get(self::FLUTTERWAVE_BASE_URL . '/transactions/verify_by_reference', [
                'tx_ref' => $txRef,
            ]);
        } catch (\Throwable $e) {
            Log::error('Order payment verification HTTP error', [
                'tx_ref' => $txRef,
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to verify payment',
            ], 502);
        }

        $order = Order::query()->where('flutterwave_tx_ref', $txRef)->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found for this transaction',
            ], 404);
        }

        $data = $response->json();

        if ($response->successful()
            && ($data['status'] ?? null) === 'success'
            && ($data['data']['status'] ?? null) === 'successful') {

            if (! $order->isPaid()) {
                $order->markPaid((string) ($data['data']['id'] ?? ''));
            }

            // Record the successful online payment in the Ledger.
            Transaction::findOrCreateForOrder(
                $order,
                Transaction::TYPE_ORDER_PAYMENT,
                Transaction::STATUS_PENDING
            )->settle(Transaction::STATUS_COMPLETED);

            if ($order->user) {
                $order->user->notify(new PaymentVerifiedNotification(
                    orderId: $order->id,
                    amount: $order->total,
                    currency: $order->currency,
                    transactionId: (string) ($data['data']['id'] ?? ''),
                ));
            }

            return response()->json([
                'success' => true,
                'data' => $order->load(['items.product']),
                'message' => 'Payment verified successfully',
            ]);
        }

        if ($order->status === Order::STATUS_PENDING && $order->payment_status === Order::PAYMENT_UNPAID) {
            $order->payment_status = Order::PAYMENT_FAILED;
            $order->save();
        }

        // Record the failed online payment attempt in the Ledger.
        Transaction::findOrCreateForOrder(
            $order,
            Transaction::TYPE_ORDER_PAYMENT,
            Transaction::STATUS_PENDING
        )->settle(Transaction::STATUS_FAILED);

        if ($order->user) {
            $order->user->notify(new PaymentFailedNotification(
                orderId: $order->id,
                reason: 'Payment verification failed. Please try again or contact support.',
            ));
        }

        return response()->json([
            'success' => false,
            'message' => 'Payment verification failed',
        ], 400);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    private function buildSummary($items, ?string $shippingMethod = null): array
    {
        $subtotal = 0;
        foreach ($items as $item) {
            $subtotal += (float) $item->unit_price * (int) $item->quantity;
        }

        $taxRate = (float) Config::get('ecommerce.tax_rate', 0);
        $tax = round($subtotal * $taxRate, 2);

        $shippingCost = $this->shippingCost($subtotal, $shippingMethod);

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping_cost' => $shippingCost,
            'total' => $subtotal + $tax + $shippingCost,
        ];
    }

    private function shippingCost(float $subtotal, ?string $shippingMethod = null): float
    {
        // Shipping is free for all orders.
        return 0;
    }

    private function shippingMethods(): array
    {
        return Config::get('ecommerce.shipping_methods', []);
    }

    private function decrementStock(Order $order): void
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product && $product->stock > 0) {
                $product->decrement('stock', $item->quantity);
            }
        }
    }

    private function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->increment('stock', $item->quantity);
            }
        }
    }

    private function initializeFlutterwave(Order $order, ?User $user): array
    {
        $secretKey = config('services.flutterwave.secret_key');

        if (! $secretKey) {
            Log::error('Flutterwave secret key not configured for order payment', [
                'order_id' => $order->id,
                'user_id' => $user?->id,
            ]);

            return ['success' => false, 'message' => 'Payment gateway not configured'];
        }

        $txRef = 'ord_' . $order->id . '_' . time();

        $payload = [
            'tx_ref' => $txRef,
            'amount' => $order->total,
            'currency' => $order->currency,
            'redirect_url' => rtrim(env('FRONTEND_URL'), '/') . '/checkout/success',
            'payment_options' => 'card,banktransfer,ussd',
            'customer' => [
                'email' => $order->billing_email ?? ($user?->email ?? 'guest@example.com'),
                'name' => $order->billing_name ?? ($user?->profile?->full_name ?? $user?->name ?? 'Guest'),
                'phonenumber' => $order->billing_phone ?? '',
            ],
            'customizations' => [
                'title' => 'LivinusStore',
                'description' => 'Order #' . $order->id,
            ],
            'meta' => [
                'order_id' => $order->id,
                'user_id' => $user?->id,
            ],
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ])->timeout(10)->post(self::FLUTTERWAVE_BASE_URL . '/payments', $payload);
        } catch (\Throwable $throwable) {
            Log::error('Flutterwave order payment HTTP error', [
                'order_id' => $order->id,
                'message' => $throwable->getMessage(),
            ]);

            return ['success' => false, 'message' => 'Unable to reach payment provider'];
        }

        if (! $response->successful()) {
            Log::error('Flutterwave order payment error', [
                'order_id' => $order->id,
                'response' => $response->json(),
            ]);

            return ['success' => false, 'message' => 'Payment initialization failed'];
        }

        $data = $response->json();
        $paymentLink = $data['data']['link']
            ?? $data['data']['authorization_url']
            ?? ($data['link'] ?? null);

        if (! $paymentLink) {
            return ['success' => false, 'message' => 'Payment link generation failed'];
        }

        return [
            'success' => true,
            'tx_ref' => $txRef,
            'payment_link' => $paymentLink,
        ];
    }
}

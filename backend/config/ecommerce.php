<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Store Currency
    |--------------------------------------------------------------------------
    */
    'currency' => env('ECOMMERCE_CURRENCY', 'NGN'),

    /*
    |--------------------------------------------------------------------------
    | Tax
    |--------------------------------------------------------------------------
    | Tax rate expressed as a decimal (e.g. 0.075 = 7.5% of the subtotal).
    */
    'tax_rate' => (float) env('ECOMMERCE_TAX_RATE', 0.0),

    /*
    |--------------------------------------------------------------------------
    | Shipping
    |--------------------------------------------------------------------------
    | Orders whose subtotal is >= free_shipping_threshold ship for free.
    */
    'free_shipping_threshold' => (float) env('ECOMMERCE_FREE_SHIPPING_THRESHOLD', 50000),

    'shipping_methods' => [
        'standard' => [
            'label' => 'Standard Delivery',
            'cost' => (float) env('ECOMMERCE_SHIPPING_STANDARD', 2000),
        ],
        'express' => [
            'label' => 'Express Delivery',
            'cost' => (float) env('ECOMMERCE_SHIPPING_EXPRESS', 5000),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment
    |--------------------------------------------------------------------------
    */
    'payment_methods' => ['flutterwave', 'bank_transfer', 'cash_on_delivery'],

    /*
    |--------------------------------------------------------------------------
    | Bank Transfer Details
    |--------------------------------------------------------------------------
    |
    | Where subscribers send their manual (bank transfer) payments. Payments
    | are verified manually from the admin area, so the account details
    | shown to the customer must match the account we watch.
    |
    */
    'bank_transfer' => [
        'account_name' => env('BANK_ACCOUNT_NAME', 'Firstborn Publishing'),
        'account_number' => env('BANK_ACCOUNT_NUMBER', '1013019164'),
        'bank_name' => env('BANK_NAME', 'Zenith Bank'),
        'instructions' => env(
            'BANK_TRANSFER_INSTRUCTIONS',
            'Transfer the exact amount to the account below, then upload your payment receipt. Our team verifies the payment and activates your access.'
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Order Lifecycle
    |--------------------------------------------------------------------------
    */
    'order_statuses' => ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'],

    'payment_statuses' => ['unpaid', 'pending_verification', 'paid', 'failed', 'refunded'],

];

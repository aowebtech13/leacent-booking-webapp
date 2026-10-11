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
    | Order Lifecycle
    |--------------------------------------------------------------------------
    */
    'order_statuses' => ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'],

    'payment_statuses' => ['unpaid', 'pending_verification', 'paid', 'failed', 'refunded'],

];

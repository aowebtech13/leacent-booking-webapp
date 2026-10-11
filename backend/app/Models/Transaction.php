<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;


class Transaction extends Model
{
    /*
    |--------------------------------------------------------------------------
    | Types
    |--------------------------------------------------------------------------
    */
    public const TYPE_ORDER_PAYMENT = 'order_payment';
    public const TYPE_MANUAL_PAYMENT = 'manual_payment';
    public const TYPE_REFUND = 'refund';
    public const TYPE_WALLET_CREDIT = 'wallet_credit';
    public const TYPE_SUBSCRIPTION = 'subscription';

    /*
    |--------------------------------------------------------------------------
    | Statuses
    |--------------------------------------------------------------------------
    */
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_id',
        'user_id',
        'type',
        'amount',
        'currency',
        'payment_method',
        'status',
        'reference',
        'description',
        'meta',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'meta' => 'array',
        'verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */
    protected function isActionable(): Attribute
    {
        return Attribute::make(
            get: fn () => in_array($this->status, [self::STATUS_PENDING], true),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isAccepted(): bool
    {
        return in_array($this->status, [self::STATUS_ACCEPTED, self::STATUS_COMPLETED], true);
    }

    public function isRejected(): bool
    {
        return $this->status === self::STATUS_REJECTED;
    }

    
    public static function findOrCreateForOrder(Order $order, string $type, string $status): self
    {
        $transaction = self::query()
            ->where('order_id', $order->id)
            ->where('type', $type)
            ->latest()
            ->first();

        if ($transaction) {
            // Update amount and reference in case they changed (e.g., after manual payment submission).
            $transaction->amount = $order->amount_paid ?? $order->total;
            $transaction->currency = $order->currency;
            $transaction->payment_method = $order->payment_method;
            $transaction->reference = $order->payment_reference ?? $order->flutterwave_tx_ref;
            $transaction->meta = [
                'billing_name' => $order->billing_name,
                'billing_email' => $order->billing_email,
            ];
            $transaction->save();

            return $transaction;
        }

        return self::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'type' => $type,
            'amount' => $order->amount_paid ?? $order->total,
            'currency' => $order->currency,
            'payment_method' => $order->payment_method,
            'status' => $status,
            'reference' => $order->payment_reference ?? $order->flutterwave_tx_ref,
            'description' => 'Order #' . $order->id . ' payment',
            'meta' => [
                'billing_name' => $order->billing_name,
                'billing_email' => $order->billing_email,
            ],
        ]);
    }

    
    public function settle(string $status, ?int $adminId = null, ?string $reason = null): void
    {
        $this->status = $status;
        $this->verified_by = $adminId;
        $this->verified_at = now();

        if ($reason !== null) {
            $this->rejection_reason = $reason;
        }

        $this->save();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID = 'paid';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PENDING_VERIFICATION = 'pending_verification';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_FAILED = 'failed';
    public const PAYMENT_REFUNDED = 'refunded';

    protected $fillable = [
        'user_id',
        'customer_id',
        'status',
        'subtotal',
        'tax',
        'shipping_cost',
        'total',
        'currency',
        'shipping_address',
        'billing_name',
        'billing_email',
        'billing_phone',
        'payment_method',
        'payment_status',
        'flutterwave_tx_ref',
        'flutterwave_transaction_id',
        'notes',
        'payment_receipt',
        'payment_reference',
        'amount_paid',
        'paid_at',
        'payment_verified_by',
        'payment_verified_at',
        'payment_rejection_reason',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'paid_at' => 'datetime',
        'payment_verified_at' => 'datetime',
        'payment_verified_by' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The customer the sale is attributed to (selected on the checkout page).
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payment_verified_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function itemsWithProduct(): HasMany
    {
        return $this->hasMany(OrderItem::class)->with('product');
    }

    /**
     * Public URL for the uploaded payment receipt (if any).
     */
    protected function receiptUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->payment_receipt
                ? Storage::disk('public')->url($this->payment_receipt)
                : null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeStatus($query, ?string $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    public function scopePaymentStatus($query, ?string $paymentStatus)
    {
        return $paymentStatus ? $query->where('payment_status', $paymentStatus) : $query;
    }

    public function scopePaymentPendingVerification($query)
    {
        return $query->where('payment_status', self::PAYMENT_PENDING_VERIFICATION);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function canBePaid(): bool
    {
        return ! $this->isPaid()
            && ! $this->isCancelled()
            && $this->payment_method === 'flutterwave';
    }

    public function markPaid(?string $transactionId = null): void
    {
        $this->payment_status = self::PAYMENT_PAID;

        if ($this->status === self::STATUS_PENDING) {
            $this->status = self::STATUS_PAID;
        }

        if ($transactionId) {
            $this->flutterwave_transaction_id = $transactionId;
        }

        $this->save();
    }

    public function isPendingVerification(): bool
    {
        return $this->payment_status === self::PAYMENT_PENDING_VERIFICATION;
    }

    /**
     * Admin approves a manually submitted payment.
     */
    public function markVerified(int $adminId, ?string $notes = null): void
    {
        $this->payment_status = self::PAYMENT_PAID;
        $this->payment_verified_at = now();
        $this->payment_verified_by = $adminId;
        $this->payment_rejection_reason = null;

        if ($this->status === self::STATUS_PENDING) {
            $this->status = self::STATUS_PAID;
        }

        if ($notes !== null) {
            $this->notes = $notes;
        }

        $this->save();
    }

    /**
     * Admin rejects a manually submitted payment.
     */
    public function markRejected(int $adminId, string $reason, ?string $notes = null): void
    {
        $this->payment_status = self::PAYMENT_FAILED;
        $this->payment_verified_at = now();
        $this->payment_verified_by = $adminId;
        $this->payment_rejection_reason = $reason;

        if ($notes !== null) {
            $this->notes = $notes;
        }

        $this->save();
    }

    public static function validStatuses(): array
    {
        return Config::get('ecommerce.order_statuses', [
            self::STATUS_PENDING,
            self::STATUS_PAID,
            self::STATUS_PROCESSING,
            self::STATUS_SHIPPED,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELLED,
        ]);
    }
}

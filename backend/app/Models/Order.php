<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_PAID = 'paid';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_SHIPPED = 'shipped';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_PENDING = 'pending';

    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_FAILED = 'failed';
    public const PAYMENT_REFUNDED = 'refunded';
    public const PAYMENT_PENDING_VERIFICATION = 'pending_verification';

    protected $fillable = [
        'user_id',
        'billing_name',
        'billing_email',
        'billing_phone',
        'shipping_address',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'flutterwave_tx_ref',
        'amount_paid',
        'paid_at',
        'currency',
        'subtotal',
        'tax',
        'total',
        'payment_receipt',
        'payment_rejection_reason',
        'notes',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => self::STATUS_PENDING,
        'payment_status' => 'unpaid',
        'currency' => 'NGN',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function isPaid(): bool
    {
        return $this->payment_status === self::PAYMENT_PAID;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isPendingVerification(): bool
    {
        return $this->payment_status === self::PAYMENT_PENDING_VERIFICATION;
    }

    public function markVerified(int $adminId, ?string $notes = null): void
    {
        $this->payment_status = self::PAYMENT_PAID;
        $this->status = self::STATUS_PAID;
        $this->payment_rejection_reason = null;
        $this->verified_by = $adminId;
        $this->verified_at = now();
        $this->paid_at = now();

        if ($notes !== null) {
            $this->notes = $notes;
        }

        $this->save();
    }

    public function markRejected(int $adminId, string $reason = '', ?string $notes = null): void
    {
        $this->payment_status = self::PAYMENT_FAILED;
        $this->payment_rejection_reason = $reason;
        $this->verified_by = $adminId;
        $this->verified_at = now();

        if ($notes !== null) {
            $this->notes = $notes;
        }

        $this->save();
    }

    public static function validStatuses(): array
    {
        return [
            self::STATUS_COMPLETED,
            self::STATUS_PAID,
            self::STATUS_PROCESSING,
            self::STATUS_SHIPPED,
            self::STATUS_CANCELLED,
            self::STATUS_PENDING,
        ];
    }
}

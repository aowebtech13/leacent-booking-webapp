<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class BookPayment extends Model
{
    public const TYPE_SUBSCRIPTION = 'subscription';
    public const TYPE_SINGLE_BOOK = 'single_book';
    public const TYPE_PLAN = 'plan';

    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_FAILED = 'failed';
    public const STATUS_REFUNDED = 'refunded';
    public const STATUS_EXPIRED = 'expired';

    protected $fillable = [
        'user_id',
        'book_id',
        'book_plan_id',
        'payment_type',
        'status',
        'amount',
        'currency',
        'payment_method',
        'flutterwave_tx_ref',
        'flutterwave_transaction_id',
        'payment_reference',
        'payment_receipt',
        'paid_at',
        'starts_at',
        'expires_at',
        'auto_renew',
        'cancelled_at',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'notes',
        'meta',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'auto_renew' => 'boolean',
        'cancelled_at' => 'datetime',
        'verified_at' => 'datetime',
        'meta' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function bookPlan(): BelongsTo
    {
        return $this->belongsTo(BookPlan::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function access(): HasMany
    {
        return $this->hasMany(BookAccess::class, 'book_payment_id');
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

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED
            || ($this->expires_at && $this->expires_at->isPast());
    }

    public function canRenew(): bool
    {
        return ! $this->isActive() && $this->auto_renew === false;
    }

    public function markActive(): void
    {
        $this->status = self::STATUS_ACTIVE;
        $this->save();
    }

    public function markFailed(): void
    {
        $this->status = self::STATUS_FAILED;
        $this->save();
    }

    public function markExpired(): void
    {
        $this->status = self::STATUS_EXPIRED;
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public static function validStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_ACTIVE,
            self::STATUS_FAILED,
            self::STATUS_REFUNDED,
            self::STATUS_EXPIRED,
        ];
    }
}
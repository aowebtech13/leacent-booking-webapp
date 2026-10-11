<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    public const PLAN_FREE = 'free';
    public const PLAN_STUDENT = 'student';
    public const PLAN_PRO = 'pro';
    public const PLAN_MAX = 'max';
    public const PLAN_TEAM = 'team';

    public const STATUS_ACTIVE = 'active';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_PENDING = 'pending';
    public const STATUS_FAILED = 'failed';

    public const BILLING_MONTHLY = 'monthly';
    public const BILLING_YEARLY = 'yearly';

    protected $fillable = [
        'user_id',
        'book_plan_id',
        'plan',
        'status',
        'billing_cycle',
        'flutterwave_transaction_id',
        'flutterwave_tx_ref',
        'amount',
        'currency',
        'start_date',
        'end_date',
        'auto_renew',
        'cancelled_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'auto_renew' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookPlan(): BelongsTo
    {
        return $this->belongsTo(BookPlan::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BookPayment::class);
    }

    public function access(): HasMany
    {
        return $this->hasMany(BookAccess::class);
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE
            && (! $this->end_date || $this->end_date->isFuture());
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_EXPIRED
            || ($this->end_date && $this->end_date->isPast());
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function daysRemaining(): int
    {
        if (! $this->end_date) {
            return 0;
        }

        return max(0, now()->diffInDays($this->end_date, false));
    }

    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE)
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('status', self::STATUS_EXPIRED)
                ->orWhere('end_date', '<=', now());
        });
    }

    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public static function validPlans(): array
    {
        return [
            self::PLAN_FREE,
            self::PLAN_STUDENT,
            self::PLAN_PRO,
            self::PLAN_MAX,
            self::PLAN_TEAM,
        ];
    }

    public static function validStatuses(): array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_EXPIRED,
            self::STATUS_CANCELLED,
            self::STATUS_PENDING,
            self::STATUS_FAILED,
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookAccess extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'subscription_id',
        'book_payment_id',
        'access_type',
        'granted_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'granted_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function bookPayment(): BelongsTo
    {
        return $this->belongsTo(BookPayment::class, 'book_payment_id');
    }

    /**
     * Whether the access is currently valid (active and not expired).
     */
    public function isValid(): bool
    {
        if (! $this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('is_active', false)
                ->orWhere('expires_at', '<=', now());
        });
    }
}
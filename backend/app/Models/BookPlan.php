<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookPlan extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'currency',
        'billing_cycle',
        'access_duration_days',
        'unlimited_books',
        'book_limit',
        'can_download',
        'can_read_offline',
        'is_active',
        'is_featured',
        'sort_order',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'unlimited_books' => 'boolean',
        'book_limit' => 'integer',
        'can_download' => 'boolean',
        'can_read_offline' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'access_duration_days' => 'integer',
        'features' => 'array',
    ];

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BookPayment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price');
    }

    /**
     * Whether this plan grants unlimited book access.
     */
    public function getIsUnlimitedAttribute(): bool
    {
        return $this->unlimited_books || $this->book_limit === 0;
    }
}
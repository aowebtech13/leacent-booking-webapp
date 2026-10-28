<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'author',
        'author_id',
        'publisher',
        'language',
        'category',
        'publication_year',
        'page_count',
        'format',
        'file_path',
        'cover_image_path',
        'preview_path',
        'is_premium',
        'is_active',
        'is_featured',
        'read_count',
        'download_count',
        'rating',
        'reviews_count',
        'tags',
    ];

    protected $appends = ['file_url', 'cover_url', 'preview_url'];

    protected $casts = [
        'is_premium' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'read_count' => 'integer',
        'download_count' => 'integer',
        'rating' => 'decimal:1',
        'reviews_count' => 'integer',
        'publication_year' => 'integer',
        'page_count' => 'integer',
        'tags' => 'array',
    ];

    public function access(): HasMany
    {
        return $this->hasMany(BookAccess::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(BookPayment::class);
    }

    public function readingProgress(): HasMany
    {
        return $this->hasMany(BookReadingProgress::class);
    }

    public function activeAccess(): HasMany
    {
        return $this->hasMany(BookAccess::class)->where('is_active', true);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'book_id');
    }

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Public URL for the book file (if any).
     */
    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->file_path
                ? Storage::disk('public')->url($this->file_path)
                : null,
        );
    }

    /**
     * Public URL for the cover image (if any).
     */
    protected function coverUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->cover_image_path
                ? Storage::disk('public')->url($this->cover_image_path)
                : null,
        );
    }

    /**
     * Public URL for the preview (if any).
     */
    protected function previewUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->preview_path
                ? Storage::disk('public')->url($this->preview_path)
                : null,
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePremium($query)
    {
        return $query->where('is_premium', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_premium', false);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, ?string $category)
    {
        return $category ? $query->where('category', $category) : $query;
    }

    public function scopeSearch($query, ?string $search)
    {
        if (! $search) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }
}
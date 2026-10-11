<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReadingProgress extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'current_page',
        'total_pages',
        'progress_percentage',
        'last_read_at',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'current_page' => 'integer',
        'total_pages' => 'integer',
        'progress_percentage' => 'decimal:2',
        'last_read_at' => 'datetime',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('is_completed', true);
    }

    public function scopeInProgress($query)
    {
        return $query->where('is_completed', false)->latest('last_read_at');
    }

    /**
     * Update progress based on current page and total pages.
     */
    public function updateProgress(int $currentPage, ?int $totalPages = null): void
    {
        $this->current_page = $currentPage;

        if ($totalPages !== null) {
            $this->total_pages = $totalPages;
        }

        if ($this->total_pages > 0) {
            $this->progress_percentage = min(
                100,
                (int) round(($this->current_page / $this->total_pages) * 100)
            );
        }

        $this->last_read_at = now();

        if ($this->progress_percentage >= 100) {
            $this->is_completed = true;
            $this->completed_at = now();
        }

        $this->save();
    }
}
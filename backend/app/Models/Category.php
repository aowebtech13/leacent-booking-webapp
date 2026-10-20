<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'order',
        'parent_id',
        'meta_title',
        'meta_description',
        'status',
    ];

    /**
     * Books filed under this category. `books.category` stores the category
     * name (or slug) as free text, so the count is resolved by the
     * controller sub-query.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Book::class, 'category', 'name');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
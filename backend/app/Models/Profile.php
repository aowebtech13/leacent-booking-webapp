<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'full_name',
        'company_name',
        'phone_number',
        'address',
        'lga',
        'state',
        'about_me',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'avatar_url',
        'phone',
        'points',
    ];

    protected $casts = [
        'points' => 'integer',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The user's current point balance.
     */
    public function getPointsBalanceAttribute(): int
    {
        return (int) ($this->attributes['points'] ?? 0);
    }

    /**
     * Whether the user has enough points to unlock a book.
     */
    public function hasEnoughPoints(int $required): bool
    {
        return $this->points_balance >= $required;
    }

    /**
     * Add points to the user's balance.
     */
    public function addPoints(int $amount, ?string $description = null): void
    {
        $this->increment('points', $amount);

        $this->user->walletTransactions()->create([
            'amount' => $amount,
            'type' => 'credit',
            'description' => $description ?? 'Points credited',
            'reference' => 'POINT-'.strtoupper(\Illuminate\Support\Str::random(8)),
        ]);
    }

    /**
     * Deduct points from the user's balance.
     */
    public function deductPoints(int $amount, ?string $description = null): bool
    {
        if ($this->points_balance < $amount) {
            return false;
        }

        $this->decrement('points', $amount);

        $this->user->walletTransactions()->create([
            'amount' => $amount,
            'type' => 'debit',
            'description' => $description ?? 'Points deducted',
            'reference' => 'POINT-'.strtoupper(\Illuminate\Support\Str::random(8)),
        ]);

        return true;
    }
}
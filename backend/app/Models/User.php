<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method bool isAdmin()
 * @method bool hasRole(string $role)
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
            'otp_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * In-app notifications for this user.
     *
     * The `notifications` table is keyed by `user_id` (not the default
     * `notifiable_type`/`notifiable_id` morph columns), so we override the
     * `Notifiable` trait's `morphMany` relationship with an explicit
     * `hasMany` on `user_id`. Without this, `$user->notify(...)` attempts to
     * insert into non-existent `notifiable_*` columns and the insert fails,
     * which is why no notifications were ever created.
     */
    public function notifications()
    {
        return $this->hasMany(\App\Models\Notification::class, 'user_id')->latest();
    }

    /**
     * Get the user's unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    // Subscriptions are currently removed from the user domain.
    // Keep this stub relationship so legacy code referencing
    // `activeSubscription` doesn't crash.
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->whereRaw('1=0');
    }


    public function userLogs()
    {
        return $this->hasMany(UserLog::class);
    }

    public function roles()
    {
        return $this->hasMany(UserRole::class);
    }

   

    /**
     * Get the user's effective plan name (e.g., Free, Pro, or ZERO if expired)
     */
    public function getEffectivePlanAttribute(): string
    {
        // Subscriptions removed: all users are treated as Free.
        return 'Free';
    }


   

    public function usages()
    {
        return $this->hasMany(Usage::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    

    /**
     * Helper methods
     */
    public function hasRole($role): bool
    {
        return $this->roles()->where('role', $role)->exists();
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

}

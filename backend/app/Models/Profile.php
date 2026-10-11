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
        'balance',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
}


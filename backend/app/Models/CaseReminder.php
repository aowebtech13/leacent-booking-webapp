<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'case_id',
        'case_name',
        'recipient_email',
        'subject',
        'body',
        'payload',
        'type',
        'status',
        'scheduled_for',
        'processing_started_at',
        'sent_at',
        'last_error',
    ];

    protected $casts = [
        'payload' => 'array',
        'scheduled_for' => 'datetime',
        'processing_started_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emailLogs()
    {
        return $this->hasMany(EmailLog::class);
    }
}

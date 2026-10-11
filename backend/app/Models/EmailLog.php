<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_reminder_id',
        'compliance_report_id',
        'to_email',
        'subject',
        'body',
        'from_email',
        'status',
        'resend_email_id',
        'resend_response',
        'error_message',
        'sent_at',
        'delivered_at',
        'bounced_at',
        'complained_at',
    ];

    protected $casts = [
        'resend_response' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'bounced_at' => 'datetime',
        'complained_at' => 'datetime',
    ];

    public function caseReminder()
    {
        return $this->belongsTo(CaseReminder::class);
    }

    public function complianceReport()
    {
        return $this->belongsTo(ComplianceReport::class);
    }
}

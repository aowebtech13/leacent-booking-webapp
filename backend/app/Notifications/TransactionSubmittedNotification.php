<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TransactionSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $transactionId,
        public int $orderId,
        public float $amount,
        public string $currency,
        public string $type,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Transaction Submitted',
            'message' => "A {$this->type} transaction for order #{$this->orderId} has been submitted. Amount: {$this->currency} " . number_format($this->amount, 2),
            'type' => 'transaction_submitted',
            'transaction_id' => $this->transactionId,
            'order_id' => $this->orderId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'action_url' => "/orders/{$this->orderId}",
            'avatar' => null,
            'iconClass' => 'ti ti-clock',
            'bgClass' => 'bg-warning',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-warning',
        ];
    }
}

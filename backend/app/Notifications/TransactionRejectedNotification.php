<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TransactionRejectedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $transactionId,
        public int $orderId,
        public string $reason,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Transaction Rejected',
            'message' => "Your transaction for order #{$this->orderId} has been rejected. Reason: {$this->reason}",
            'type' => 'transaction_rejected',
            'transaction_id' => $this->transactionId,
            'order_id' => $this->orderId,
            'reason' => $this->reason,
            'action_url' => "/orders/{$this->orderId}",
            'avatar' => null,
            'iconClass' => 'ti ti-x',
            'bgClass' => 'bg-danger',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-danger',
        ];
    }
}

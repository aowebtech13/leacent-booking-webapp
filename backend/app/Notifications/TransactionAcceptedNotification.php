<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TransactionAcceptedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $transactionId,
        public int $orderId,
        public float $amount,
        public string $currency,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Transaction Accepted',
            'message' => "Your transaction for order #{$this->orderId} has been accepted. Amount: {$this->currency} " . number_format($this->amount, 2),
            'type' => 'transaction_accepted',
            'transaction_id' => $this->transactionId,
            'order_id' => $this->orderId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'action_url' => "/orders/{$this->orderId}",
            'avatar' => null,
            'iconClass' => 'ti ti-check',
            'bgClass' => 'bg-success',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-success',
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ManualPaymentRejectedNotification extends Notification
{

    public function __construct(
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
            'title' => 'Payment Rejected',
            'message' => "Your payment for order #{$this->orderId} has been rejected. Reason: {$this->reason}",
            'type' => 'manual_payment_rejected',
            'order_id' => $this->orderId,
            'reason' => $this->reason,
            'action_url' => "/orders/{$this->orderId}",
        ];
    }
}

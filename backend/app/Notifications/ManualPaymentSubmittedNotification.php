<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ManualPaymentSubmittedNotification extends Notification
{

    public function __construct(
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
            'title' => 'Payment Receipt Submitted',
            'message' => "Your payment receipt for order #{$this->orderId} has been submitted and is awaiting verification. Amount: {$this->currency} " . number_format($this->amount, 2),
            'type' => 'manual_payment_submitted',
            'order_id' => $this->orderId,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'action_url' => "/orders/{$this->orderId}",
        ];
    }
}

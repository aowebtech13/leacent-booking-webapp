<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlacedNotification extends Notification
{

    public function __construct(
        public int $orderId,
        public float $total,
        public string $currency,
        public string $paymentMethod,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Order Placed Successfully',
            'message' => "Your order #{$this->orderId} has been placed. Total: {$this->currency} " . number_format($this->total, 2),
            'type' => 'order_placed',
            'order_id' => $this->orderId,
            'total' => $this->total,
            'currency' => $this->currency,
            'payment_method' => $this->paymentMethod,
            'action_url' => "/orders/{$this->orderId}",
        ];
    }
}

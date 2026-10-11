<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PaymentFailedNotification extends Notification
{

    public function __construct(
        public ?int $orderId = null,
        public ?string $subscriptionPlan = null,
        public string $reason = 'Payment verification failed',
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $title = 'Payment Failed';
        $message = $this->reason;

        if ($this->orderId) {
            $message = "Payment for order #{$this->orderId} failed. {$this->reason}";
        } elseif ($this->subscriptionPlan) {
            $message = "Your {$this->subscriptionPlan} plan payment failed. {$this->reason}";
        }

        return [
            'title' => $title,
            'message' => $message,
            'type' => 'payment_failed',
            'order_id' => $this->orderId,
            'subscription_plan' => $this->subscriptionPlan,
            'reason' => $this->reason,
            'action_url' => $this->orderId ? "/orders/{$this->orderId}" : '/dashboard/subscription',
        ];
    }
}

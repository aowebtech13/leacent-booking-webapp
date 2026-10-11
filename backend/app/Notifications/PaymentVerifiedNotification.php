<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class PaymentVerifiedNotification extends Notification
{

    public function __construct(
        public ?int $orderId = null,
        public ?string $subscriptionPlan = null,
        public float $amount = 0,
        public string $currency = 'NGN',
        public string $transactionId = '',
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $title = 'Payment Verified';
        $message = 'Your payment has been verified successfully.';

        if ($this->orderId) {
            $message = "Payment for order #{$this->orderId} has been verified. Amount: {$this->currency} " . number_format($this->amount, 2);
        } elseif ($this->subscriptionPlan) {
            $message = "Your {$this->subscriptionPlan} plan subscription payment has been verified. Amount: {$this->currency} " . number_format($this->amount, 2);
        }

        return [
            'title' => $title,
            'message' => $message,
            'type' => 'payment_verified',
            'order_id' => $this->orderId,
            'subscription_plan' => $this->subscriptionPlan,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'transaction_id' => $this->transactionId,
            'action_url' => $this->orderId ? "/orders/{$this->orderId}" : '/dashboard/subscription',
        ];
    }
}

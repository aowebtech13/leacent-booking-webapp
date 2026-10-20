<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SubscriptionActivatedNotification extends Notification
{
    public function __construct(
        public string $planName,
        public float $amount,
        public string $currency,
        public string $accessEndsAt,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Subscription Activated',
            'message' => "Your {$this->planName} subscription payment of {$this->currency} ".number_format($this->amount, 2)." has been verified. Access is active until {$this->accessEndsAt}.",
            'type' => 'subscription_activated',
            'plan' => $this->planName,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'access_ends_at' => $this->accessEndsAt,
            'action_url' => '/apps/pricing',
        ];
    }
}

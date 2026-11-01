<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RegistrationBonusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $points,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Welcome Bonus',
            'message' => "Welcome to leacent Book! You've received {$this->points} point" . ($this->points === 1 ? '' : 's') . ' as a registration bonus. Use them to unlock premium books.',
            'type' => 'registration_bonus',
            'points' => $this->points,
            'action_url' => '/apps/setting',
            'avatar' => null,
            'iconClass' => 'ti ti-gift',
            'bgClass' => 'bg-success',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-secondary',
        ];
    }
}
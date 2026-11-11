<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PointsCreditedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $points,
        public string $description,
        public int $newBalance,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Points Credited',
            'message' => "{$this->points} point" . ($this->points === 1 ? '' : 's') . " credited to your account. {$this->description}",
            'type' => 'points_credited',
            'points' => $this->points,
            'description' => $this->description,
            'new_balance' => $this->newBalance,
            'action_url' => '/apps/setting',
            'avatar' => null,
            'iconClass' => 'ti ti-coin',
            'bgClass' => 'bg-success',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-success',
        ];
    }
}

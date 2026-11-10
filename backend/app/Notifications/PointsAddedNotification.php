<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PointsAddedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $points,
        public string $description = 'Points added to your account',
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Points Added',
            'message' => "You've received {$this->points} point" . ($this->points === 1 ? '' : 's') . '. ' . $this->description . '.',
            'type' => 'points_added',
            'points' => $this->points,
            'action_url' => '/apps/setting',
            'avatar' => null,
            'iconClass' => 'ti ti-coin',
            'bgClass' => 'bg-info',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-secondary',
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PointsDebitedNotification extends Notification
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
            'title' => 'Points Deducted',
            'message' => "{$this->points} point" . ($this->points === 1 ? '' : 's') . " deducted from your account. {$this->description}",
            'type' => 'points_debited',
            'points' => $this->points,
            'description' => $this->description,
            'new_balance' => $this->newBalance,
            'action_url' => '/apps/setting',
            'avatar' => null,
            'iconClass' => 'ti ti-trash',
            'bgClass' => 'bg-danger',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-danger',
        ];
    }
}

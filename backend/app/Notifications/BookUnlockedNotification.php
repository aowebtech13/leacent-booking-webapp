<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookUnlockedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public int $bookId,
        public string $bookTitle,
        public int $pointsSpent,
        public int $pointsRemaining,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Book Unlocked',
            'message' => "You've unlocked \"{$this->bookTitle}\" for {$this->pointsSpent} point" . ($this->pointsSpent === 1 ? '' : 's') . '.',
            'type' => 'book_unlocked',
            'book_id' => $this->bookId,
            'points_spent' => $this->pointsSpent,
            'points_remaining' => $this->pointsRemaining,
            'action_url' => "/apps/book-library/read/{$this->bookId}",
            'avatar' => null,
            'iconClass' => 'ti ti-book-open',
            'bgClass' => 'bg-success',
            'date' => now()->format('M j, Y'),
            'dateBadgeClass' => 'text-light-success',
        ];
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ExpireSubscriptions extends Command
{
    protected $signature = 'subscriptions:expire';
    protected $description = 'Automatically expire subscriptions that have passed their end date';

    public function handle()
    {
        $this->info('Starting subscription expiration check...');

        $expiredCount = Subscription::where('status', 'active')
            ->whereNotNull('end_date')
            ->where('end_date', '<', now())
            ->update(['status' => 'expired']);

        if ($expiredCount > 0) {
            Log::info("Expired {$expiredCount} subscriptions");
            $this->info("✓ Successfully expired {$expiredCount} subscriptions");
        } else {
            $this->info("No subscriptions needed to be expired");
        }

        return 0;
    }
}

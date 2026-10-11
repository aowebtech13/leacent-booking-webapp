<?php

namespace App\Console\Commands;

use App\Models\CaseReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CaseRemindersHealthCheck extends Command
{
    protected $signature = 'case-reminders:health-check';

    protected $description = 'Check the health of the case reminders system';

    public function handle(): int
    {
        $this->info('Running case reminders health check...');
        Log::info('Starting CaseRemindersHealthCheck command');

        $stats = [
            'total' => CaseReminder::count(),
            'scheduled' => CaseReminder::where('status', 'scheduled')->count(),
            'processing' => CaseReminder::where('status', 'processing')->count(),
            'sent' => CaseReminder::where('status', 'sent')->count(),
            'failed' => CaseReminder::where('status', 'failed')->count(),
            'cancelled' => CaseReminder::where('status', 'cancelled')->count(),
        ];

        $overdueDays = 1;
        $overdueReminders = CaseReminder::where('status', 'scheduled')
            ->where('scheduled_for', '<=', now()->subDays($overdueDays))
            ->count();

        $stuckProcessing = CaseReminder::where('status', 'processing')
            ->where('processing_started_at', '<=', now()->subHours(1))
            ->count();

        $this->table(
            ['Status', 'Count'],
            collect($stats)->map(fn($count, $status) => [$status, $count])->values()
        );

        $this->newLine();

        if ($overdueReminders > 0) {
            $this->warn("⚠️  {$overdueReminders} reminders are overdue (scheduled > {$overdueDays} day(s) ago)");
            Log::warning("Health check found overdue reminders", ['count' => $overdueReminders]);
        } else {
            $this->info('✓ No overdue reminders');
        }

        if ($stuckProcessing > 0) {
            $this->warn("⚠️  {$stuckProcessing} reminders are stuck in processing (> 1 hour)");
            Log::warning("Health check found stuck reminders", ['count' => $stuckProcessing]);
        } else {
            $this->info('✓ No stuck reminders');
        }

        $this->newLine();
        $this->info('Health check completed');
        Log::info('CaseRemindersHealthCheck completed', $stats);

        return self::SUCCESS;
    }
}

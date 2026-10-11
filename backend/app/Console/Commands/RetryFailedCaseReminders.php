<?php

namespace App\Console\Commands;

use App\Jobs\SendCaseReminderEmail;
use App\Models\CaseReminder;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RetryFailedCaseReminders extends Command
{
    protected $signature = 'case-reminders:retry-failed {--max-retries=3}';

    protected $description = 'Retry failed case reminders that have not exceeded max retry attempts';

    private int $retried = 0;
    private int $succeeded = 0;
    private int $failed = 0;

    public function handle(): int
    {
        $maxRetries = (int) $this->option('max-retries');
        $this->info("Starting failed case reminders retry job (max retries: {$maxRetries})...");
        Log::info("Starting RetryFailedCaseReminders command", ['max_retries' => $maxRetries]);

        try {
            $failedReminders = CaseReminder::where('type', 'scheduled')
                ->where('status', 'failed')
                ->orderBy('updated_at')
                ->get();

            if ($failedReminders->isEmpty()) {
                $this->info('No failed reminders to retry');
                return self::SUCCESS;
            }

            $this->info("Found {$failedReminders->count()} failed reminders");

            foreach ($failedReminders as $reminder) {
                $retryCount = $this->getRetryCount($reminder);

                if ($retryCount >= $maxRetries) {
                    $this->warn("Reminder {$reminder->id} has exceeded max retry attempts ({$retryCount}/{$maxRetries})");
                    Log::warning("Reminder {$reminder->id} exceeded max retries", ['attempts' => $retryCount]);
                    continue;
                }

                $this->retried++;

                $emailLog = EmailLog::create([
                    'case_reminder_id' => $reminder->id,
                    'to_email' => $reminder->recipient_email,
                    'subject' => $reminder->subject,
                    'body' => $reminder->body,
                    'status' => 'pending',
                ]);

                try {
                    $toEmail = $emailLog->to_email;
                    $subject = $emailLog->subject;
                    $body = $emailLog->body;

                    Mail::raw($body, function ($message) use ($toEmail, $subject) {
                        $message->to($toEmail)
                            ->subject($subject);
                    });

                    $emailLog->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                        'from_email' => config('mail.from.address'),
                    ]);

                    $reminder->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                        'last_error' => null,
                    ]);

                    $this->succeeded++;
                    $this->info("Reminder {$reminder->id} sent successfully");
                    Log::info("Reminder {$reminder->id} sent successfully");
                } catch (\Throwable $throwable) {
                    $this->failed++;
                    $errorMessage = $throwable->getMessage();

                    $emailLog->update([
                        'status' => 'failed',
                        'error_message' => $errorMessage,
                    ]);

                    $reminder->update([
                        'last_error' => $errorMessage,
                    ]);

                    Log::warning("Reminder {$reminder->id} send failed", ['error' => $errorMessage]);
                    $this->warn("Reminder {$reminder->id} send failed: {$errorMessage}");
                }
            }

            $this->info("Retry job completed. Total: {$this->retried}, Succeeded: {$this->succeeded}, Failed: {$this->failed}");
            Log::info("RetryFailedCaseReminders completed", [
                'total_retried' => $this->retried,
                'succeeded' => $this->succeeded,
                'failed' => $this->failed,
            ]);

            return self::SUCCESS;
        } catch (\Throwable $throwable) {
            Log::error('RetryFailedCaseReminders command failed', [
                'error' => $throwable->getMessage(),
            ]);
            $this->error('Command failed: ' . $throwable->getMessage());
            return self::FAILURE;
        }
    }

    private function getRetryCount(CaseReminder $reminder): int
    {
        if (!$reminder->processing_started_at) {
            return 0;
        }

        return CaseReminder::where('id', $reminder->id)
            ->where('status', 'failed')
            ->count();
    }
}

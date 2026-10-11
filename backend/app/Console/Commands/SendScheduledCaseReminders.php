<?php

namespace App\Console\Commands;

use App\Jobs\SendCaseReminderEmail;
use App\Models\CaseReminder;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendScheduledCaseReminders extends Command
{
    protected $signature = 'case-reminders:send-due';

    protected $description = 'Send scheduled case reminders that are due';

    private int $sent = 0;
    private int $failed = 0;

    public function handle(): int
    {
        $this->info('Starting scheduled case reminders job...');
        Log::info('Starting SendScheduledCaseReminders command');

        try {
            $dueReminders = CaseReminder::where('type', 'scheduled')
                ->where('status', 'scheduled')
                ->where('scheduled_for', '<=', now())
                ->orderBy('scheduled_for')
                ->limit(50)
                ->get();

            if ($dueReminders->isEmpty()) {
                $this->info('No due reminders found');
                Log::info('No due reminders to process');
                return self::SUCCESS;
            }

            $this->info("Found {$dueReminders->count()} due reminders to send");

            foreach ($dueReminders as $reminder) {
                $this->processReminder($reminder);
            }

            $this->info("Job completed. Sent: {$this->sent}, Failed: {$this->failed}");
            Log::info("SendScheduledCaseReminders completed. Sent: {$this->sent}, Failed: {$this->failed}");

            return self::SUCCESS;
        } catch (\Throwable $throwable) {
            Log::error('SendScheduledCaseReminders command failed', [
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ]);
            $this->error('Command failed: ' . $throwable->getMessage());
            return self::FAILURE;
        }
    }

    private function processReminder(CaseReminder $reminder): void
    {
        $claimed = CaseReminder::where('id', $reminder->id)
            ->where('status', 'scheduled')
            ->update([
                'status' => 'processing',
                'processing_started_at' => now(),
            ]);

        if (!$claimed) {
            $this->warn("Reminder {$reminder->id} already processing, skipping");
            return;
        }

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

            CaseReminder::where('id', $reminder->id)->update([
                'status' => 'sent',
                'sent_at' => now(),
                'last_error' => null,
            ]);

            $this->sent++;
            Log::info("Case reminder {$reminder->id} sent to {$reminder->recipient_email}");
        } catch (\Throwable $throwable) {
            $this->failed++;
            $errorMessage = $throwable->getMessage();

            $emailLog->update([
                'status' => 'failed',
                'error_message' => $errorMessage,
            ]);

            CaseReminder::where('id', $reminder->id)->update([
                'status' => 'failed',
                'last_error' => $errorMessage,
            ]);

            Log::error("Failed to send case reminder {$reminder->id}", [
                'error' => $errorMessage,
                'recipient' => $reminder->recipient_email,
                'case_name' => $reminder->case_name,
            ]);

            $this->error("Failed to send reminder {$reminder->id}: {$errorMessage}");
        }
    }
}

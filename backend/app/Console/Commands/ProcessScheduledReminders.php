<?php

namespace App\Console\Commands;

use App\Models\CaseReminder;
use App\Models\EmailLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ProcessScheduledReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-scheduled-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process and send scheduled case reminders that are due';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for due reminders...');

        $reminders = CaseReminder::where('type', 'scheduled')
            ->whereIn('status', ['scheduled', 'processing'])
            ->where('scheduled_for', '<=', now())
            ->whereNull('sent_at')
            ->get();

        if ($reminders->isEmpty()) {
            $this->info('No due reminders found.');
            return;
        }

        $this->info('Found ' . $reminders->count() . ' reminders to process.');

        foreach ($reminders as $reminder) {
            $this->processReminder($reminder);
        }

        $this->info('Finished processing reminders.');
    }

    private function processReminder($reminder)
    {
        $this->info("Processing reminder ID: {$reminder->id} for {$reminder->recipient_email}");

        // Find or create an email log
        $emailLog = EmailLog::where('case_reminder_id', $reminder->id)->first();
        
        if (!$emailLog) {
            $emailLog = EmailLog::create([
                'case_reminder_id' => $reminder->id,
                'to_email' => $reminder->recipient_email,
                'subject' => $reminder->subject,
                'body' => $reminder->body,
                'status' => 'pending',
            ]);
        }

        try {
            $toEmail = $reminder->recipient_email;
            $subject = $reminder->subject;
            $body = $reminder->body;

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

            Log::info("Scheduled reminder sent successfully via Cron", ['reminder_id' => $reminder->id]);
            $this->info("Successfully sent reminder ID: {$reminder->id}");

        } catch (\Throwable $throwable) {
            Log::error("Failed to send scheduled reminder via Cron", [
                'reminder_id' => $reminder->id,
                'error' => $throwable->getMessage()
            ]);

            $emailLog->update([
                'status' => 'failed',
                'error_message' => $throwable->getMessage(),
            ]);

            $reminder->update([
                'status' => 'failed',
                'last_error' => $throwable->getMessage(),
            ]);

            $this->error("Failed to send reminder ID: {$reminder->id}");
        }
    }
}

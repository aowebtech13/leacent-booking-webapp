<?php

namespace App\Http\Controllers;

use App\Jobs\SendCaseReminderEmail;
use App\Models\CaseReminder;
use App\Models\EmailLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CaseReminderController extends Controller
{
    public function sendManual(Request $request): Response
    {
        $data = $request->validate([
            'case_id' => ['nullable', 'string', 'max:255'],
            'case_name' => ['required', 'string', 'max:255'],
            'recipient_email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'payload' => ['nullable', 'array'],
        ]);

        $reminder = CaseReminder::create([
            'user_id' => $request->user()->id,
            'case_id' => $data['case_id'] ?? null,
            'case_name' => $data['case_name'],
            'recipient_email' => $data['recipient_email'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'payload' => $data['payload'] ?? null,
            'type' => 'manual',
            'status' => 'processing',
            'processing_started_at' => now(),
        ]);

        $emailLog = EmailLog::create([
            'case_reminder_id' => $reminder->id,
            'to_email' => $data['recipient_email'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'status' => 'pending',
        ]);

        try {
            \Illuminate\Support\Facades\Log::info('Sending manual case reminder email', [
                'reminder_id' => $reminder->id,
                'to_email' => $emailLog->to_email,
                'subject' => $emailLog->subject,
            ]);

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

            \Illuminate\Support\Facades\Log::info('Manual case reminder email sent successfully', [
                'reminder_id' => $reminder->id,
            ]);

            return response([
                'success' => true,
                'data' => $reminder->fresh(),
                'message' => 'Email sent successfully.',
            ], 200);
        } catch (\Throwable $throwable) {
            \Illuminate\Support\Facades\Log::error('Failed to send manual case reminder', [
                'reminder_id' => $reminder->id,
                'error' => $throwable->getMessage(),
                'trace' => $throwable->getTraceAsString(),
            ]);

            $emailLog->update([
                'status' => 'failed',
                'error_message' => $throwable->getMessage(),
            ]);

            $reminder->update([
                'status' => 'failed',
                'last_error' => $throwable->getMessage(),
            ]);

            return response([
                'success' => false,
                'data' => $reminder->fresh(),
                'message' => 'Email sending failed: '.$throwable->getMessage(),
            ], 500);
        }
    }

    public function schedule(Request $request): Response
    {
        $data = $request->validate([
            'case_id' => ['nullable', 'string', 'max:255'],
            'case_name' => ['required', 'string', 'max:255'],
            'recipient_email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'payload' => ['nullable', 'array'],
            'scheduled_for' => ['nullable', 'date', 'after:now'],
        ]);

        $reminder = CaseReminder::create([
            'user_id' => $request->user()->id,
            'case_id' => $data['case_id'] ?? null,
            'case_name' => $data['case_name'],
            'recipient_email' => $data['recipient_email'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'payload' => $data['payload'] ?? null,
            'type' => 'scheduled',
            'status' => 'processing',
            'processing_started_at' => now(),
            'scheduled_for' => $data['scheduled_for'] ?? now(),
        ]);

        $emailLog = \App\Models\EmailLog::create([
            'case_reminder_id' => $reminder->id,
            'to_email' => $data['recipient_email'],
            'subject' => $data['subject'],
            'body' => $data['body'],
            'status' => 'pending',
        ]);

        try {
            SendCaseReminderEmail::dispatch($reminder, $emailLog)->now();

            return response([
                'success' => true,
                'data' => $reminder->fresh(),
                'message' => 'Email sent successfully.',
            ], 200);
        } catch (\Throwable $throwable) {
            \Illuminate\Support\Facades\Log::error('Failed to send case reminder', [
                'reminder_id' => $reminder->id,
                'error' => $throwable->getMessage(),
            ]);

            $emailLog->update([
                'status' => 'failed',
                'error_message' => $throwable->getMessage(),
            ]);

            $reminder->update([
                'status' => 'failed',
                'last_error' => $throwable->getMessage(),
            ]);

            return response([
                'success' => false,
                'data' => $reminder->fresh(),
                'message' => 'Email sending failed: '.$throwable->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, CaseReminder $caseReminder): Response
    {
        $this->ensureOwner($request, $caseReminder);

        return response([
            'success' => true,
            'data' => $caseReminder,
        ]);
    }

    public function cancel(Request $request, CaseReminder $caseReminder): Response
    {
        $this->ensureOwner($request, $caseReminder);

        if ($caseReminder->type !== 'scheduled' || ! in_array($caseReminder->status, ['scheduled', 'processing'], true)) {
            return response([
                'success' => false,
                'message' => 'Reminder cannot be cancelled.',
            ], 422);
        }

        $caseReminder->update([
            'status' => 'cancelled',
        ]);

        return response([
            'success' => true,
            'data' => $caseReminder->fresh(),
            'message' => 'Reminder cancelled successfully.',
        ]);
    }

    private function ensureOwner(Request $request, CaseReminder $caseReminder): void
    {
        if ($caseReminder->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}

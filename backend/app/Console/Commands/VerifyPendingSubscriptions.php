<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerifyPendingSubscriptions extends Command
{
    protected $signature = 'subscriptions:verify-pending';
    protected $description = 'Verify and automatically confirm pending subscriptions from Flutterwave';

    private $flutterwaveSecretKey;
    private $flutterwaveBaseUrl = 'https://api.flutterwave.com/v3';

    public function __construct()
    {
        parent::__construct();
        $this->flutterwaveSecretKey = config('services.flutterwave.secret_key');
    }

    public function handle()
    {
        $this->info('Starting verification of pending subscriptions...');

        $pendingSubscriptions = Subscription::where('status', 'pending')
            ->whereNotNull('flutterwave_tx_ref')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        if ($pendingSubscriptions->isEmpty()) {
            $this->info('No pending subscriptions found.');
            return 0;
        }

        $confirmed = 0;
        $failed = 0;

        foreach ($pendingSubscriptions as $subscription) {
            try {
                $this->info("Verifying subscription {$subscription->id} with tx_ref: {$subscription->flutterwave_tx_ref}");

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->flutterwaveSecretKey,
                ])->get($this->flutterwaveBaseUrl . '/transactions/verify_by_reference', [
                    'tx_ref' => $subscription->flutterwave_tx_ref,
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if (($data['status'] ?? null) === 'success' && ($data['data']['status'] ?? null) === 'successful') {
                        $subscription->update([
                            'status' => 'active',
                            'flutterwave_transaction_id' => (string) ($data['data']['id'] ?? ''),
                            'amount' => $data['data']['amount'] ?? $subscription->amount,
                            'currency' => $data['data']['currency'] ?? $subscription->currency,
                            'start_date' => now(),
                            'end_date' => $this->calculateEndDate($subscription->billing_cycle),
                            'auto_renew' => true,
                        ]);

                        Subscription::where('user_id', $subscription->user_id)
                            ->where('id', '!=', $subscription->id)
                            ->where('status', '=', 'active')
                            ->update(['status' => 'expired']);

                        $this->info("✓ Subscription {$subscription->id} confirmed and activated");
                        $confirmed++;
                    } else {
                        $status = $data['data']['status'] ?? 'unknown';
                        $this->warn("✗ Subscription {$subscription->id} payment not confirmed. Status: {$status}");
                        $failed++;
                    }
                } else {
                    $statusCode = $response->status();
                    $this->error("✗ Failed to verify subscription {$subscription->id}: HTTP {$statusCode}");
                    $failed++;
                }
            } catch (\Exception $e) {
                Log::error('Error verifying pending subscription', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage(),
                ]);
                $this->error("✗ Exception verifying subscription {$subscription->id}: {$e->getMessage()}");
                $failed++;
            }
        }

        $this->info("Verification complete. Confirmed: {$confirmed}, Failed: {$failed}");

        return 0;
    }

    private function calculateEndDate($billingCycle)
    {
        return $billingCycle === 'yearly'
            ? now()->addYear()
            : now()->addMonth();
    }
}

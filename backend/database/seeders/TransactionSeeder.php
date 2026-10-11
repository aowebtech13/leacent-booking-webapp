<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have users with profiles
        $eligibleUsers = User::query()->with('profile')->get();

        if ($eligibleUsers->isEmpty()) {
            return;
        }

        foreach ($eligibleUsers as $user) {
            $profile = $user->profile;
            if (! $profile) {
                continue;
            }

            // Seed a credit and debit for each user profile.
            $base = 'wallet_tx_seed_' . $user->id;

            $creditRef = $base . '_credit';
            $debitRef = $base . '_debit';

            WalletTransaction::firstOrCreate(
                ['user_id' => $user->id, 'reference' => $creditRef],
                [
                    'user_id' => $user->id,
                    'amount' => 100000.00,
                    'type' => 'credit',
                    'description' => 'Seed credit',
                    'reference' => $creditRef,
                ]
            );

            WalletTransaction::firstOrCreate(
                ['user_id' => $user->id, 'reference' => $debitRef],
                [
                    'user_id' => $user->id,
                    'amount' => 25000.00,
                    'type' => 'debit',
                    'description' => 'Seed debit',
                    'reference' => $debitRef,
                ]
            );
        }
    }
}


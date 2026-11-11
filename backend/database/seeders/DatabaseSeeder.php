<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\UserRole;
use Database\Seeders\AuthorSeeder;
use Database\Seeders\BookSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PaymentTransactionSeeder;
use Database\Seeders\TransactionSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $legacyAdminEmails = ['firstbornpublishing923@gmail.com', 'firstbornpublishing923@gmail.com'];
        User::whereIn('email', $legacyAdminEmails)->update(['email' => 'firstbornpublishing923@gmail.com']);
        Profile::whereIn('email', $legacyAdminEmails)->update(['email' => 'firstbornpublishing923@gmail.com']);

        // Create/update demo user with known credentials
        $demoUser = User::updateOrCreate(
            ['email' => 'demo@lvsdrinks.com'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('demo123'),
                'email_verified_at' => now(),
            ]
        );

        // Create profile for demo user
        Profile::firstOrCreate(
            ['user_id' => $demoUser->id],
            [
                'user_id' => $demoUser->id,
                'email' => $demoUser->email,
                'full_name' => $demoUser->name,
            ]
        );

        // Add points to demo user (idempotent: sets balance rather than incrementing)
        $demoUser->profile->update(['points' => 500]);

        // Assign user role
        UserRole::firstOrCreate(
            ['user_id' => $demoUser->id],
            [
                'user_id' => $demoUser->id,
                'role' => 'user',
            ]
        );

        // Create/update admin demo user
        $adminUser = User::updateOrCreate(
            ['email' => 'firstbornpublishing923@gmail.com'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Create profile for admin user
        Profile::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'user_id' => $adminUser->id,
                'email' => $adminUser->email,
                'full_name' => $adminUser->name,
            ]
        );

        // Assign admin role
        UserRole::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'user_id' => $adminUser->id,
                'role' => 'admin',
            ]
        );

        // Seed authors (must run before books so author_id links resolve)
        $this->call(AuthorSeeder::class);

        // Seed categories
        $this->call(CategorySeeder::class);

        // Seed books
        $this->call(BookSeeder::class);

        // Seed point packages
        $this->call(BookPlanSeeder::class);

        // Seed transaction history
        $this->call(TransactionSeeder::class);
        $this->call(PaymentTransactionSeeder::class);
    }
}



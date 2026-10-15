<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\UserRole;
use App\Models\Subscription;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TagSeeder;
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
        $legacyAdminEmails = ['mictomonbespoke@gmail.com', 'mictomonbespoke@gmail.com'];
        User::whereIn('email', $legacyAdminEmails)->update(['email' => 'mictomonbespoke@gmail.com']);
        Profile::whereIn('email', $legacyAdminEmails)->update(['email' => 'mictomonbespoke@gmail.com']);

        // Create demo user with known credentials
        $demoUser = User::firstOrCreate(
            ['email' => 'demo@lvsdrinks.com'],
            [
                'name' => 'Demo User',
                'email' => 'demo@lvsdrinks.com',
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

        // Assign user role
        UserRole::firstOrCreate(
            ['user_id' => $demoUser->id],
            [
                'user_id' => $demoUser->id,
                'role' => 'user',
            ]
        );

        // Create subscription
        Subscription::firstOrCreate(
            ['user_id' => $demoUser->id],
            [
                'user_id' => $demoUser->id,
                'plan' => 'Free',
                'status' => 'active',
                'start_date' => now(),
            ]
        );

        // Create admin demo user
        $adminUser = User::firstOrCreate(
            ['email' => 'mictomonbespoke@gmail.com'],
            [
                'name' => 'Admin Demo',
                'email' => 'mictomonbespoke@gmail.com',
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

        // Create Team subscription for admin
        Subscription::firstOrCreate(
            ['user_id' => $adminUser->id],
            [
                'user_id' => $adminUser->id,
                'plan' => 'Team',
                'status' => 'active',
                'billing_cycle' => 'monthly',
                'amount' => 25 * 1500,
                'currency' => 'NGN',
'start_date' => now(),
            ]
        );

        // Seed categories
        $this->call(CategorySeeder::class);

        // Seed tags
        $this->call(TagSeeder::class);
    }
}
}



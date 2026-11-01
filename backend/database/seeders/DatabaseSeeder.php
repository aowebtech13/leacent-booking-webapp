<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\UserRole;
use Database\Seeders\CategorySeeder;
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

        // Create admin demo user
        $adminUser = User::firstOrCreate(
            ['email' => 'firstbornpublishing923@gmail.com'],
            [
                'name' => 'Admin Demo',
                'email' => 'firstbornpublishing923@gmail.com',
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

        // Seed categories
        $this->call(CategorySeeder::class);

        // Seed point packages
        $this->call(BookPlanSeeder::class);
    }
}



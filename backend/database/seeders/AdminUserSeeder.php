<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = (string) env('ADMIN_EMAIL');
        $password = (string) env('ADMIN_PASSWORD');

        if ($email === '' || $password === '') {
            throw new RuntimeException(
                'ADMIN_EMAIL and ADMIN_PASSWORD must be configured before seeding the administrator.'
            );
        }

        $admin = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'FreelanceFlow Admin'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        if (
            $admin->wasRecentlyCreated
            || !Hash::check($password, (string) $admin->password)
        ) {
            $admin->forceFill([
                'password' => Hash::make($password),
            ])->save();
        }
    }
}
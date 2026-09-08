<?php

namespace Database\Seeders;

use App\Models\BusinessProfile;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@freelanceflow.com'],
            [
                'name' => 'FreelanceFlow Admin',
                'email_verified_at' => now(),
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
            ]
        );

        // Demo freelancer
        $user = User::factory()->create([
            'name' => 'Demo Freelancer',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'freelancer',
        ]);

        BusinessProfile::create([
            'user_id' => $user->id,
            'business_name' => 'Demo Freelance Studio',
            'email' => $user->email,
            'phone' => '0712345678',
            'address' => 'Nairobi, Kenya',
            'currency' => 'KES',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            $client = Client::factory()->create([
                'user_id' => $user->id,
            ]);

            $invoice = Invoice::factory()->create([
                'client_id' => $client->id,
            ]);

            InvoiceItem::factory()
                ->count(2)
                ->create([
                    'invoice_id' => $invoice->id,
                ]);
        }
    }
}
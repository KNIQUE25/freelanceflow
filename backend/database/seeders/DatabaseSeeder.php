<?php

namespace Database\Seeders;

use App\Models\BusinessProfile;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo Freelancer',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => 'password',
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
            $client = Client::factory()->create(['user_id' => $user->id]);
            $invoice = Invoice::factory()->create(['client_id' => $client->id]);
            InvoiceItem::factory()->count(2)->create(['invoice_id' => $invoice->id]);
        }
    }
}

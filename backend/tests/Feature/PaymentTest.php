<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_completed_payment_updates_invoice_balance(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);
        $invoice = Invoice::factory()->create(['client_id' => $client->id, 'subtotal' => 100, 'tax' => 0, 'total' => 100, 'paid_amount' => 0, 'status' => 'unpaid']);

        $this->actingAs($user)->postJson('/api/payments', [
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'payment_date' => now()->toDateString(),
            'method' => 'cash',
        ])->assertCreated();

        $this->assertDatabaseHas('invoices', ['id' => $invoice->id, 'status' => 'paid', 'paid_amount' => 100]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvoiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_an_invoice_with_items(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->postJson('/api/invoices', [
            'client_id' => $client->id,
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(7)->toDateString(),
            'tax' => 10,
            'items' => [
                ['description' => 'Website design', 'quantity' => 2, 'unit_price' => 50],
                ['description' => 'Hosting', 'quantity' => 1, 'unit_price' => 30],
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.subtotal', 130)
            ->assertJsonPath('data.total', 140)
            ->assertJsonPath('data.invoice_number', 'INV-' . now()->year . '-0001');
    }
}

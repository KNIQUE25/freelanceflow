<?php

namespace Database\Factories;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<\App\Models\Payment> */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'amount' => fake()->randomFloat(2, 50, 500),
            'payment_date' => now()->subDays(fake()->numberBetween(0, 30))->toDateString(),
            'method' => fake()->randomElement(['cash', 'bank_transfer', 'card', 'mobile_money']),
            'reference' => fake()->optional()->uuid(),
            'status' => 'completed',
            'provider' => null,
            'provider_transaction_id' => null,
            'checkout_request_id' => null,
            'merchant_request_id' => null,
            'phone_number' => null,
            'completed_at' => now(),
        ];
    }
}

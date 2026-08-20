<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSequence;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Invoice> */
class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $year = (int) now()->year;
        $sequence = fake()->unique()->numberBetween(1, 9999);
        $subtotal = fake()->randomFloat(2, 100, 10000);
        $tax = fake()->randomFloat(2, 0, 1000);
        InvoiceSequence::query()->updateOrCreate(['year' => $year], ['last_number' => max($sequence, (int) (InvoiceSequence::find($year)?->last_number ?? 0))]);

        return [
            'client_id' => Client::factory(),
            'invoice_number' => 'INV-' . $year . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT),
            'invoice_year' => $year,
            'number_sequence' => $sequence,
            'issue_date' => now()->subDays(fake()->numberBetween(1, 30))->toDateString(),
            'due_date' => now()->addDays(fake()->numberBetween(1, 30))->toDateString(),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => round($subtotal + $tax, 2),
            'paid_amount' => 0,
            'status' => 'unpaid',
            'note' => fake()->optional()->sentence(5),
        ];
    }
}

<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceSequence;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceService
{
    public function __construct(private AuditService $audit) {}

    public function getAllForUser(int $userId): LengthAwarePaginator
    {
        return Invoice::query()
            ->whereHas('client', fn ($q) => $q->where('user_id', $userId))
            ->with(['client', 'items', 'payments'])
            ->latest('issue_date')
            ->latest('id')
            ->paginate(15);
    }

    public function find(Invoice $invoice): Invoice
    {
        return $invoice->load(['client', 'items', 'payments']);
    }

    public function create(int $userId, array $data): Invoice
    {
        return DB::transaction(function () use ($userId, $data) {
            $client = Client::query()->whereKey($data['client_id'])->where('user_id', $userId)->first();
            if (!$client) {
                throw ValidationException::withMessages(['client_id' => ['The selected client does not belong to you.']]);
            }

            $subtotal = $this->calculateSubtotal($data['items']);
            $tax = round((float) ($data['tax'] ?? 0), 2);
            $total = round($subtotal + $tax, 2);
            $year = (int) date('Y', strtotime($data['issue_date']));
            [$sequence, $invoiceNumber] = $this->nextInvoiceNumber($year);

            $invoice = Invoice::create([
                'client_id' => $client->id,
                'invoice_number' => $invoiceNumber,
                'invoice_year' => $year,
                'number_sequence' => $sequence,
                'issue_date' => $data['issue_date'],
                'due_date' => $data['due_date'],
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'paid_amount' => 0,
                'status' => 'unpaid',
                'note' => $data['note'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                $invoice->items()->create([
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'total' => round((float) $item['quantity'] * (float) $item['unit_price'], 2),
                ]);
            }

            $invoice->load(['client', 'items', 'payments']);
            $this->audit->log('invoice.created', $invoice, null, $invoice->toArray(), $userId);
            return $invoice;
        });
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            $old = $invoice->load('items')->toArray();

            if (isset($data['items'])) {
                $subtotal = $this->calculateSubtotal($data['items']);
                $tax = round((float) ($data['tax'] ?? $invoice->tax), 2);
                $invoice->items()->delete();
                foreach ($data['items'] as $item) {
                    $invoice->items()->create([
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'total' => round((float) $item['quantity'] * (float) $item['unit_price'], 2),
                    ]);
                }
                $invoice->subtotal = $subtotal;
                $invoice->tax = $tax;
                $invoice->total = round($subtotal + $tax, 2);
            } elseif (array_key_exists('tax', $data)) {
                $invoice->tax = round((float) $data['tax'], 2);
                $invoice->total = round((float) $invoice->subtotal + (float) $invoice->tax, 2);
            }

            if (isset($data['issue_date'])) $invoice->issue_date = $data['issue_date'];
            if (isset($data['due_date'])) $invoice->due_date = $data['due_date'];
            if ($invoice->due_date->lt($invoice->issue_date)) {
                throw ValidationException::withMessages(['due_date' => ['Due date cannot be before issue date.']]);
            }
            if (array_key_exists('note', $data)) $invoice->note = $data['note'];

            if ((float) $invoice->paid_amount > (float) $invoice->total) {
                throw ValidationException::withMessages(['items' => ['The invoice total cannot be lower than the amount already paid.']]);
            }

            $this->refreshStatus($invoice);
            $invoice->save();
            $invoice->load(['client', 'items', 'payments']);
            $this->audit->log('invoice.updated', $invoice, $old, $invoice->toArray());
            return $invoice;
        });
    }

    public function delete(Invoice $invoice): void
    {
        DB::transaction(function () use ($invoice) {
            $old = $invoice->toArray();
            $this->audit->log('invoice.deleted', $invoice, $old, null);
            $invoice->delete();
        });
    }

    private function calculateSubtotal(array $items): float
    {
        return round(collect($items)->sum(fn ($item) => (float) $item['quantity'] * (float) $item['unit_price']), 2);
    }

    private function nextInvoiceNumber(int $year): array
    {
        InvoiceSequence::query()->insertOrIgnore([
            'year' => $year,
            'last_number' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $sequenceRow = InvoiceSequence::query()->whereKey($year)->lockForUpdate()->firstOrFail();
        $sequenceRow->last_number++;
        $sequenceRow->save();

        $sequence = $sequenceRow->last_number;
        return [$sequence, 'INV-' . $year . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT)];
    }

    private function refreshStatus(Invoice $invoice): void
    {
        $paid = (float) $invoice->paid_amount;
        $total = (float) $invoice->total;
        if ($paid <= 0) { $invoice->status = 'unpaid'; return; }
        if ($paid >= $total) { $invoice->paid_amount = $total; $invoice->status = 'paid'; return; }
        $invoice->status = $invoice->due_date?->isPast() ? 'overdue' : 'partially_paid';
    }
}

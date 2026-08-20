<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentService
{
    public function __construct(private AuditService $audit) {}

    public function getAllForUser(int $userId): LengthAwarePaginator
    {
        return Payment::query()
            ->whereHas('invoice.client', fn ($q) => $q->where('user_id', $userId))
            ->with(['invoice.client'])
            ->latest('payment_date')
            ->latest('id')
            ->paginate(15);
    }

    public function find(Payment $payment): Payment
    {
        return $payment->load(['invoice.client']);
    }

    public function create(int $userId, array $data): Payment
    {
        return DB::transaction(function () use ($userId, $data) {
            $invoice = Invoice::query()
                ->whereKey($data['invoice_id'])
                ->whereHas('client', fn ($q) => $q->where('user_id', $userId))
                ->lockForUpdate()
                ->first();

            if (!$invoice) {
                throw ValidationException::withMessages(['invoice_id' => ['The selected invoice does not belong to you.']]);
            }

            $amount = round((float) $data['amount'], 2);
            $remaining = round((float) $invoice->total - (float) $invoice->paid_amount, 2);
            if ($amount > $remaining) {
                throw ValidationException::withMessages(['amount' => ['Payment exceeds the remaining balance of KES ' . number_format($remaining, 2) . '.']]);
            }

            $status = $data['status'] ?? 'completed';
            if (($data['method'] ?? '') === 'mobile_money') $status = 'pending';

            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $amount,
                'payment_date' => $data['payment_date'],
                'method' => $data['method'],
                'reference' => $data['reference'] ?? null,
                'status' => $status,
                'provider' => $data['provider'] ?? null,
                'provider_transaction_id' => $data['provider_transaction_id'] ?? null,
                'checkout_request_id' => $data['checkout_request_id'] ?? null,
                'merchant_request_id' => $data['merchant_request_id'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
            ]);

            if ($status === 'completed') {
                $invoice->paid_amount = round((float) $invoice->paid_amount + $amount, 2);
                $this->updateInvoiceStatus($invoice);
                $invoice->save();
                $payment->completed_at = now();
                $payment->save();
            }

            $payment->load(['invoice.client']);
            $this->audit->log('payment.created', $payment, null, $payment->toArray(), $userId);
            return $payment;
        });
    }

    public function markAsCompleted(Payment $payment, ?string $providerTransactionId = null): void
    {
        DB::transaction(function () use ($payment, $providerTransactionId) {
            $payment = Payment::query()->lockForUpdate()->findOrFail($payment->id);
            if ($payment->status === 'completed') return;

            $invoice = Invoice::query()->lockForUpdate()->findOrFail($payment->invoice_id);
            $remaining = round((float) $invoice->total - (float) $invoice->paid_amount, 2);
            if ((float) $payment->amount > $remaining) {
                $payment->status = 'failed';
                $payment->save();
                return;
            }

            $invoice->paid_amount = round((float) $invoice->paid_amount + (float) $payment->amount, 2);
            $this->updateInvoiceStatus($invoice);
            $invoice->save();

            $payment->status = 'completed';
            $payment->completed_at = now();
            if ($providerTransactionId) $payment->provider_transaction_id = $providerTransactionId;
            $payment->save();
        });
    }

    public function markAsFailed(Payment $payment, ?string $reason = null): void
    {
        $payment->status = 'failed';
        $payment->reference = $reason ? trim(($payment->reference ? $payment->reference . ' | ' : '') . $reason) : $payment->reference;
        $payment->save();
    }

    public function delete(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $payment = Payment::query()->lockForUpdate()->findOrFail($payment->id);
            $invoice = Invoice::query()->lockForUpdate()->findOrFail($payment->invoice_id);
            $old = $payment->toArray();

            if ($payment->status === 'completed') {
                $invoice->paid_amount = max(0, round((float) $invoice->paid_amount - (float) $payment->amount, 2));
                $this->updateInvoiceStatus($invoice);
                $invoice->save();
            }

            $payment->delete();
            $this->audit->log('payment.deleted', null, $old, null);
        });
    }

    private function updateInvoiceStatus(Invoice $invoice): void
    {
        $paid = (float) $invoice->paid_amount;
        $total = (float) $invoice->total;
        if ($paid <= 0) { $invoice->status = 'unpaid'; return; }
        if ($paid >= $total) { $invoice->paid_amount = $total; $invoice->status = 'paid'; return; }
        $invoice->status = $invoice->due_date?->isPast() ? 'overdue' : 'partially_paid';
    }
}

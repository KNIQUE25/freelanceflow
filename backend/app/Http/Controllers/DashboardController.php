<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $userId = auth()->id();
        $invoiceQuery = Invoice::query()->whereHas('client', fn ($q) => $q->where('user_id', $userId));

        $totals = (clone $invoiceQuery)->selectRaw('COALESCE(SUM(total), 0) invoice_value, COALESCE(SUM(paid_amount), 0) paid_amount')->first();
        $recent = (clone $invoiceQuery)->with('client')->latest('issue_date')->latest('id')->limit(5)->get();
        $payments = Payment::query()->whereHas('invoice.client', fn ($q) => $q->where('user_id', $userId))->where('status', 'completed')->sum('amount');

        return response()->json([
            'total_clients' => auth()->user()->clients()->count(),
            'total_invoices' => (clone $invoiceQuery)->count(),
            'invoice_value' => (float) ($totals->invoice_value ?? 0),
            'paid_amount' => (float) ($totals->paid_amount ?? 0),
            'total_payments' => (float) $payments,
            'outstanding_balance' => (float) (($totals->invoice_value ?? 0) - ($totals->paid_amount ?? 0)),
            'invoices' => [
                'paid' => (clone $invoiceQuery)->where('status', 'paid')->count(),
                'unpaid' => (clone $invoiceQuery)->where('status', 'unpaid')->count(),
                'partially_paid' => (clone $invoiceQuery)->where('status', 'partially_paid')->count(),
                'overdue' => (clone $invoiceQuery)->where('status', 'overdue')->count(),
            ],
            'recent_invoices' => $recent->map(fn ($invoice) => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'client_name' => $invoice->client?->name,
                'total' => (float) $invoice->total,
                'status' => $invoice->status,
                'due_date' => $invoice->due_date?->toDateString(),
            ]),
        ]);
    }
}

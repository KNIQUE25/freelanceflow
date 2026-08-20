<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function revenue(Request $request): JsonResponse
    {
        $period = $request->string('period', 'monthly')->toString();
        $allowed = ['daily', 'weekly', 'monthly', 'yearly'];
        if (!in_array($period, $allowed, true)) $period = 'monthly';

        $invoices = Invoice::query()
            ->whereHas('client', fn ($q) => $q->where('user_id', auth()->id()))
            ->where('status', 'paid')
            ->get(['issue_date', 'total']);

        $grouped = $invoices->groupBy(function (Invoice $invoice) use ($period) {
            $date = $invoice->issue_date;
            return match ($period) {
                'daily' => $date->format('Y-m-d'),
                'weekly' => $date->format('o') . '-W' . $date->format('W'),
                'yearly' => $date->format('Y'),
                default => $date->format('Y-m'),
            };
        })->map(fn ($items, $key) => [
            'period' => $key,
            'revenue' => round($items->sum(fn ($invoice) => (float) $invoice->total), 2),
        ])->values();

        return response()->json($grouped);
    }

    public function invoiceStatus(): JsonResponse
    {
        $stats = Invoice::query()
            ->whereHas('client', fn ($q) => $q->where('user_id', auth()->id()))
            ->get(['status', 'total'])
            ->groupBy('status')
            ->map(fn ($items, $status) => [
                'status' => $status,
                'count' => $items->count(),
                'total' => round($items->sum(fn ($invoice) => (float) $invoice->total), 2),
            ])->values();

        return response()->json($stats);
    }

    public function clientSummary(): JsonResponse
    {
        $clients = Client::query()
            ->where('user_id', auth()->id())
            ->with('invoices:id,client_id,total')
            ->get()
            ->map(fn ($client) => [
                'id' => $client->id,
                'name' => $client->name,
                'invoice_count' => $client->invoices->count(),
                'total_invoice_value' => round($client->invoices->sum(fn ($invoice) => (float) $invoice->total), 2),
            ]);

        return response()->json($clients);
    }

    public function paymentMethods(): JsonResponse
    {
        $payments = Payment::query()
            ->whereHas('invoice.client', fn ($q) => $q->where('user_id', auth()->id()))
            ->where('status', 'completed')
            ->get(['method', 'amount']);

        return response()->json($payments->groupBy('method')->map(fn ($items, $method) => [
            'method' => $method,
            'count' => $items->count(),
            'total' => round($items->sum(fn ($payment) => (float) $payment->amount), 2),
        ])->values());
    }
}

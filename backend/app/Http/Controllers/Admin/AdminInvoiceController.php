<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class AdminInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with(['client.user'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->when($request->search, fn($q, $search) => $q->where('invoice_number', 'LIKE', "%{$search}%"))
            ->latest()
            ->paginate(20);
        return response()->json($invoices);
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['client.user', 'items', 'payments']);
        return response()->json($invoice);
    }
}
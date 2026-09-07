<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['invoice.client.user'])
            ->when($request->method, fn($q, $method) => $q->where('method', $method))
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(20);
        return response()->json($payments);
    }

    public function show(Payment $payment)
    {
        $payment->load(['invoice.client.user']);
        return response()->json($payment);
    }
}
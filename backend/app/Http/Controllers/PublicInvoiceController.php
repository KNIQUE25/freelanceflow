<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicInvoiceController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Display a public invoice by UUID (no authentication required)
     */
    public function show($uuid)
    {
        $invoice = Invoice::with(['client', 'items', 'payments'])
            ->where('public_uuid', $uuid)
            ->firstOrFail();

        return response()->json([
            'invoice' => [
                'id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'issue_date' => $invoice->issue_date->toDateString(),
                'due_date' => $invoice->due_date->toDateString(),
                'subtotal' => (float) $invoice->subtotal,
                'tax' => (float) $invoice->tax,
                'total' => (float) $invoice->total,
                'paid_amount' => (float) $invoice->paid_amount,
                'balance' => (float) ($invoice->total - $invoice->paid_amount),
                'status' => $invoice->status,
                'note' => $invoice->note,
                'client' => [
                    'name' => $invoice->client->name,
                    'email' => $invoice->client->email,
                    'phone' => $invoice->client->phone,
                ],
                'items' => $invoice->items->map(function ($item) {
                    return [
                        'description' => $item->description,
                        'quantity' => $item->quantity,
                        'unit_price' => (float) $item->unit_price,
                        'total' => (float) $item->total,
                    ];
                }),
                'payments' => $invoice->payments->map(function ($payment) {
                    return [
                        'amount' => (float) $payment->amount,
                        'date' => $payment->payment_date->toDateString(),
                        'method' => $payment->method,
                    ];
                }),
            ],
        ]);
    }

    /**
     * Initiate M-Pesa payment from public link
     */
    public function pay(Request $request, $uuid)
    {
        $invoice = Invoice::where('public_uuid', $uuid)->firstOrFail();

        $validated = $request->validate([
            'phone' => ['required', 'string', 'regex:/^(0|254)?[0-9]{9,12}$/'],
        ]);

        // Check if invoice is already paid
        if ($invoice->paid_amount >= $invoice->total) {
            return response()->json([
                'message' => 'This invoice is already paid.',
            ], 422);
        }

        // Check remaining balance
        $remainingBalance = $invoice->total - $invoice->paid_amount;

        // Create pending payment
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'amount' => $remainingBalance,
            'payment_date' => now()->toDateString(),
            'method' => 'mobile_money',
            'status' => 'pending',
            'provider' => 'mpesa',
            'phone_number' => $validated['phone'],
            'reference' => 'PUBLIC-' . $invoice->invoice_number,
        ]);

        try {
            // Get M-Pesa service
            $mpesaService = app(\App\Services\MpesaService::class);

            $response = $mpesaService->stkPush(
                $validated['phone'],
                $remainingBalance,
                $invoice->id,
                'Invoice Payment - ' . $invoice->invoice_number
            );

            if (isset($response['CheckoutRequestID'])) {
                $payment->checkout_request_id = $response['CheckoutRequestID'];
                $payment->merchant_request_id = $response['MerchantRequestID'] ?? null;
                $payment->save();
            }

            return response()->json([
                'message' => 'STK Push initiated. Please check your phone for the M-Pesa prompt.',
                'checkout_request_id' => $response['CheckoutRequestID'] ?? null,
                'payment_id' => $payment->id,
            ]);

        } catch (\Exception $e) {
            $payment->status = 'failed';
            $payment->save();

            Log::error('Public M-Pesa payment failed', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Payment request failed: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Check payment status
     */
    public function status($uuid)
    {
        $invoice = Invoice::where('public_uuid', $uuid)->firstOrFail();

        return response()->json([
            'status' => $invoice->status,
            'paid_amount' => (float) $invoice->paid_amount,
            'balance' => (float) ($invoice->total - $invoice->paid_amount),
            'is_paid' => $invoice->paid_amount >= $invoice->total,
        ]);
    }
}
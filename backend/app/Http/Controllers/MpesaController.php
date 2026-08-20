<?php

namespace App\Http\Controllers;

use App\Http\Requests\MpesaPaymentRequest;
use App\Models\Payment;
use App\Services\MpesaService;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function __construct(private MpesaService $mpesa, private PaymentService $paymentService) {}

    public function stkPush(MpesaPaymentRequest $request): JsonResponse
    {
        $data = $request->validated();
        $payment = null;

        try {
            $payment = $this->paymentService->create(auth()->id(), [
                'invoice_id' => $data['invoice_id'],
                'amount' => $data['amount'],
                'payment_date' => now()->toDateString(),
                'method' => 'mobile_money',
                'reference' => 'M-Pesa STK Push',
                'phone_number' => $data['phone'],
            ]);

            $result = $this->mpesa->stkPush($data['phone'], (float) $data['amount'], (string) $data['invoice_id']);
            $payment->update([
                'checkout_request_id' => $result['CheckoutRequestID'] ?? null,
                'merchant_request_id' => $result['MerchantRequestID'] ?? null,
            ]);

            return response()->json([
                'message' => 'STK Push initiated successfully. Check the phone for the M-Pesa prompt.',
                'payment_id' => $payment->id,
                'checkout_request_id' => $result['CheckoutRequestID'] ?? null,
            ], 202);
        } catch (\Throwable $e) {
            if ($payment) $this->paymentService->markAsFailed($payment, $e->getMessage());
            throw $e;
        }
    }

    public function callback(Request $request): JsonResponse
    {
        $this->mpesa->handleCallback($request->all());
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);
    }
}

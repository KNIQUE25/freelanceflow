<?php

namespace App\Http\Controllers;

use App\Services\MpesaService;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected PaymentService $service;

    public function __construct(PaymentService $service)
    {
        $this->service = $service;
    }

    public function index(): AnonymousResourceCollection
    {
        $payments = $this->service->getAllForUser(auth()->id());
        return PaymentResource::collection($payments);
    }

    public function store(StorePaymentRequest $request): JsonResponse
    {
        $payment = $this->service->create(auth()->id(), $request->validated());
        return (new PaymentResource($payment))->response()->setStatusCode(201);
    }

    public function show(Payment $payment): PaymentResource
    {
        $this->authorize('view', $payment);
        return new PaymentResource($this->service->find($payment));
    }

    public function destroy(Payment $payment): JsonResponse
    {
        $this->authorize('delete', $payment);
        $this->service->delete($payment);
        return response()->json(['message' => 'Payment deleted successfully.']);
    }
    

public function verify(Payment $payment, MpesaService $mpesaService)
{
    $this->authorize('view', $payment);

    // Only pending M-Pesa payments can be verified
    if ($payment->status !== 'pending' || $payment->method !== 'mobile_money') {
        return response()->json(['message' => 'Payment is not pending or not M-Pesa.'], 422);
    }

    if (!$payment->checkout_request_id) {
        return response()->json(['message' => 'No checkout request ID found.'], 422);
    }

    try {
       $result = $mpesaService->queryStatus(
    $payment->checkout_request_id
);

$resultCode = (string) ($result['ResultCode'] ?? '');

if ($resultCode === '0') {

    $paymentService = app(PaymentService::class);

    $paymentService->markAsCompleted($payment);

    return response()->json([
        'message' => 'Payment verified and marked as completed.',
        'status' => 'completed',
    ]);

} elseif ($resultCode === '1037') {

    return response()->json([
        'message' => 'Payment is still pending.',
        'status' => 'pending',
    ]);

} else {

    $paymentService = app(PaymentService::class);

    $paymentService->markAsFailed(
        $payment,
        $result['ResultDesc'] ?? 'Transaction failed'
    );

    return response()->json([
        'message' => 'Payment failed: ' .
            ($result['ResultDesc'] ?? 'Unknown error'),
        'status' => 'failed',
    ]);
}
    } catch (\Exception $e) {
        Log::error('Payment verification failed', ['payment_id' => $payment->id, 'error' => $e->getMessage()]);
        return response()->json(['message' => 'Error verifying payment: ' . $e->getMessage()], 500);
    }
}
}
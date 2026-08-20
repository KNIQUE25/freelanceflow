<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MpesaService
{
    private string $consumerKey;
    private string $consumerSecret;
    private string $shortcode;
    private string $passkey;
    private string $callbackUrl;
    private string $baseUrl;

    public function __construct()
    {
        $this->consumerKey = (string) config('mpesa.consumer_key');
        $this->consumerSecret = (string) config('mpesa.consumer_secret');
        $this->shortcode = (string) config('mpesa.shortcode');
        $this->passkey = (string) config('mpesa.passkey');
        $this->callbackUrl = (string) config('mpesa.callback_url');
        $this->baseUrl = config('mpesa.env') === 'production'
            ? 'https://api.safaricom.co.ke'
            : 'https://sandbox.safaricom.co.ke';
    }

    public function configured(): bool
    {
        return $this->consumerKey !== '' && $this->consumerSecret !== '' && $this->shortcode !== '' && $this->passkey !== '' && $this->callbackUrl !== '';
    }

    public function stkPush(string $phone, float $amount, string $invoiceId, string $reference = 'Invoice Payment'): array
    {
        if (!$this->configured()) {
            throw ValidationException::withMessages(['phone' => ['M-Pesa is not configured. Add the Daraja credentials to your .env file first.']]);
        }

        $phone = $this->formatPhoneNumber($phone);
        $token = $this->getAccessToken();
        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $payload = [
            'BusinessShortCode' => $this->shortcode,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => (int) round($amount),
            'PartyA' => $phone,
            'PartyB' => $this->shortcode,
            'PhoneNumber' => $phone,
            'CallBackURL' => $this->callbackUrl,
            'AccountReference' => 'INV-' . $invoiceId,
            'TransactionDesc' => $reference,
        ];

        $response = Http::timeout(20)->withToken($token)->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);
        if ($response->failed()) {
            Log::error('M-Pesa STK Push failed', ['response' => $response->body()]);
            throw ValidationException::withMessages(['phone' => ['M-Pesa request failed. Please try again.']]);
        }

        $result = $response->json();
        if (($result['ResponseCode'] ?? '') !== '0') {
            throw ValidationException::withMessages(['phone' => [$result['ResponseDescription'] ?? 'M-Pesa request failed.']]);
        }
        return $result;
    }

    public function handleCallback(array $payload): void
    {
        $body = $payload['Body']['stkCallback'] ?? null;
        if (!$body) {
            Log::warning('Invalid M-Pesa callback structure', ['payload' => $payload]);
            return;
        }

        $checkoutRequestId = $body['CheckoutRequestID'] ?? null;
        if (!$checkoutRequestId) return;

        $payment = Payment::where('checkout_request_id', $checkoutRequestId)->first();
        if (!$payment || $payment->status === 'completed') return;

        $paymentService = app(PaymentService::class);
        if ((int) ($body['ResultCode'] ?? 1) === 0) {
            $receipt = collect($body['CallbackMetadata']['Item'] ?? [])->firstWhere('Name', 'MpesaReceiptNumber')['Value'] ?? null;
            $paymentService->markAsCompleted($payment, $receipt);
        } else {
            $paymentService->markAsFailed($payment, $body['ResultDesc'] ?? 'M-Pesa payment failed.');
        }
    }

    private function getAccessToken(): string
    {
        $response = Http::timeout(20)->withBasicAuth($this->consumerKey, $this->consumerSecret)
            ->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');
        if ($response->failed()) {
            Log::error('M-Pesa token generation failed', ['response' => $response->body()]);
            throw ValidationException::withMessages(['phone' => ['Unable to authenticate with M-Pesa.']]);
        }
        return (string) $response->json('access_token');
    }

    private function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/\D+/', '', $phone) ?? '';
        if (str_starts_with($phone, '0')) $phone = '254' . substr($phone, 1);
        if (!str_starts_with($phone, '254')) $phone = '254' . $phone;
        return $phone;
    }
}

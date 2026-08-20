<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => (float) $this->amount,
            'payment_date' => $this->payment_date?->toDateString(),
            'method' => $this->method,
            'reference' => $this->reference,
            'status' => $this->status,
            'provider' => $this->provider,
            'provider_transaction_id' => $this->provider_transaction_id,
            'phone_number' => $this->phone_number,
            'completed_at' => $this->completed_at?->toISOString(),
            'invoice' => $this->whenLoaded('invoice', fn () => [
                'id' => $this->invoice->id,
                'invoice_number' => $this->invoice->invoice_number,
                'total' => (float) $this->invoice->total,
                'balance' => (float) max(0, (float) $this->invoice->total - (float) $this->invoice->paid_amount),
                'client' => $this->invoice->client?->name,
            ]),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

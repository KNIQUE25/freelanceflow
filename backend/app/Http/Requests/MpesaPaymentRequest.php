<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpesaPaymentRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'phone' => ['required', 'string', 'regex:/^(?:0|254)7\d{8}$/'],
            'amount' => ['required', 'numeric', 'gt:0'],
        ];
    }
}

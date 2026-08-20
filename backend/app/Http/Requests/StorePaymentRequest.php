<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool { return auth()->check(); }

    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'integer', 'exists:invoices,id'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment_date' => ['required', 'date'],
            'method' => ['required', Rule::in(['cash', 'bank_transfer', 'card', 'mobile_money'])],
            'reference' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::in(['pending', 'completed', 'failed'])],
        ];
    }
}

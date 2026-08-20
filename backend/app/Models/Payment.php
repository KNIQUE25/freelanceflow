<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'amount', 'payment_date', 'method', 'reference', 'status',
        'provider', 'provider_transaction_id', 'checkout_request_id',
        'merchant_request_id', 'phone_number', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'amount' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    public function invoice() { return $this->belongsTo(Invoice::class); }
    public function scopeStatus($query, string $status) { return $query->where('status', $status); }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'invoice_number', 'invoice_year', 'number_sequence',
        'issue_date', 'due_date', 'subtotal', 'tax', 'total', 'paid_amount',
        'status', 'note',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'subtotal' => 'decimal:2',
            'tax' => 'decimal:2',
            'total' => 'decimal:2',
            'paid_amount' => 'decimal:2',
        ];
    }

    public function client() { return $this->belongsTo(Client::class); }
    public function items() { return $this->hasMany(InvoiceItem::class); }
    public function payments() { return $this->hasMany(Payment::class); }

    public function getBalanceAttribute(): float
    {
        return max(0, (float) $this->total - (float) $this->paid_amount);
    }

    public function scopeStatus($query, string $status) { return $query->where('status', $status); }

    public function scopeDueSoon($query, int $days = 7)
    {
        return $query->whereDate('due_date', '<=', now()->addDays($days))
            ->where('status', '!=', 'paid');
    }
}

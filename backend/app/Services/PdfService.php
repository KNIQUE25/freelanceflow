<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    public function generateInvoice(Invoice $invoice): string
    {
        $invoice->load(['client', 'items']);
        $business = auth()->user()->businessProfile;
        return Pdf::loadView('pdf.invoice', compact('invoice', 'business'))->output();
    }
}

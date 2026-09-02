<?php

namespace App\Services;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfService
{
    public function generateInvoice(Invoice $invoice)
    {
        $invoice->load(['client', 'items']);
        $business = auth()->user()->businessProfile;
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice', 'business'));
        return $pdf->output();
    }
}
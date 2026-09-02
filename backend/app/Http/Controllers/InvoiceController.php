<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\PdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected InvoiceService $service;
    protected PdfService $pdfService;

    public function __construct(InvoiceService $service, PdfService $pdfService)
    {
        $this->service = $service;
        $this->pdfService = $pdfService;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $perPage = $request->get('per_page', 15);

        $invoices = $this->service->getAllForUser(
            auth()->id(),
            $search,
            $status,
            $dateFrom,
            $dateTo,
            $perPage
        );
        return InvoiceResource::collection($invoices);
    }

    public function store(StoreInvoiceRequest $request): InvoiceResource
    {
        $invoice = $this->service->create(auth()->id(), $request->validated());
        return new InvoiceResource($invoice);
    }

    public function show(Invoice $invoice): InvoiceResource
    {
        $this->authorize('view', $invoice);
        return new InvoiceResource($this->service->find($invoice));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): InvoiceResource
    {
        $this->authorize('update', $invoice);
        $invoice = $this->service->update($invoice, $request->validated());
        return new InvoiceResource($invoice);
    }

    public function destroy(Invoice $invoice): JsonResponse
    {
        $this->authorize('delete', $invoice);
        $this->service->delete($invoice);
        return response()->json(['message' => 'Invoice deleted successfully.']);
    }

    public function pdf(Invoice $invoice)
{
    $this->authorize('view', $invoice);
    $pdf = $this->pdfService->generateInvoice($invoice);
    return response($pdf, 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="invoice-' . $invoice->invoice_number . '.pdf"',
    ]);
}

    public function publicUrl(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        $url = url('/public/invoice/' . $invoice->public_uuid);
        return response()->json(['url' => $url]);
    }
}
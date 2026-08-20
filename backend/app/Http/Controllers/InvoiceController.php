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
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends Controller
{
    public function __construct(private InvoiceService $service, private PdfService $pdfService) {}

    public function index(): AnonymousResourceCollection
    {
        return InvoiceResource::collection($this->service->getAllForUser(auth()->id()));
    }

    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        return (new InvoiceResource($this->service->create(auth()->id(), $request->validated())))->response()->setStatusCode(201);
    }

    public function show(Invoice $invoice): InvoiceResource
    {
        $this->authorize('view', $invoice);
        return new InvoiceResource($this->service->find($invoice));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): InvoiceResource
    {
        $this->authorize('update', $invoice);
        return new InvoiceResource($this->service->update($invoice, $request->validated()));
    }

    public function destroy(Invoice $invoice): JsonResponse
    {
        $this->authorize('delete', $invoice);
        $this->service->delete($invoice);
        return response()->json(['message' => 'Invoice deleted successfully.']);
    }

    public function pdf(Invoice $invoice): Response
    {
        $this->authorize('view', $invoice);
        return response($this->pdfService->generateInvoice($invoice), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="invoice-' . $invoice->invoice_number . '.pdf"',
        ]);
    }
}

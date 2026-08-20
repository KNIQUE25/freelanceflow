<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1e293b; font-size: 12px; }
        .header { border-bottom: 3px solid #4f46e5; padding-bottom: 18px; margin-bottom: 24px; }
        h1 { margin: 0; color: #312e81; }
        h2 { margin: 0 0 8px; }
        .muted { color: #64748b; }
        .row { width: 100%; }
        .col { width: 48%; display: inline-block; vertical-align: top; }
        table { width: 100%; border-collapse: collapse; margin-top: 22px; }
        th, td { padding: 9px; border-bottom: 1px solid #e2e8f0; text-align: left; }
        th { background: #f8fafc; }
        .money { text-align: right; }
        .total td { font-weight: bold; font-size: 13px; }
    </style>
</head>
<body>
    @php($businessName = $business?->business_name ?? config('app.name'))
    <div class="header">
        <h1>{{ $businessName }}</h1>
        @if($business?->email)<div class="muted">{{ $business->email }}</div>@endif
        @if($business?->phone)<div class="muted">{{ $business->phone }}</div>@endif
        @if($business?->address)<div class="muted">{{ $business->address }}</div>@endif
    </div>

    <div class="row">
        <div class="col">
            <h2>Invoice {{ $invoice->invoice_number }}</h2>
            <div class="muted">Client: {{ $invoice->client->name }}</div>
        </div>
        <div class="col" style="text-align:right">
            <div>Issued: {{ $invoice->issue_date->format('d/m/Y') }}</div>
            <div>Due: {{ $invoice->due_date->format('d/m/Y') }}</div>
            <div>Status: {{ ucfirst(str_replace('_', ' ', $invoice->status)) }}</div>
        </div>
    </div>

    <table>
        <thead><tr><th>Description</th><th>Qty</th><th class="money">Unit Price</th><th class="money">Total</th></tr></thead>
        <tbody>
        @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ number_format((float) $item->quantity, 2) }}</td>
                <td class="money">{{ number_format((float) $item->unit_price, 2) }}</td>
                <td class="money">{{ number_format((float) $item->total, 2) }}</td>
            </tr>
        @endforeach
        <tr><td colspan="3"><strong>Subtotal</strong></td><td class="money">{{ number_format((float) $invoice->subtotal, 2) }}</td></tr>
        <tr><td colspan="3"><strong>Tax</strong></td><td class="money">{{ number_format((float) $invoice->tax, 2) }}</td></tr>
        <tr class="total"><td colspan="3">Total</td><td class="money">{{ number_format((float) $invoice->total, 2) }}</td></tr>
        <tr><td colspan="3">Paid</td><td class="money">{{ number_format((float) $invoice->paid_amount, 2) }}</td></tr>
        <tr class="total"><td colspan="3">Balance</td><td class="money">{{ number_format((float) $invoice->balance, 2) }}</td></tr>
        </tbody>
    </table>

    @if($invoice->note)
        <p style="margin-top:24px"><strong>Note:</strong> {{ $invoice->note }}</p>
    @endif
</body>
</html>

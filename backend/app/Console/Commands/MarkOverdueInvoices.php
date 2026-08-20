<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Notifications\InvoiceOverdueNotification;
use Illuminate\Console\Command;

class MarkOverdueInvoices extends Command
{
    protected $signature = 'invoices:mark-overdue';
    protected $description = 'Mark unpaid invoices as overdue.';

    public function handle(): int
    {
        $count = 0;
        Invoice::query()->whereDate('due_date', '<', today())->whereIn('status', ['unpaid', 'partially_paid'])->with('client.user')->chunkById(100, function ($invoices) use (&$count) {
            foreach ($invoices as $invoice) {
                $invoice->status = 'overdue';
                $invoice->save();
                $invoice->client?->user?->notify(new InvoiceOverdueNotification($invoice));
                $count++;
            }
        });
        $this->info("Marked {$count} invoice(s) overdue.");
        return self::SUCCESS;
    }
}

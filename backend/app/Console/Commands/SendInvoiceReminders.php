<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Notifications\InvoiceDueNotification;
use Illuminate\Console\Command;

class SendInvoiceReminders extends Command
{
    protected $signature = 'invoices:send-reminders';
    protected $description = 'Send invoice reminders for invoices due in 1, 3 or 7 days.';

    public function handle(): int
    {
        $count = 0;
        foreach ([1, 3, 7] as $days) {
            $target = today()->addDays($days);
            Invoice::query()->whereDate('due_date', $target)->whereIn('status', ['unpaid', 'partially_paid'])->with('client.user')->chunkById(100, function ($invoices) use (&$count, $days) {
                foreach ($invoices as $invoice) {
                    $invoice->client?->user?->notify(new InvoiceDueNotification($invoice, $days));
                    $count++;
                }
            });
        }
        $this->info("Sent {$count} reminder(s).");
        return self::SUCCESS;
    }
}

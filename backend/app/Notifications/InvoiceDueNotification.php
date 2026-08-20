<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceDueNotification extends Notification
{
    use Queueable;

    public function __construct(private Invoice $invoice, private int $days) {}

    public function via($notifiable): array { return ['database', 'mail']; }

    public function toMail($notifiable): MailMessage
    {
        $when = $this->days === 1 ? 'tomorrow' : "in {$this->days} days";
        return (new MailMessage)
            ->subject("Invoice due {$when}: {$this->invoice->invoice_number}")
            ->line("Invoice {$this->invoice->invoice_number} is due {$when}.")
            ->line('Amount due: KES ' . number_format((float) $this->invoice->balance, 2));
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Invoice due soon',
            'message' => "{$this->invoice->invoice_number} is due in {$this->days} day(s).",
            'invoice_id' => $this->invoice->id,
        ];
    }
}

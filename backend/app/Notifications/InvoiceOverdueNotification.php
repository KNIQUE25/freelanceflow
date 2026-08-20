<?php

namespace App\Notifications;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceOverdueNotification extends Notification
{
    use Queueable;

    public function __construct(private Invoice $invoice) {}

    public function via($notifiable): array { return ['database', 'mail']; }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Invoice overdue: ' . $this->invoice->invoice_number)
            ->line("Invoice {$this->invoice->invoice_number} is now overdue.")
            ->line('Outstanding balance: KES ' . number_format((float) $this->invoice->balance, 2));
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Invoice overdue',
            'message' => "{$this->invoice->invoice_number} is overdue.",
            'invoice_id' => $this->invoice->id,
        ];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public string $messageBody,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New contact form message from {$this->senderName}",
            // Lets you hit "Reply" in your inbox and reply straight to the visitor,
            // while the mail itself is still sent from the verified Brevo sender.
            replyTo: [$this->senderEmail],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact',
            with: [
                'senderName' => $this->senderName,
                'senderEmail' => $this->senderEmail,
                'messageBody' => $this->messageBody,
            ],
        );
    }
}

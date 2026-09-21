<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminPasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $email,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Admin password changed',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-password-changed',
            with: [
                'email' => $this->email,
                'changedAt' => now(),
            ],
        );
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $msg;
    public $subject;

    public function __construct($msg, $subject)
    {
        $this->msg = $msg;
        $this->subject = $subject;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject, // Fixed issue here
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'PRATIK', // Make sure this file exists
            with: [
                'msg' => $this->msg,
                'subject' => $this->subject,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

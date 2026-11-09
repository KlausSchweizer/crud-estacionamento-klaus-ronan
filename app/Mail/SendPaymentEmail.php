<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $generatedPDF;
    public $fileName;

    public function __construct($pdf, $fileName)
    {
        $this->generatedPDF = $pdf;
        $this->fileName = $fileName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seu recibo de pagamento',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-mail',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->generatedPDF->output(), $this->fileName)
                ->withMime('application/pdf'),
        ];
    }
}

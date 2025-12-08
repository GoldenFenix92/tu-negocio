<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Sale;
use Illuminate\Mail\Mailables\Attachment;

class SaleTicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sale;
    public $pdfContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Sale $sale, $pdfContent)
    {
        $this->sale = $sale;
        $this->pdfContent = $pdfContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Ticket de Compra - Folio: ' . $this->sale->folio,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sale_ticket',
            with: [
                'sale' => $this->sale,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, 'ticket-compra-' . $this->sale->folio . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class CleanMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string       $messageSubject,
        public string|array $messageContent,
        public ?string      $actionText = null,
        public ?string      $actionUrl = null,
    )
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->messageSubject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $response = Http::retry(3, 200)
            ->withBasicAuth(config('services.mjml.app_id'), config('services.mjml.secret'))
            ->post('https://api.mjml.io/v1/render', [
                'mjml' => view('mail.clean-mail', [
                    'paragraphs' => is_array($this->messageContent) ? $this->messageContent : [$this->messageContent],
                    'actionText' => $this->actionText,
                    'actionUrl' => $this->actionUrl,
                ])->render(),
            ]);

        return new Content(htmlString: $response->json('html'));
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

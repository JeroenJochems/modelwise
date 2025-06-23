<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsMessage extends Notification
{
    public function __construct(protected string $message) {}

    public function via(object $notifiable): array
    {
        Log::info('Via method called');

        return ['vonage'];
    }

    public function toVonage($notifiable): VonageMessage
    {
        Log::info('Sending to vonage');

        return (new VonageMessage)
            ->content($this->message);
    }
}

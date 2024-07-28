<?php

namespace App\Listeners;

use App\EmailLog;
use Illuminate\Mail\Events\MessageSent;

class LogEmailSent
{
    public function handle(MessageSent $event)
    {
        $subject        = $event->data['messageSubject'];
        $toArr          = $this->parseAddresses($event->message->getTo());
        $from           = $event->message->getFrom()[0]->getAddress();
        $body           = $event->data['messageContent'];

        foreach ($toArr as $to) {
            EmailLog::create([
                'from'      => $from,
                'to'        => $to,
                'subject'   => $subject,
                'body'      => $body,
            ]);
        }

        return false;
    }

    private function parseAddresses(array $array): array
    {
        $parsed = [];
        foreach($array as $address) {
            $parsed[] = $address->getAddress();
        }
        return $parsed;
    }

    private function parseBodyText($body): string
    {
        return preg_replace('~[\r\n]+~', '<br>', $body);
    }
}

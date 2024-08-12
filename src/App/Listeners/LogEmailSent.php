<?php

namespace App\Listeners;

use App\EmailLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Events\MessageSent;

class LogEmailSent implements ShouldQueue
{
    public function handle(MessageSent $event)
    {
        $subject        = $event->data['messageSubject'];
        $toArr          = $this->parseAddresses($event->message->getTo());
        $from           = $event->message->getFrom()[0]->getAddress();
        $body           = $event->data['messageContent'];

        if (is_array($body)) {
            $body = implode("\n\n", $body);
        }

        foreach ($toArr as $to) {

            if (str_contains($to, '@un-knownagency.com')) {
                return false;
            }

            if (str_contains($to, '@modelwise.agency')) {
                return false;
            }

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

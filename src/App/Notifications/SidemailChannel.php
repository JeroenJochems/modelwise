<?php

namespace App\Notifications;

use App\Notifications\SidemailData\SidemailNotification;
use Domain\Profiles\Models\Model;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;

class SidemailChannel
{
    public function send(Model|Authenticatable $notifiable, SidemailNotification $notification): void
    {
        $message = $notification->toSideMail($notifiable);

        if (!env("SIDEMAIL_API_KEY") || app()->environment('testing')) {
            return;
        }

        $context_options = [
            "http" => [
                "method" => "POST",
                "header" => [
                    "Content-type: application/json",
                    "Authorization: Bearer " . env("SIDEMAIL_API_KEY"),
                ],
                "content" => json_encode([
                    "fromName" => "Modelwise",
                    "fromAddress" => "hello@6fipo.via.sidemail.net",
                    "toAddress" => $message->recipient->email,
                    "templateName" => implode(".", [$message->template, $message->recipient->preferred_language]),
                    "templateProps" => [...$message->data, "first_name" => $message->recipient->first_name ?? ""],
                ]),
            ]
        ];

        $fp = fopen("https://api.sidemail.io/v1/email/send", "r", false, stream_context_create($context_options));

        fclose($fp);
    }
}

<?php

namespace Domain\Models\Actions;

use Domain\Models\Data\Mail\MailData;
use Exception;

class SendMail
{
    public function __invoke(MailData $data) {

        if (!env("SIDEMAIL_API_KEY")) {
            return;
        }
        $props = $data->props ? $data->props->toArray() : [];

        $context_options = [
            "http" => [
                "method" => "POST",
                "header" => [
                    "Content-type: application/json",
                    "Authorization: Bearer " . env("SIDEMAIL_API_KEY"),
                ],
                "content" => json_encode([
                    "fromName" => "Modelwise",
                    "fromAddress" => "bas@modelwise.agency",
                    "toAddress" => $data->model->email,
                    "templateName" => "Registration completed",
                    "templateProps" => [
                        ...$props,
                        'first_name' => $data->model->first_name,
                    ],
                ]),
                "ignore_errors" => true,
            ]
        ];

        $fp = fopen("https://api.sidemail.io/v1/email/send", "r", false, stream_context_create($context_options));

        if ($fp === FALSE) {
            throw new Exception("Unexpected error making the Sidemail API request.");
        }

        $response = json_decode(stream_get_contents($fp));
        fclose($fp);

        return $response;
    }
}

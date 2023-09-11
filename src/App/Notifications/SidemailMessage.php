<?php

namespace App\Notifications;

use App\Notifications\SidemailData\SidemailRecipient;

class SidemailMessage
{
    public function __construct(
        public SidemailRecipient $recipient,
        public string $template,
        public array $data
    ) {}
}

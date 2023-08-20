<?php

namespace Domain\Profiles\Data\Mail;

use Spatie\LaravelData\Data;

class ResetPasswordMailData extends Data
{
    public function __construct(
        public string $reset_password_url,
    ) {}
}

<?php

namespace Domain\Models\Data\Mail;

use Spatie\LaravelData\Data;

class ResetPasswordMailData extends Data implements Mailabledata
{
    public function __construct(
        public string $reset_password_url,
    ) {}
}

<?php

namespace App\Notifications\SidemailData;

class ResetPasswordMailData
{
    public string $template = 'Password reset';

    public function __construct(
        public string $reset_password_url,
    ) {}
}

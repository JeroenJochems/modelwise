<?php

namespace Domain\Models\Data;

enum Templates: string
{
    case registrationCompleted = 'Registration completed';
    case passwordReset = 'Password reset';
}

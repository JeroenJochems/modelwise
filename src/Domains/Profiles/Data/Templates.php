<?php

namespace Domain\Profiles\Data;

enum Templates: string
{
    case registrationCompleted = 'Registration completed';
    case passwordReset = 'Password reset';
    case shortlisted = 'Shortlisted';
}

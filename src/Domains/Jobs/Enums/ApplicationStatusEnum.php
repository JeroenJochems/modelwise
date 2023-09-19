<?php

namespace Domain\Jobs\Enums;

use Domain\Work\Models\Application;

/** @typescript  */
enum ApplicationStatusEnum: string
{
    case PENDING = "pending";
    case ACCEPTED = "accepted";
    case REJECTED = "rejected";
    case CANCELLED = "cancelled";

    public static function forApplication(Application $application)
    {
        return self::PENDING;
    }
}

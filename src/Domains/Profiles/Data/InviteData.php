<?php

namespace Domain\Profiles\Data;

use Domain\Jobs\Data\RoleData;
use Spatie\LaravelData\Data;

/** @typescript */
class InviteData extends Data
{
    public function __construct(
        public int $id,
        public RoleData $role,
    ) { }
}

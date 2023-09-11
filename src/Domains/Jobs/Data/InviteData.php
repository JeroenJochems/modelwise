<?php

namespace Domain\Jobs\Data;

use Domain\Profiles\Data\ModelData;
use Spatie\LaravelData\Data;

/** @typescript */
class InviteData extends Data
{
    public function __construct(
        public int $id,
    ) { }
}

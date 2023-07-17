<?php

namespace Domain\Jobs\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ClientData extends Data
{
    public function __construct(
        public string $name,
    ) { }
}

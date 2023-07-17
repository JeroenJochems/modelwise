<?php

namespace Domain\Jobs\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class BrandData extends Data
{
    public function __construct(
        public string $name,
    ) { }
}

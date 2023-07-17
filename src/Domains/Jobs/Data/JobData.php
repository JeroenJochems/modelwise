<?php

namespace Domain\Jobs\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class JobData extends Data
{
    public function __construct(
        public string $title,
        public string $description,
        public ?BrandData $brand,
        public ?ClientData $client,
    ) { }
}

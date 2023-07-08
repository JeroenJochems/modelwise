<?php

namespace Domain\Models\Data\Mail;

use Spatie\LaravelData\Data;

class ShortlistedMailData extends Data
{
    public function __construct(
        public string $brand,
        public string $job_title,
        public string $url,
        public string $date,
    ) {}
}

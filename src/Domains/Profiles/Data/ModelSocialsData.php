<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ModelSocialsData extends Data
{
    public function __construct(
        public ?string $instagram,
        public ?string $tiktok,
        public ?string $website,
        public ?string $showreel_link,
    ) {
    }
}

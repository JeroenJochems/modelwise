<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

/** @typescript */
class ModelSocialsData extends Data
{
    public function __construct(
        #[Rule(['required_without:tiktok'])]
        public ?string $instagram,
        #[Rule(['required_without:instagram'])]
        public ?string $tiktok,

        public ?string $website,
    ) {
    }
}

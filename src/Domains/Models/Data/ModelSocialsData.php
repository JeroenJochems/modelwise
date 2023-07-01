<?php

namespace Domain\Models\Data;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

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

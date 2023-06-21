<?php

namespace Domain\Models\Data;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class ModelSocialsData extends Data
{
    public function __construct(
        #[Rule(['required_without:tiktok', 'min:2'])]
        public ?string $instagram,

        #[Rule(['required_without:instagram', 'min:2'])]
        public ?string $tiktok,

        #[Rule(['min:10', 'url'])]
        public ?string $website,
    ) {
    }
}

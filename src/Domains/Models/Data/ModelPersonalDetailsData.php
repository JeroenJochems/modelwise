<?php

namespace Domain\Models\Data;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class ModelPersonalDetailsData extends Data
{
    public function __construct(
        #[Rule(['required', 'min:2'])]
        public ?string $first_name,

        #[Rule(['required', 'min:2'])]
        public ?string $last_name,

        #[Rule(['required', 'min:10'])]
        public ?string $phone_number,

        public ?string $location,
    ) {
    }
}

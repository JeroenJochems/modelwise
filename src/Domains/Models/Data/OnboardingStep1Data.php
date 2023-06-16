<?php

namespace Domain\Models\Data;

use Livewire\Wireable;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class OnboardingStep1Data extends Data implements Wireable
{
    use WireableData;

    public function __construct(

        #[Rule(['required', 'min:2'])]
        public ?string $first_name,

        public ?string $last_name,

        public ?string $phone_number,

        public ?string $location,

    ) {}
}

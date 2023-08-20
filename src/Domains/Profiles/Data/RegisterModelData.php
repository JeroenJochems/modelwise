<?php

namespace Domain\Profiles\Data;

use Livewire\Wireable;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

/** @typescript */
class RegisterModelData extends Data
{
    public function __construct(
        #[Rule(['email', 'unique:models,email'])]
        public string $email,
        #[Rule(['required', 'confirmed', 'min:8'])]
        public ?string $password,
    ) {
    }
}

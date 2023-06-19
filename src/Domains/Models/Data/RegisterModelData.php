<?php

namespace Domain\Models\Data;

use Livewire\Wireable;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Concerns\WireableData;
use Spatie\LaravelData\Data;

class RegisterModelData extends Data implements Wireable
{
    use WireableData;

    public function __construct(
        #[Rule(['email', 'unique:models,email'])]
        public string $email,
        #[Rule(['required', 'confirmed', 'min:8'])]
        public ?string $password,
    ) {
    }
}

<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Data;

/** @typescript */
class RegisterModelData extends Data
{
    #[WithoutValidation]
    public array $viewedRoles = [];

    public function __construct(
        #[Rule(['email:rfc,dns', 'unique:models,email'])]
        public string $email,
        #[Rule(['required', 'confirmed', 'min:8'])]
        public ?string $password,
    ) { }
}

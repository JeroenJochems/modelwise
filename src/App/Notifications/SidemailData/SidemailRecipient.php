<?php

namespace App\Notifications\SidemailData;

use Domain\Profiles\Models\Model;
use Support\User;

class SidemailRecipient
{
    public function __construct(
        public string $email,
        public ?string $first_name,
        public string $preferred_language,
    ) {}

    public static function fromUser(User $user): self
    {
        return new self(
            $user->email,
            $user->name,
            "nl",
        );
    }

    public static function fromModel(Model $model): self
    {
        return new self(
            $model->email,
            $model->first_name,
            "nl",
        );
    }
}

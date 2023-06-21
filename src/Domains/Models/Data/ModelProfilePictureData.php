<?php

namespace Domain\Models\Data;

use Spatie\LaravelData\Data;

class ModelProfilePictureData extends Data
{
    public function __construct(
        public string $profile_picture

    ) {
    }
}

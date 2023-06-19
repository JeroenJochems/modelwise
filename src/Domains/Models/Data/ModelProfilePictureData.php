<?php

namespace Domain\Models\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ModelProfilePictureData extends Data
{
    public function __construct(
        public UploadedFile $profile_picture

    ) {
    }
}

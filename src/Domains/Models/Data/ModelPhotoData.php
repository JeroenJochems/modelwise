<?php

namespace Domain\Models\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ModelPhotoData extends Data
{
    public function __construct(
        public ?string $path,
        public string $folder

    ) {
    }
}

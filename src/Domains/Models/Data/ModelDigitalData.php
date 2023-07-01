<?php

namespace Domain\Models\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

class ModelDigitalData extends Data
{
    public function __construct(
        public ?string $path
    ) {
    }
}

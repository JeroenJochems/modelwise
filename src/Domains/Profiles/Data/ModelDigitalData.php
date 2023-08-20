<?php

namespace Domain\Profiles\Data;

use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\Data;

/** @typescript */
class ModelDigitalData extends Data
{
    public function __construct(
        public ?string $path
    ) {
    }
}

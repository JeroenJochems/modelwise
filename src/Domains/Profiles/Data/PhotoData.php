<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class PhotoData extends Data
{
    public function __construct(
        public int $id,
        public string $path,
        public ?string $mime = null,
        public bool $isNew = false,
        public ?string $hash = null,
    )
    { }
}

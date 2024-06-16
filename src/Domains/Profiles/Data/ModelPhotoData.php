<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\Optional;

/** @typescript */
class ModelPhotoData extends Data
{
    #[Computed,Optional]
    public string $pathSquareFace;

    #[Computed]
    public string $mime;

    public function __construct(public int|string $id, public string $path, public ?string $hash)
    {
        $this->mime = "image/*";
        $this->pathSquareFace = $this->path . '?w=600&h=600&fit=crop&crop=faces';
    }
}

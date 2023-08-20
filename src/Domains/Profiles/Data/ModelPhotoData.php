<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class ModelPhotoData extends Data
{
    public function __construct(

        public string $id,
        #[WithTransformer(CdnPathTransformer::class)]
        public string $path,
    ) {
    }
}

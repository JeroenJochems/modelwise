<?php

namespace Domain\Models\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class PhotoData extends Data
{
    public function __construct(
        public int $id,

        #[WithTransformer(CdnPathTransformer::class)]
        public string $path,
    ) { }
}

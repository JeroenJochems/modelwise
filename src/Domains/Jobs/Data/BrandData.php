<?php

namespace Domain\Jobs\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class BrandData extends Data
{
    public function __construct(
        public string $name,

        #[WithTransformer(CdnPathTransformer::class)]
        public ?string $logo,
    ) { }
}

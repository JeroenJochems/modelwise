<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class PhotoData extends Data
{
    #[Computed]
    public string $path_square_face;

    public function __construct(
        public int $id,

        #[WithTransformer(CdnPathTransformer::class)]
        public string $path
    )
    {
        $this->path_square_face = env("CDN_URL").$path . '?w=600&h=600&fit=crop&crop=faces';
    }
}

<?php

namespace Domain\Profiles\Data;

use App\Transformers\CdnPathTransformer;
use Spatie\LaravelData\Attributes\Computed;
use Spatie\LaravelData\Attributes\WithTransformer;
use Spatie\LaravelData\Data;

/** @typescript */
class VideoData extends Data
{
    public function __construct(
        public int $id,
        public string $path,
        public string $mux_id,
    )
    { }
}

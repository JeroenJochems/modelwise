<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class VideoData extends Data
{
    public function __construct(
        public int $id,
        public string $path,
        public ?string $mux_id,
    )
    { }
}

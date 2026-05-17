<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class ModelVideoData extends Data
{
    public function __construct(

        public string $id,
        public ?string $muxId,
        public ?string $muxUploadId,
        public string $muxStatus,
        public ?string $muxError,
        public string $folder,
    ) {
    }
}

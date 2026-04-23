<?php

namespace Domain\Profiles\Data;

use Spatie\LaravelData\Data;

/** @typescript */
class DocumentData extends Data
{
    public function __construct(
        public int $id,
        public string $path,
        public string $url,
        public ?string $filename,
    ) {
    }
}
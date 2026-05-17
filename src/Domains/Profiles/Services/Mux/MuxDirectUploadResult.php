<?php

namespace Domain\Profiles\Services\Mux;

final readonly class MuxDirectUploadResult
{
    public function __construct(
        public string $id,
        public string $url,
    ) {}
}

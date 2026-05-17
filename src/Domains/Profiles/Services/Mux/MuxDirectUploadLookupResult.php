<?php

namespace Domain\Profiles\Services\Mux;

final readonly class MuxDirectUploadLookupResult
{
    public function __construct(
        public string $id,
        public string $status,
        public ?string $assetId,
    ) {}
}

<?php

namespace Domain\Profiles\Services\Mux;

final readonly class MuxAssetResult
{
    public function __construct(
        public string $assetId,
        public ?string $playbackId,
        public string $status,
        public ?string $masterUrl,
        public ?string $masterStatus,
    ) {}
}

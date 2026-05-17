<?php

namespace Domain\Profiles\Services\Mux;

use Illuminate\Support\Str;

class FakeMuxClient implements MuxClient
{
    /** @var array<int, array{cors_origin: string, result: MuxDirectUploadResult}> */
    public array $directUploadCalls = [];

    /** @var array<string, MuxAssetResult> */
    public array $assets = [];

    public ?\Throwable $throwOnCreate = null;

    public function createDirectUpload(string $corsOrigin): MuxDirectUploadResult
    {
        if ($this->throwOnCreate) {
            throw $this->throwOnCreate;
        }

        $result = new MuxDirectUploadResult(
            id: 'fake-upload-' . Str::random(8),
            url: 'https://storage.fake.mux.com/' . Str::random(16),
        );

        $this->directUploadCalls[] = [
            'cors_origin' => $corsOrigin,
            'result' => $result,
        ];

        return $result;
    }

    public function getAsset(string $assetId): MuxAssetResult
    {
        return $this->assets[$assetId] ?? new MuxAssetResult(
            assetId: $assetId,
            playbackId: 'fake-playback-' . Str::substr($assetId, 0, 8),
            status: 'ready',
            masterUrl: null,
            masterStatus: null,
        );
    }

    public function stubAsset(string $assetId, MuxAssetResult $result): void
    {
        $this->assets[$assetId] = $result;
    }

    /** @var array<string, MuxDirectUploadLookupResult> */
    public array $uploadLookups = [];

    public function getDirectUpload(string $uploadId): MuxDirectUploadLookupResult
    {
        return $this->uploadLookups[$uploadId] ?? new MuxDirectUploadLookupResult(
            id: $uploadId,
            status: 'asset_created',
            assetId: 'asset_' . Str::random(8),
        );
    }

    public function stubUploadLookup(string $uploadId, MuxDirectUploadLookupResult $result): void
    {
        $this->uploadLookups[$uploadId] = $result;
    }
}

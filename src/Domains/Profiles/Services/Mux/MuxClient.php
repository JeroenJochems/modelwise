<?php

namespace Domain\Profiles\Services\Mux;

interface MuxClient
{
    public function createDirectUpload(string $corsOrigin): MuxDirectUploadResult;

    public function getAsset(string $assetId): MuxAssetResult;

    public function getDirectUpload(string $uploadId): MuxDirectUploadLookupResult;
}

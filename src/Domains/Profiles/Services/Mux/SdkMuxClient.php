<?php

namespace Domain\Profiles\Services\Mux;

use GuzzleHttp\Client;
use MuxPhp\Api\AssetsApi;
use MuxPhp\Api\DirectUploadsApi;
use MuxPhp\Configuration;
use MuxPhp\Models\CreateAssetRequest;
use MuxPhp\Models\CreateUploadRequest;
use MuxPhp\Models\PlaybackPolicy;

class SdkMuxClient implements MuxClient
{
    public function __construct(
        private readonly string $tokenId,
        private readonly string $tokenSecret,
    ) {}

    public function createDirectUpload(string $corsOrigin): MuxDirectUploadResult
    {
        $assetSettings = new CreateAssetRequest([
            'mp4_support' => 'capped-1080p',
            'max_resolution_tier' => '2160p',
            'master_access' => 'temporary',
            'playback_policy' => [PlaybackPolicy::_PUBLIC],
        ]);

        $request = new CreateUploadRequest([
            'cors_origin' => $corsOrigin,
            'new_asset_settings' => $assetSettings,
        ]);

        $upload = $this->directUploadsApi()->createDirectUpload($request)->getData();

        return new MuxDirectUploadResult(
            id: $upload->getId(),
            url: $upload->getUrl(),
        );
    }

    public function getAsset(string $assetId): MuxAssetResult
    {
        $asset = $this->assetsApi()->getAsset($assetId)->getData();

        $master = $asset->getMaster();
        $playbackIds = $asset->getPlaybackIds();

        return new MuxAssetResult(
            assetId: $asset->getId(),
            playbackId: !empty($playbackIds) ? $playbackIds[0]->getId() : null,
            status: $asset->getStatus(),
            masterUrl: $master?->getUrl(),
            masterStatus: $master?->getStatus(),
        );
    }

    public function getDirectUpload(string $uploadId): MuxDirectUploadLookupResult
    {
        $upload = $this->directUploadsApi()->getDirectUpload($uploadId)->getData();

        return new MuxDirectUploadLookupResult(
            id: $upload->getId(),
            status: $upload->getStatus(),
            assetId: $upload->getAssetId(),
        );
    }

    private function configuration(): Configuration
    {
        return Configuration::getDefaultConfiguration()
            ->setUsername($this->tokenId)
            ->setPassword($this->tokenSecret);
    }

    private function directUploadsApi(): DirectUploadsApi
    {
        return new DirectUploadsApi(new Client(), $this->configuration());
    }

    private function assetsApi(): AssetsApi
    {
        return new AssetsApi(new Client(), $this->configuration());
    }
}

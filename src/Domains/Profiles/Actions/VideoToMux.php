<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Video;
use GuzzleHttp\Client;
use MuxPhp\Configuration;
use MuxPhp\Api\AssetsApi;
use MuxPhp\Models\InputSettings;
use MuxPhp\Models\CreateAssetRequest;
use MuxPhp\Models\PlaybackPolicy;

class VideoToMux
{
    public function execute(Video $video)
    {
        $config = Configuration::getDefaultConfiguration()
            ->setUsername(env('MUX_TOKEN_ID'))
            ->setPassword(env('MUX_TOKEN_SECRET'));

        $assetsApi = new AssetsApi(
            new Client(),
            $config
        );

        // Create Asset Request
        $input = new InputSettings(["url" => env("CDN_URL").$video->path]);
        $createAssetRequest = new CreateAssetRequest([
            "input" => $input,
            "playback_policy" => [PlaybackPolicy::_PUBLIC]
        ]);

        // Ingest
        $result = $assetsApi->createAsset($createAssetRequest);

        $video->mux_id = $result->getData()->getPlaybackIds()[0]->getId();
        $video->save();
    }
}

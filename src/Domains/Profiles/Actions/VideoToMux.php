<?php

namespace Domain\Profiles\Actions;

use Domain\Profiles\Models\Video;
use GuzzleHttp\Client;
use MuxPhp\Api\AssetsApi;
use MuxPhp\Configuration;
use MuxPhp\Models\CreateAssetRequest;
use MuxPhp\Models\InputSettings;
use MuxPhp\Models\PlaybackPolicy;
use Spatie\QueueableAction\QueueableAction;

class VideoToMux
{
    use QueueableAction;

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
        $input = new InputSettings(["url" => "https://modelwise.net/".$video->path]);
        $createAssetRequest = new CreateAssetRequest([
            "input" => $input,
            'mp4_support' => 'capped-1080p',
            "playback_policy" => [PlaybackPolicy::_PUBLIC]
        ]);

        // Ingest
        $result = $assetsApi->createAsset($createAssetRequest);

        $video->mux_id = $result->getData()->getPlaybackIds()[0]->getId();
        $video->save();
    }
}

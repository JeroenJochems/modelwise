<?php

namespace Tests\Unit\App\Controllers;

use Domain\Profiles\Actions\VideoToMux;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Video;
use Mockery;

function makeVideo(array $attrs = []): Video
{
    $mock = Mockery::mock(VideoToMux::class);
    $mock->shouldReceive('onQueue')->andReturnSelf();
    $mock->shouldReceive('execute')->andReturnNull();
    app()->instance(VideoToMux::class, $mock);

    $videoable = Model::factory()->createOne();
    $video = new Video();
    $video->videoable()->associate($videoable);
    $video->folder = 'casting_videos';
    $video->path = '';
    foreach ($attrs as $key => $value) {
        $video->setAttribute($key, $value);
    }
    $video->save();

    return $video;
}

function postWebhook(array $payload): \Illuminate\Testing\TestResponse
{
    $secret = 'test-secret';
    config(['services.mux.webhook_secret' => $secret]);

    $body = json_encode($payload);
    $timestamp = time();
    $signature = hash_hmac('sha256', $timestamp . '.' . $body, $secret);

    return test()->postJson(route('webhooks.mux'), $payload, [
        'Mux-Signature' => "t={$timestamp},v1={$signature}",
    ]);
}

test('upload.asset_created updates video with asset id and processing status', function () {
    $video = makeVideo(['mux_upload_id' => 'upl_abc', 'mux_status' => 'pending']);

    postWebhook([
        'type' => 'video.upload.asset_created',
        'data' => [
            'id' => 'upl_abc',
            'asset_id' => 'asset_xyz',
        ],
    ])->assertOk();

    $video->refresh();
    expect($video->mux_asset_id)->toBe('asset_xyz');
    expect($video->mux_status)->toBe('processing');
});

test('asset.ready sets playback id and ready status', function () {
    $video = makeVideo(['mux_asset_id' => 'asset_xyz', 'mux_status' => 'processing']);

    postWebhook([
        'type' => 'video.asset.ready',
        'data' => [
            'id' => 'asset_xyz',
            'playback_ids' => [
                ['id' => 'pb_signed', 'policy' => 'signed'],
                ['id' => 'pb_public', 'policy' => 'public'],
            ],
        ],
    ])->assertOk();

    $video->refresh();
    expect($video->mux_id)->toBe('pb_public');
    expect($video->mux_status)->toBe('ready');
});

test('asset.errored captures error and flips status', function () {
    $video = makeVideo(['mux_asset_id' => 'asset_xyz', 'mux_status' => 'processing']);

    postWebhook([
        'type' => 'video.asset.errored',
        'data' => [
            'id' => 'asset_xyz',
            'errors' => ['messages' => ['Invalid codec']],
        ],
    ])->assertOk();

    $video->refresh();
    expect($video->mux_status)->toBe('errored');
    expect($video->mux_error)->toBe('Invalid codec');
});

test('unknown event type returns 204', function () {
    postWebhook(['type' => 'video.live_stream.connected', 'data' => []])
        ->assertNoContent();
});

test('rejects unsigned webhook', function () {
    config(['services.mux.webhook_secret' => 'test-secret']);

    test()->postJson(route('webhooks.mux'), ['type' => 'video.asset.ready'])
        ->assertStatus(400);
});

test('webhook for unknown upload id returns 200 but does not create rows', function () {
    postWebhook([
        'type' => 'video.upload.asset_created',
        'data' => ['id' => 'unknown_upload', 'asset_id' => 'asset_x'],
    ])->assertOk();

    expect(Video::where('mux_upload_id', 'unknown_upload')->exists())->toBeFalse();
});

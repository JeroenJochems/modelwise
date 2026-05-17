<?php

namespace Tests\Unit\Domains\Profiles\Repositories;

use Domain\Profiles\Actions\VideoToMux;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Video;
use Domain\Profiles\Repositories\VideoRepository;
use Illuminate\Support\Facades\Storage;
use Mockery;

beforeEach(function () {
    Storage::fake('local');

    $mock = Mockery::mock(VideoToMux::class);
    $mock->shouldReceive('onQueue')->andReturnSelf();
    $mock->shouldReceive('execute')->andReturnNull();
    app()->instance(VideoToMux::class, $mock);
});

test('R2 path: moves tmp file to videos folder and creates row', function () {
    $model = Model::factory()->createOne();
    Storage::put('tmp/abc', 'fake-bytes');

    app(VideoRepository::class)->update($model, 'casting_videos', [
        ['id' => 'uuid1', 'path' => 'tmp/abc', 'isNew' => true, 'mime' => 'video/mp4'],
    ]);

    Storage::assertExists('videos/abc');
    expect(Video::where('videoable_id', $model->id)->count())->toBe(1);
});

test('Mux direct upload: creates row with mux_upload_id and processing status, no Storage::move', function () {
    $model = Model::factory()->createOne();

    app(VideoRepository::class)->update($model, 'casting_videos', [
        [
            'id' => 'uuid1',
            'path' => '',
            'muxUploadId' => 'upl_abc',
            'muxStatus' => 'processing',
            'isNew' => true,
            'mime' => 'video/mp4',
        ],
    ]);

    $video = Video::where('mux_upload_id', 'upl_abc')->first();

    expect($video)->not->toBeNull()
        ->and($video->mux_status)->toBe('processing')
        ->and($video->folder)->toBe('casting_videos')
        ->and($video->videoable_id)->toBe($model->id);
});

test('Mux direct upload: idempotent on mux_upload_id (webhook may run first)', function () {
    $model = Model::factory()->createOne();

    $existing = new Video();
    $existing->videoable()->associate($model);
    $existing->folder = 'casting_videos';
    $existing->path = '';
    $existing->setAttribute('mux_upload_id', 'upl_abc');
    $existing->setAttribute('mux_asset_id', 'asset_xyz');
    $existing->setAttribute('mux_status', 'ready');
    $existing->save();

    app(VideoRepository::class)->update($model, 'casting_videos', [
        [
            'id' => 'uuid1',
            'path' => '',
            'muxUploadId' => 'upl_abc',
            'isNew' => true,
            'mime' => 'video/mp4',
        ],
    ]);

    expect(Video::where('mux_upload_id', 'upl_abc')->count())->toBe(1);
    expect(Video::find($existing->id)->mux_status)->toBe('ready');
});

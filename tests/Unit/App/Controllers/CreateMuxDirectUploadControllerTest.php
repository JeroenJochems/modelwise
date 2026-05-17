<?php

namespace Tests\Unit\App\Controllers;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Video;
use Domain\Profiles\Services\Mux\FakeMuxClient;
use Domain\Profiles\Services\Mux\MuxClient;

beforeEach(function () {
    $this->fakeMux = new FakeMuxClient();
    app()->instance(MuxClient::class, $this->fakeMux);
});

test('guests cannot create a direct upload', function () {
    $this->postJson(route('mux.direct-upload'))
        ->assertStatus(401);
});

test('authenticated users get a Mux direct upload url and a draft Video row', function () {
    config(['app.url' => 'https://modelwise.test']);
    $model = Model::factory()->createOne();

    $response = $this->be($model)
        ->postJson(route('mux.direct-upload'))
        ->assertStatus(201)
        ->assertJsonStructure(['upload_id', 'url']);

    expect($this->fakeMux->directUploadCalls)->toHaveCount(1)
        ->and($this->fakeMux->directUploadCalls[0]['cors_origin'])->toBe('https://modelwise.test');

    $uploadId = $response->json('upload_id');
    expect($uploadId)->toBe($this->fakeMux->directUploadCalls[0]['result']->id);
    expect($response->json('url'))->toBe($this->fakeMux->directUploadCalls[0]['result']->url);

    $video = Video::where('mux_upload_id', $uploadId)->first();
    expect($video)->not->toBeNull()
        ->and($video->folder)->toBe(Video::FOLDER_DRAFT)
        ->and($video->mux_status)->toBe('pending')
        ->and($video->videoable_type)->toBe('model')
        ->and($video->videoable_id)->toBe($model->id);
});

test('returns 502 when Mux client throws and creates no draft row', function () {
    $model = Model::factory()->createOne();
    $this->fakeMux->throwOnCreate = new \RuntimeException('mux down');

    $this->be($model)
        ->postJson(route('mux.direct-upload'))
        ->assertStatus(502)
        ->assertJsonStructure(['message']);

    expect(Video::where('mux_status', 'pending')->count())->toBe(0);
});

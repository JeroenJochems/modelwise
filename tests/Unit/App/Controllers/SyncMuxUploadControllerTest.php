<?php

namespace Tests\Unit\App\Controllers;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Video;
use Domain\Profiles\Services\Mux\FakeMuxClient;
use Domain\Profiles\Services\Mux\MuxAssetResult;
use Domain\Profiles\Services\Mux\MuxClient;
use Domain\Profiles\Services\Mux\MuxDirectUploadLookupResult;

beforeEach(function () {
    $this->fakeMux = new FakeMuxClient();
    app()->instance(MuxClient::class, $this->fakeMux);
});

function makeDraftVideoForSync(Model $owner, string $uploadId): Video
{
    $video = new Video();
    $video->videoable()->associate($owner);
    $video->folder = '__draft__';
    $video->path = '';
    $video->setAttribute('mux_upload_id', $uploadId);
    $video->setAttribute('mux_status', 'pending');
    $video->save();

    return $video->refresh();
}

test('guests cannot sync', function () {
    $this->getJson('/mux/uploads/upl_anything/sync')
        ->assertStatus(401);
});

test('unknown upload returns 404', function () {
    $this->be(Model::factory()->createOne())
        ->getJson('/mux/uploads/upl_nope/sync')
        ->assertStatus(404);
});

test('other user cannot sync your upload', function () {
    $owner = Model::factory()->createOne();
    $other = Model::factory()->createOne();
    makeDraftVideoForSync($owner, 'upl_abc');

    $this->be($other)
        ->getJson('/mux/uploads/upl_abc/sync')
        ->assertStatus(403);
});

test('first sync: pending -> processing once Mux reports asset_id', function () {
    $owner = Model::factory()->createOne();
    $video = makeDraftVideoForSync($owner, 'upl_abc');

    $this->fakeMux->stubUploadLookup('upl_abc', new MuxDirectUploadLookupResult(
        id: 'upl_abc', status: 'asset_created', assetId: 'asset_xyz',
    ));
    $this->fakeMux->stubAsset('asset_xyz', new MuxAssetResult(
        assetId: 'asset_xyz', playbackId: null, status: 'preparing', masterUrl: null, masterStatus: null,
    ));

    $this->be($owner)
        ->getJson('/mux/uploads/upl_abc/sync')
        ->assertOk()
        ->assertJson(['status' => 'processing', 'mux_id' => null]);

    $video->refresh();
    expect($video->mux_asset_id)->toBe('asset_xyz')->and($video->mux_status)->toBe('processing');
});

test('second sync: processing -> ready once asset is ready', function () {
    $owner = Model::factory()->createOne();
    $video = makeDraftVideoForSync($owner, 'upl_abc');
    $video->setAttribute('mux_asset_id', 'asset_xyz');
    $video->setAttribute('mux_status', 'processing');
    $video->save();

    $this->fakeMux->stubAsset('asset_xyz', new MuxAssetResult(
        assetId: 'asset_xyz', playbackId: 'pb_public', status: 'ready', masterUrl: null, masterStatus: null,
    ));

    $this->be($owner)
        ->getJson('/mux/uploads/upl_abc/sync')
        ->assertOk()
        ->assertJson(['status' => 'ready', 'mux_id' => 'pb_public']);

    $video->refresh();
    expect($video->mux_id)->toBe('pb_public')->and($video->mux_status)->toBe('ready');
});

test('sync: asset errored is reflected', function () {
    $owner = Model::factory()->createOne();
    $video = makeDraftVideoForSync($owner, 'upl_abc');
    $video->setAttribute('mux_asset_id', 'asset_xyz');
    $video->setAttribute('mux_status', 'processing');
    $video->save();

    $this->fakeMux->stubAsset('asset_xyz', new MuxAssetResult(
        assetId: 'asset_xyz', playbackId: null, status: 'errored', masterUrl: null, masterStatus: null,
    ));

    $this->be($owner)
        ->getJson('/mux/uploads/upl_abc/sync')
        ->assertOk()
        ->assertJson(['status' => 'errored']);

    $video->refresh();
    expect($video->mux_status)->toBe('errored');
});

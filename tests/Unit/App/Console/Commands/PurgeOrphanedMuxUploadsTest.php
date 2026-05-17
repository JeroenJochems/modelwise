<?php

namespace Tests\Unit\App\Console\Commands;

use Carbon\Carbon;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Video;

function makeDraftVideo(Model $owner, Carbon $createdAt, string $folder = Video::FOLDER_DRAFT): Video
{
    $video = new Video();
    $video->videoable()->associate($owner);
    $video->folder = $folder;
    $video->path = '';
    $video->setAttribute('mux_upload_id', 'upl_' . uniqid());
    $video->setAttribute('mux_status', 'pending');
    $video->save();

    Video::where('id', $video->id)->update(['created_at' => $createdAt]);

    return $video->refresh();
}

test('purges draft rows older than 24h, keeps younger ones and non-drafts', function () {
    $model = Model::factory()->createOne();

    $oldDraft = makeDraftVideo($model, now()->subHours(25));
    $youngDraft = makeDraftVideo($model, now()->subHours(2));
    $oldClaimed = makeDraftVideo($model, now()->subHours(25), 'Casting videos');

    $this->artisan('app:purge-orphaned-mux-uploads')
        ->assertSuccessful();

    expect(Video::find($oldDraft->id))->toBeNull();
    expect(Video::find($youngDraft->id))->not->toBeNull();
    expect(Video::find($oldClaimed->id))->not->toBeNull();
});

test('respects --hours option', function () {
    $model = Model::factory()->createOne();
    $draft = makeDraftVideo($model, now()->subHours(2));

    $this->artisan('app:purge-orphaned-mux-uploads', ['--hours' => 1])
        ->assertSuccessful();

    expect(Video::find($draft->id))->toBeNull();
});

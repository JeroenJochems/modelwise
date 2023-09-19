<?php

use Domain\Jobs\Models\Invite;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Application;

test('it selects open invites', function () {
    $invite = Invite::factory()->createOne();

    $invites = Invite::query()->open($invite->model)->count();

    expect($invites)->toEqual(1);
});

test('it skips other models\' invites', function() {
    $invite = Invite::factory()->createOne();
    $me = Model::factory()->createOne();

    $invites = Invite::query()->open($me)->count();

    expect($invites)->toEqual(0);
});

test('it skips invites i have applied for', function () {
    $invite = Invite::factory()->createOne();
    $application = Application::factory()->createOne(['model_id' => $invite->model_id, 'role_id' => $invite->role_id]);

    $invite->application_id = $application->id;
    $invite->save();

    $invites = Invite::query()->open($invite->model)->count();

    expect($invites)->toEqual(0);
});

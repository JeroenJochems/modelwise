<?php

use Domain\Jobs\Models\Invite;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work\Actions\Apply;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertNotNull;

beforeEach(function() {
    $this->role = Role::factory()->createOne();
    $this->model = Model::factory()->createOne();
});

test('it applies', function() {

    (new Apply)($this->model, $this->role);

    assertDatabaseHas("applications", ['role_id' => $this->role->id, 'model_id' => $this->model->id]);
});

test('saves application id to invite', function() {

    $invite = Invite::factory()->createOne([
        'role_id' => $this->role->id,
        'model_id' => $this->model->id,
    ]);

    $application = (new Apply)($this->model, $this->role);

    assertNotNull($application->id);

    assertDatabaseHas("invites", [
        'id' => $invite->id,
        'application_id' => $application->id,
        'model_id' => $this->model->id
    ]);
});



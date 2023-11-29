<?php

use App\ViewModels\ModelRoleViewModel;
use Domain\Jobs\Models\Invite;
use Domain\Work\Models\Pass;
use function Pest\Laravel\be;

test('it sets hasPassed', function() {
    $pass = Pass::factory()->createOne();

    be($pass->model);

    $role = $pass->role;

    $vm = new ModelRoleViewModel($role);
    $this->assertEquals(true, $vm->hasPassed);
});


test('it hasPassed is false by default', function() {

    $invite = Invite::factory()->createOne();

    be($invite->model);

    $role = $invite->role;

    $vm = new ModelRoleViewModel($role);
    $this->assertEquals(false, $vm->hasPassed);
});


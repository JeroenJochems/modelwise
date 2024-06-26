<?php

namespace Tests\Work2\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Actions\AddToRole;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AddToRoleTest extends TestCase
{
    public function test_it_works()
    {
        [$role, $model] = $this->init();

        app(AddToRole::class)->execute($role, $model);

        $this->assertDatabaseHas('listings', [
            'role_id' => $role->id,
            'model_id' => $model->id,
            'invited_at' => null,
        ]);
    }

    public function test_it_sends_no_mails()
    {
        [$role, $model] = $this->init();

        app(AddToRole::class)->execute($role, $model);

        Mail::assertNothingQueued();
    }

    private function init(): array
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        Mail::fake();

        return [$role, $model];
    }


}

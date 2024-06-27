<?php

namespace Tests\Unit\App\Controllers;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Tests\TestCase;

class ModelControllerTest extends TestCase
{
    public function test_it_redirects_to_recently_viewed_role()
    {
        $model = Model::factory()->createOne();
        $role = Role::factory()->createOne();

        $model->role_views()->create([
            'role_id' => $role->id,
        ]);

        $response = $this
            ->actingAs($model)
            ->get(route('onboarding.thanks'));

        $response->assertRedirect(route('applications.create', $role->id));

    }
}

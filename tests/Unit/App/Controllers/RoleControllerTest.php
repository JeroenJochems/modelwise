<?php

namespace Tests\Unit\App\Controllers;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class RoleControllerTest extends TestCase
{
    public function test_not_listed()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        $this->be($model)
            ->get(route('roles.show', $role))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Roles/Show')
                ->has("viewModel", fn(AssertableInertia $page) => $page
                    ->has('role')
                    ->whereType('listing', 'null')
                    ->has('shootDates')
                    ->where('hasApplied', false)
                    ->where('isHired', false)
                )
            );
    }

    public function test_listed()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        Listing::create([
            'model_id' => $model->id,
            'role_id' => $role->id,
        ]);

        $this->be($model)
            ->get(route('roles.show', $role))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Roles/Show')
                ->has("viewModel", fn(AssertableInertia $page) => $page
                    ->has('role')
                    ->where('listing.status', 'New')
                    ->has('shootDates')
                    ->where('hasApplied', false)
                    ->where('isHired', false)
                )
            );
    }

    public function test_applied()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        Listing::create([
            'model_id' => $model->id,
            'role_id' => $role->id,
            'applied_at' => now(),
        ]);

        $this->be($model)
            ->get(route('roles.show', $role))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Roles/Show')
                ->has("viewModel", fn(AssertableInertia $page) => $page
                    ->has('role')
                    ->where('listing.status', 'Applied')
                    ->has('shootDates')
                    ->where('hasApplied', true)
                    ->where('isHired', false)
                )
            );
    }
    public function test_hired()
    {
        $role = Role::factory()->createOne([
            'extra_fields' => ['casting_photos' => true, 'casting_videos' => true],
            'casting_photo_instructions' => "Please upload a photo",
            'casting_video_instructions' => "Please upload a video",
        ]);
        $model = Model::factory()->createOne();

        Listing::create([
            'model_id' => $model->id,
            'role_id' => $role->id,
            'hired_at' => now(),
        ]);

        $this->be($model)
            ->get(route('roles.show', $role))
            ->assertInertia(fn(AssertableInertia $page) => $page
                ->component('Roles/Show')
                ->has("viewModel", fn(AssertableInertia $page) => $page
                    ->has('role')
                    ->where('listing.status', 'Hired')
                    ->has('shootDates')
                    ->where('hasApplied', false)
                    ->where('isHired', true)
                )
            );
    }
}

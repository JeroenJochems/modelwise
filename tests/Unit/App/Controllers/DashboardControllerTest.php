<?php

namespace Tests\Unit\App\Controllers;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Illuminate\Support\Collection;
use Inertia\Testing\AssertableInertia as Assert;

class DashboardControllerTest extends \Tests\TestCase
{
    public function test_it_shows_recently_viewed_role()
    {
        list($model, $role) = $this->prep();

        $model->role_views()->create(['role_id' => $role->id]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 1)
                ->has('vm.openApplications', 0)
                ->has('vm.openInvites', 0)
            );
    }


    public function test_it_shows_invites()
    {
        list($model, $role) = $this->prep();

        $model->invites()->create(['role_id' => $role->id]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.openApplications', 0)
                ->has('vm.openInvites', 1)
            );
    }

    public function test_it_shows_applications()
    {
        list($model, $role) = $this->prep();

        $model->applications()->create(['role_id' => $role->id]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.openApplications', 1)
                ->has('vm.openInvites', 0)
                ->has('vm.hires', 0)
            );
    }

    public function test_it_hides_rejected_applications()
    {
        list($model, $role) = $this->prep();

        $application = $model->applications()->create(['role_id' => $role->id]);
        $application->rejection()->create();

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.openApplications', 0)
                ->has('vm.openInvites', 0)
                ->has('vm.hires', 0)
            );
    }
    public function test_it_shows_hires()
    {
        list($model, $role) = $this->prep();

        $application = $model->applications()->create(['role_id' => $role->id]);
        $application->hire()->create();

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.openApplications', 0)
                ->has('vm.openInvites', 0)
                ->has('vm.hires', 1)
            );
    }

    /**
     * @return array
     */
    protected function prep(): array
    {
        $model = Model::factory()->createOne();
        $role = Role::factory()->createOne();

        $this->be($model);
        $this->withoutMiddleware();
        return array($model, $role);
    }
}

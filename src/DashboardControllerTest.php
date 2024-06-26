<?php

namespace src;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    public function test_it_shows_recently_viewed_role()
    {
        list($model, $role) = $this->prep();

        $model->role_views()->create(['role_id' => $role->id]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 1)
                ->has('vm.listings', 0)
            );
    }

    public function test_it_shows_invites()
    {
        list($model, $role) = $this->prep();

        $invite = $model->listings()->create([
            'role_id' => $role->id,
            'invited_at' => now(),
        ]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.listings', 1)
            );
    }

    public function test_it_shows_applications()
    {
        list($model, $role) = $this->prep();
        $role->update(['end_date' => now()->subWeek()]);

        $model->listings()->create([
            'role_id' => $role->id,
            'hired_at' => now(),
        ]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.listings', 1)
            );
    }

    public function test_it_hides_rejected_applications()
    {
        list($model, $role) = $this->prep();

        $model->listings()->create([
            'role_id' => $role->id,
            'applied_at' => now(),
            'rejected_at' => now(),
        ]);

        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.listings', 0)
            );
    }
    public function test_it_shows_old_hires()
    {
        list($model, $role) = $this->prep();
        $role->update(['end_date' => now()->subWeek()]);

        $model->listings()->create([
            'role_id' => $role->id,
            'hired_at' => now(),
        ]);


        $this->get(route('dashboard'))
            ->assertInertia(fn(Assert $page) => $page
                ->component("Dashboard")
                ->has('vm.recentlyViewedRoles', 0)
                ->has('vm.listings', 1)
            );
    }

    protected function prep(): array
    {
        $model = Model::factory()->createOne();
        $role = Role::factory()->createOne();

        $this->be($model);
        $this->withoutMiddleware();
        return array($model, $role);
    }
}

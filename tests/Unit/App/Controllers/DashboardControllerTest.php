<?php

namespace Tests\Unit\App\Controllers;

use Domain\Profiles\Models\Model;

class DashboardControllerTest
{
    public function test_it_shows_recently_viewed_role()
    {
        $model = Model::factory()->create();
    }
}

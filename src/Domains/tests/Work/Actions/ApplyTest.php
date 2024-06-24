<?php

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;

class ApplyTest extends \Tests\TestCase
{
    public function test_it_applies()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();


    }
}

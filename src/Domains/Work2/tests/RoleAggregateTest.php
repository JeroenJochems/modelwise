<?php

namespace Domain\tests;

use Domain\Jobs\Models\Role;
use Domain\Work2\RoleAggregate;
use Tests\AggregateTestCase;

class RoleAggregateTest extends AggregateTestCase
{
        public function test_it_can_be_created()
    {
        $this->when(
            fn() => RoleAggregate::init(
                Role::factory()->create()
            )
        )->then(
            fn($role) => $this->assertNotNull($role)
        );
    }
}

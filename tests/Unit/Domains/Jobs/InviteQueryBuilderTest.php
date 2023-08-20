<?php

namespace Tests\Unit\Domains\Jobs;

use Domain\Jobs\Models\Invite;
use Tests\TestCase;

class InviteQueryBuilderTest extends TestCase
{

    public function test_it_selects_open_invites()
    {
        $invite = Invite::factory()->createOne();

        $invites = Invite::query()->open($invite->model)->count();

        $this->assertEquals(1, $invites);
    }
}

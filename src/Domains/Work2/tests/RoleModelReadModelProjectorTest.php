<?php

namespace Domain\tests;

use Domain\Jobs\Models\Role;
use Domain\Models\Order;
use Domain\Profiles\Models\Model;
use Domain\Work2\Events\ModelWasAddedToRole;
use Domain\Work2\Events\ModelWasInvited;
use Domain\Work2\Projectors\ModelRoleReadModelProjector;
use Domain\Work2\RoleId;
use EventSauce\Clock\TestClock;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\MessageConsumerTestCase;

class RoleModelReadModelProjectorTest extends MessageConsumerTestCase
{
    use DatabaseTransactions;

    public function messageConsumer(): MessageConsumer
    {
        return new ModelRoleReadModelProjector();
    }


    public function test_it_adds_a_model()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        $this
            ->givenNextMessagesHaveAggregateRootIdOf(RoleId::fromString($role->id))
            ->when(
                new ModelWasAddedToRole($model->id)
            );

        $this->assertDatabaseHas('listings', [
            'role_id' => $role->id,
            'model_id' => $model->id,
        ]);
    }

    public function test_it_invited_a_previously_added_model()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        $clock = new TestClock();
        $clock->tick();


        $this
            ->givenNextMessagesHaveAggregateRootIdOf(RoleId::fromString($role->id))
            ->given(new ModelWasAddedToRole($model->id))
            ->when(
                (new Message(new ModelWasInvited($model->id)))->withTimeOfRecording($clock->now())
            );

        $this->assertDatabaseHas('listings', [
            'role_id' => $role->id,
            'model_id' => $model->id,
            'invited_at' => $clock->now()->format('Y-m-d H:i:s')
        ]);
    }

}

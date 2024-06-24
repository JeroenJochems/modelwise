<?php

namespace Domain\tests;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Events\ModelHasApplied;
use Domain\Work2\Events\ModelWasAddedToRole;
use Domain\Work2\Events\RoleWasCreated;
use Domain\Work2\RoleAggregate;
use Domain\Work2\RoleId;
use EventSauce\EventSourcing\AggregateRootId;
use Tests\AggregateTestCase;

class RoleAggregateTest extends AggregateTestCase
{
    protected function newAggregateRootId(): AggregateRootId
    {
        return RoleId::create();
    }

    protected function aggregateRootClassName(): string
    {
        return RoleAggregate::class;
    }

    public function test_it_can_be_created()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        $this
            ->given(new RoleWasCreated($role->id))
            ->when(fn (RoleAggregate $roleAggregate) => $roleAggregate->add($model))
            ->then(
                new ModelWasAddedToRole($model->id)
            );
    }
    public function test_a_model_can_apply()
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        $this->be($model);

        $data = new ApplyData(
            cover_letter: "cover letter",
            digitals: [],
            photos: [],
            available_dates: [],
            brand_conflicted: false,
            casting_questions: "casting questions",
        );

        $this
            ->given(new RoleWasCreated($role->id))
            ->when(fn (RoleAggregate $roleAggregate) => $roleAggregate->submitApplication($model, $data))
            ->then(
                new ModelHasApplied($model->id, $data)
            );
    }
}

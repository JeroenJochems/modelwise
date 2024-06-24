<?php

namespace Domain\Work2;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Events\ModelHasApplied;
use Domain\Work2\Events\ModelHasExtendedApplication;
use Domain\Work2\Events\ModelWasAccepted;
use Domain\Work2\Events\ModelWasAddedToRole;
use Domain\Work2\Events\ModelWasInvited;
use Domain\Work2\Events\ModelWasRejected;
use Domain\Work2\Events\ModelWasShortlisted;
use Domain\Work2\Events\RoleWasCreated;
use Domain\Work2\Events\UpdatedFavorites;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviourWithRequiredHistory;

class RoleAggregate implements AggregateRoot
{
    use AggregateRootBehaviourWithRequiredHistory;

    public array $models = [];
    public array $rejectedModels = [];
    public array $favorites = [];

    public static function init(Role $role): self
    {

        $aggregate = new self(
            new RoleId($role->id)
        );

        $aggregate->recordThat(new RoleWasCreated($role->id));
        return $aggregate;
    }

    public function add(Model $model): void
    {
        $this->recordThat(new ModelWasAddedToRole($model->id));
    }

    public function shortlist(Model $model): void
    {
        $this->recordThat(new ModelWasShortlisted($model));
    }

    public function invite(Model $model): void
    {
        $this->recordThat(new ModelWasInvited($model->id));
    }

    public function submitApplication(Model $model, ApplyData $data): void
    {
        $this->recordThat(new ModelHasApplied($model->id, $data));
    }

    public function extendApplication(Model $model): void
    {
        $this->recordThat(new ModelHasExtendedApplication($model->id));
    }

    public function accept(Model $model): void
    {
        $this->recordThat(new ModelWasAccepted($model->id));
    }

    public function reject(Model $model, $messageSubject, $messageBody): void
    {
        $this->recordThat(new ModelWasRejected($model->id, $messageSubject, $messageBody));
    }

    /**
     * @param array<int> $models
     * @return void
     */
    public function updatedFavorites(array $models)
    {
        $this->recordThat(new UpdatedFavorites($models));
    }

    public function applyRoleWasCreated(RoleWasCreated $event)
    {
        // do nothing
    }

    public function applyModelWasAddedToRole(ModelWasAddedToRole $event)
    {
        if (!in_array($event->modelId, $this->models)) {
            $this->models[] = $event->modelId;
        }
    }

    public function applyModelWasShortlisted(ModelWasShortlisted $event)
    {
        if (!in_array($event->model->id, $this->models)) {
            $this->models[] = $event->model->id;
        }
    }

    public function applyModelWasInvited(ModelWasInvited $event)
    {
        if (!in_array($event->modelId, $this->models)) {
            $this->models[] = $event->modelId;
        }
    }

    public function applyModelHasApplied(ModelHasApplied $event)
    {
        if (!in_array($event->modelId, $this->models)) {
            $this->models[] = $event->modelId;
        }
    }

    public function applyModelHasExtendedApplication(ModelHasExtendedApplication $event)
    {
        if (!in_array($event->modelId, $this->models)) {
            $this->models[] = $event->modelId;
        }
    }

    public function applyModelWasAccepted(ModelWasAccepted $event)
    {
        if (!in_array($event->modelId, $this->models)) {
            $this->models[] = $event->modelId;
        }
    }

    public function applyModelWasRejected(ModelWasRejected $event)
    {
        if (!in_array($event->modelId, $this->rejectedModels)) {
            $this->rejectedModels[] = $event->modelId;
        }
    }

    public function applyUpdatedFavorites(UpdatedFavorites $event)
    {
        $this->favorites = $event->modelIds;
    }

}

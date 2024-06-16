<?php

namespace Domain\Work2;

use Domain\Jobs\Data\ApplyData;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
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
use Illuminate\Database\Eloquent\Collection;

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

        $aggregate->recordThat(new RoleWasCreated($role));
        return $aggregate;
    }

    public function add(Model $model): void
    {
        $this->recordThat(new ModelWasAddedToRole($model));
    }

    public function shortlist(Model $model): void
    {
        $this->recordThat(new ModelWasShortlisted($model));
    }

    public function invite(Model $model): void
    {
        $this->recordThat(new ModelWasInvited($model));
    }

    public function submitApplication(ApplyData $data): void
    {
        $this->recordThat(new ModelHasApplied(
            $data->model,
            $data->photos,
            $data->digitals,
            $data->cover_letter,
            $data->brand_conflicted,
            $data->available_dates,
            $data->casting_questions,
        ));
    }

    public function extendApplication(Model $model): void
    {
        $this->recordThat(new ModelHasExtendedApplication($model));
    }

    public function accept(Model $model): void
    {
        $this->recordThat(new ModelWasAccepted($model));
    }

    public function reject(Model $model): void
    {
        $this->recordThat(new ModelWasRejected($model));
    }

    public function updatedFavorites(Collection $models)
    {
        $this->recordThat(new UpdatedFavorites($models));
    }

    public function applyRoleWasCreated(RoleWasCreated $event)
    {
        // do nothing
    }

    public function applyModelWasAddedToRole(ModelWasAddedToRole $event)
    {
        if (!in_array($event->model->id, $this->models)) {
            $this->models[] = $event->model->id;
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
        if (!in_array($event->model->id, $this->models)) {
            $this->models[] = $event->model->id;
        }
    }

    public function applyModelHasApplied(ModelHasApplied $event)
    {
        if (!in_array($event->model->id, $this->models)) {
            $this->models[] = $event->model->id;
        }
    }

    public function applyModelHasExtendedApplication(ModelHasExtendedApplication $event)
    {
        if (!in_array($event->model->id, $this->models)) {
            $this->models[] = $event->model->id;
        }
    }

    public function applyModelWasAccepted(ModelWasAccepted $event)
    {
        if (!in_array($event->model->id, $this->models)) {
            $this->models[] = $event->model->id;
        }
    }

    public function applyModelWasRejected(ModelWasRejected $event)
    {
        if (!in_array($event->model->id, $this->rejectedModels)) {
            $this->rejectedModels[] = $event->model->id;
        }
    }

    public function applyUpdatedFavorites(UpdatedFavorites $event)
    {
        $this->favorites = $event->models->pluck('id')->toArray();
    }

}

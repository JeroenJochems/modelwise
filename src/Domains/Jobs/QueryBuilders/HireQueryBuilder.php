<?php

namespace Domain\Jobs\QueryBuilders;

use Domain\Profiles\Models\Model;
use Illuminate\Database\Eloquent\Builder;

class HireQueryBuilder extends Builder
{
    public function getWithData()
    {
        return $this
            ->with(
                'application.role.photos',
                'application.role.public_photos',
                'application.role.job.look_and_feel_photos'
            )
            ->get();
    }

    public function whereModel(Model $model)
    {
        return $this->whereRelation("application", "model_id", $model->id);
    }
}

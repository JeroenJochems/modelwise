<?php

namespace Domain\Jobs\QueryBuilders;

use Domain\Profiles\Models\Model;
use Illuminate\Database\Eloquent\Builder;

class ApplicationQueryBuilder extends Builder
{
    public function open(Model $forModel)
    {
        return $this->where('model_id', $forModel->id)
            ->whereDoesntHave("hire")
            ->whereDoesntHave("rejection");
    }

    public function getWithData()
    {
        return $this
            ->with('role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->get();
    }
}

<?php

namespace Domain\Jobs\QueryBuilders;

use Domain\Profiles\Models\Model;
use Illuminate\Database\Eloquent\Builder;

class InviteQueryBuilder extends Builder
{
    public function open(Model $forModel)
    {
        return $this
            ->whereHas("model", function($q) use ($forModel) {
                $q->where('id', $forModel->id);
            })
            ->whereNull('application_id');
    }

    public function getWithData()
    {
        return $this
            ->with('role.photos', 'role.public_photos', 'role.job.look_and_feel_photos')
            ->get();
    }
}

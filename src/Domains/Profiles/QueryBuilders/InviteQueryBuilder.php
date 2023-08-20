<?php

namespace Domain\Profiles\QueryBuilders;

use Domain\Profiles\Models\Model;
use Illuminate\Database\Eloquent\Builder;

class InviteQueryBuilder extends Builder
{
    public function open(Model $model)
    {
        return $this
            ->whereHas("model", function($q) use ($model) {
                $q
                    ->where('id', $model->id)
                    ->where('')
            })
        };

    }
}

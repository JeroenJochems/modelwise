<?php

namespace Domain\Jobs\Models;

use Domain\Models\Models\Model;

class Brand extends Model
{
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}

<?php

namespace Domain\Jobs\Models;


use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}

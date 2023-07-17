<?php

namespace Domain\Jobs\Models;


use Domain\Models\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Brand extends Model
{
    use HasShortflakePrimary;

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function logo()
    {
        return $this->morphOne(Photo::class, "photoable")->latestOfMany();
    }
}

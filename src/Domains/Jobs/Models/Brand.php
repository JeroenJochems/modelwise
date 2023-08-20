<?php

namespace Domain\Jobs\Models;


use Domain\Profiles\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Brand extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function getLogoCdnAttribute()
    {
        return $this->logo ? env("CDN_URL") . $this->logo : null;
    }

}

<?php

namespace Domain\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Role extends Model
{
    use HasShortflakePrimary;

    protected $casts = [
        "start_date" => "date",
        "end_date" => "date",
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function longlistedModels()
    {
        return $this->hasMany(LonglistedModel::class);
    }
}

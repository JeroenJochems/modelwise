<?php

namespace Domain\Work2\Models;

use Domain\Jobs\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\SortableTrait;

class Pass extends Model
{
    use HasFactory,
        HasShortflakePrimary,
        SortableTrait;

    protected $guarded = [];

    public function model()
    {
        return $this->belongsTo(\Domain\Profiles\Models\Model::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

<?php

namespace Domain\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Client extends Model
{
    use HasShortflakePrimary;

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}

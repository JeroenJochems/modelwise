<?php

namespace Domain\Work\Models;

use Domain\Jobs\QueryBuilders\HireQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Hire extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $fillable = [
        'application_id',
    ];

    public function newEloquentBuilder($query)
    {
        return new HireQueryBuilder($query);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}

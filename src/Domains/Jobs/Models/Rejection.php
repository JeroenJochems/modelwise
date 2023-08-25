<?php

namespace Domain\Jobs\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Rejection extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $fillable = [
        'application_id',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}

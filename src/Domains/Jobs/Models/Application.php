<?php

namespace Domain\Jobs\Models;

use Domain\Profiles\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Application extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $fillable = [
        'role_id',
        'model_id'
    ];

    const PHOTO_FOLDER = 'Application';

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function model()
    {
        return $this->belongsTo(\Domain\Profiles\Models\Model::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
}

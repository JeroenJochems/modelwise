<?php

namespace Domain\Jobs\Models;

use Domain\Jobs\QueryBuilders\ApplicationQueryBuilder;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Models\Video;
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
    const VIDEO_FOLDER = 'Application';

    public function newEloquentBuilder($query)
    {
        return new ApplicationQueryBuilder($query);
    }

    public function hire()
    {
        return $this->hasOne(Hire::class)->latestOfMany();
    }

    public function rejection()
    {
        return $this->hasOne(Rejection::class)->latestOfMany();
    }

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
        return $this->morphMany(Photo::class, 'photoable')->orderBy('sortable_order');
    }

    public function videos()
    {
        return $this->morphMany(Video::class, 'videoable')->orderBy('sortable_order');
    }
}

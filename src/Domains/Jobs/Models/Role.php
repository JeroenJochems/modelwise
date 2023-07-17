<?php

namespace Domain\Jobs\Models;

use Domain\Models\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Role extends Model
{
    use HasShortflakePrimary;

    const PHOTO_FOLDER_PRIVATE = 'private';
    const PHOTO_FOLDER_PUBLIC = 'public';

    protected $casts = [
        "start_date" => "date",
        "end_date" => "date",
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function photos()
    {
        return $this
            ->morphMany(Photo::class, "photoable")
            ->orderBy("sortable_order");
    }

    public function public_photos()
    {
        return $this
            ->morphMany(Photo::class, "photoable")
            ->where('folder', self::PHOTO_FOLDER_PUBLIC)
            ->orderBy("sortable_order");
    }

    public function longlistedModels()
    {
        return $this->hasMany(LonglistedModel::class);
    }
}

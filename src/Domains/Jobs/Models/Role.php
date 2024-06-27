<?php

namespace Domain\Jobs\Models;

use Database\Factories\RoleFactory;
use Domain\Present\Models\Presentation;
use Domain\Profiles\Models\Photo;
use Domain\Work\Models\Application;
use Domain\Work\Models\Pass;
use Domain\Work2\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

/**
 * Domain\Jobs\Models\Role
 * @property int $id
 */
class Role extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    const PHOTO_FOLDER_PRIVATE = 'private';
    const PHOTO_FOLDER_PUBLIC = 'public';

    protected $casts = [
        "start_date" => "date",
        "end_date" => "date",
        'fields' => "array",
        'extra_fields' => "array",
    ];

    protected $with = ['job'];

    protected $guarded = [];

    public static function newFactory(): Factory
    {
        return RoleFactory::new();
    }

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

    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    public function role_views()
    {
        return $this->hasMany(RoleView::class);
    }

    public function presentations()
    {
        return $this->hasMany(Presentation::class);
    }
}

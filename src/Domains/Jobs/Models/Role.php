<?php

namespace Domain\Jobs\Models;

use Domain\Profiles\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

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

    public function role_views()
    {
        return $this->hasMany(RoleView::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function my_applications($model_id = null)
    {
        return $this->hasMany(Application::class)
            ->where('model_id', $model_id ?? auth()->id());
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    public function my_invites($model_id = null)
    {
        return $this->hasMany(Invite::class)
            ->where('model_id', $model_id ?? auth()->id());
    }
}

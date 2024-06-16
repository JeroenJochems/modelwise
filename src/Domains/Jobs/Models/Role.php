<?php

namespace Domain\Jobs\Models;

use Database\Factories\RoleFactory;
use Domain\Present\Models\Presentation;
use Domain\Profiles\Models\Photo;
use Domain\Work\Models\Application;
use Domain\Work\Models\Pass;
use Domain\Work2\RoleAggregate;
use Domain\Work2\RoleRepository;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        'extra_fields' => "array",
    ];

    protected static function booted(): void
    {
        static::created(function (Role $role) {
            app(RoleRepository::class)
                ->persist(RoleAggregate::init($role));
        });
    }


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

    public function role_views()
    {
        return $this->hasMany(RoleView::class);
    }

    public function my_applications()
    {
        return $this->hasMany(Application::class)
            ->where('model_id', '=', auth()->id());
    }

    public function my_application()
    {
        return $this->hasOne(Application::class)
            ->where('model_id', '=', auth()->id());
    }

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    public function open_invites()
    {
        return $this->hasMany(Invite::class)->whereNull('application_id');
    }

    public function presentations()
    {
        return $this->hasMany(Presentation::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function my_passes() {
        return $this->hasMany(Pass::class)
            ->where('model_id', auth()->id());
    }

    public function my_invites($model_id = null)
    {
        return $this->hasMany(Invite::class)
            ->where('model_id', $model_id ?? auth()->id());
    }
}

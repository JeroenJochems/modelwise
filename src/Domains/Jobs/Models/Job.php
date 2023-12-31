<?php

namespace Domain\Jobs\Models;


use Domain\Profiles\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;
use Support\User;

class Job extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function photos()
    {
        return $this->morphMany(Photo::class, "photoable")->orderBy("sortable_order");
    }

    public function look_and_feel_photos()
    {
        return $this
            ->morphMany(Photo::class, "photoable")
            ->where('folder', Photo::FOLDER_JOB_IMAGE)
            ->orderBy("sortable_order");
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function responsible_user()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}

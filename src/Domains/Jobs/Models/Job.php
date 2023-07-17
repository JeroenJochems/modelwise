<?php

namespace Domain\Jobs\Models;


use Domain\Models\Models\Photo;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Job extends Model
{
    use HasShortflakePrimary;

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

    public function brand()
    {
        return $this->belongsTo(Brand::class);
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

<?php

namespace Domain\Work2\Models;

use Database\Factories\ListingFactory;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Models\Video;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\SortableTrait;

class Listing extends Model
{
    use HasFactory,
        HasShortflakePrimary,
        SortableTrait;

    protected $casts = [
        'available_dates' => 'json',
        'invited_at' => 'datetime',
        'shortlisted_at' => 'datetime',
        'favorited_at' => 'datetime',
        'extended_application_at' => 'datetime',
        'rejected_at' => 'datetime',
        'applied_at' => 'datetime',
        'hired_at' => 'datetime',
    ];

    public static function newFactory(): Factory
    {
        return ListingFactory::new();
    }

    protected $guarded = [];
    protected $with = [];

    const FOLDER_PHOTOS = 'Listing';
    const FOLDER_CASTING_PHOTOS = 'Casting photos';
    const FOLDER_CASTING_VIDEOS = 'Casting videos';

    public function buildSortQuery()
    {
        return static::query()->where('role_id', $this->role_id);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(\Domain\Profiles\Models\Model::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable')
            ->orderBy('sortable_order')
            ->where("folder", self::FOLDER_PHOTOS);
    }

    public function casting_photos()
    {
        return $this->morphMany(Photo::class, 'photoable')
            ->orderBy('sortable_order')
            ->where("folder", self::FOLDER_CASTING_PHOTOS);
    }

    public function casting_videos()
    {
        return $this->morphMany(Video::class, 'videoable')
            ->orderBy('sortable_order')
            ->where("folder", self::FOLDER_CASTING_VIDEOS);
    }
}

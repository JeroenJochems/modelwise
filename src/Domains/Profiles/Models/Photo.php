<?php

namespace Domain\Profiles\Models;

use Domain\Profiles\Collections\PhotoCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Photo extends \Illuminate\Database\Eloquent\Model implements Sortable
{
    use SortableTrait;
    use HasShortflakePrimary;
    use SoftDeletes;

    protected $casts = [
        'analysis' => 'object',
    ];

    protected $guarded = [];

    public function newCollection($models = [])
    {
        return new PhotoCollection($models);
    }

    public function toSearchableArray(): array
    {
        $array = [
            'id' => $this->id,
            'folder' => $this->folder,
            'path' => $this->path,
            'analysis' => $this->analysis,
        ];

        return $array;
    }

    public function searchableAs(): string
    {
        $name = 'photo_index';

        if (app()->environment('local')) {
            return 'dev_'.$name;
        }

        return $name;
    }

    public $sortable = [
        'order_column_name' => 'sortable_order',
        'sort_when_creating' => true,
    ];

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function getScoutKeyName(): mixed
    {
        return 'id';
    }

    const FOLDER_WORK_EXPERIENCE = 'Work experience';
    const FOLDER_ACTIVITIES = 'Activities';
    const FOLDER_DIGITALS = 'Digitals';
    const FOLDER_TATTOOS = 'Tattoos';
    const FOLDER_JOB_IMAGE = 'Look & Feel';
    const FOLDER_BRAND_LOGO = 'Brand logo';
    const FOLDER_PIERCINGS = 'Piercings';

    public function photoable(): BelongsTo
    {
        return $this->morphTo();
    }

    public function buildSortQuery()
    {
        return static::query()
            ->where('photoable_id', $this->photoable_id)
            ->where('photoable_type', $this->photoable_type)
            ->where('folder', $this->folder);
    }

    public function getCdnPathAttribute()
    {
        return env("CDN_URL").$this->attributes['path']."?twic=v1/focus=faces/cover=1:1/resize=2000/output=jpeg";
    }

    public function getCdnPathThumbAttribute()
    {
        return env("CDN_URL").$this->attributes['path']."?twic=v1/focus=faces/cover=1:1/resize=600/output=jpeg";
    }

    public function getCdnPathMiniAttribute()
    {
        return env("CDN_URL").$this->attributes['path']."?twic=v1/focus=faces/cover=1:1/resize=100/output=jpeg";
    }
}

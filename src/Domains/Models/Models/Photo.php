<?php

namespace Domain\Models\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Photo extends Model implements Sortable
{
    use SortableTrait;
    use HasShortflakePrimary;

    public $sortable = [
        'order_column_name' => 'sortable_order',
        'sort_when_creating' => true,
    ];

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    const FOLDER_WORK_EXPERIENCE = 'Work experience';
    const FOLDER_DIGITALS = 'Digitals';
    const FOLDER_TATTOOS = 'Tattoos';
    const FOLDER_JOB_IMAGE = 'Look & Feel';
    const FOLDER_BRAND_LOGO = 'Brand logo';

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
        return env("CDN_URL").$this->path;
    }
}

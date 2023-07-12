<?php

namespace Domain\Models\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Photo extends Model implements Sortable
{
    use SortableTrait;

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

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }

    public function buildSortQuery()
    {
        return static::query()->where('model_id', $this->model_id)->where('folder', $this->folder);
    }

    public function getCdnPathAttribute()
    {
        return env("CDN_URL").$this->path;
    }
}

<?php

namespace Domain\Profiles\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Document extends Model implements Sortable
{
    use HasShortflakePrimary;
    use SortableTrait;

    protected $guarded = [];

    protected $appends = ['url'];

    public $sortable = [
        'order_column_name' => 'sortable_order',
        'sort_when_creating' => true,
    ];

    public function documentable(): BelongsTo
    {
        return $this->morphTo();
    }

    public function buildSortQuery()
    {
        return static::query()
            ->where('documentable_id', $this->documentable_id)
            ->where('documentable_type', $this->documentable_type);
    }

    public function getCdnPathAttribute(): string
    {
        return $this->url;
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('s3')->temporaryUrl(
            $this->attributes['path'],
            now()->addHour(),
        );
    }
}
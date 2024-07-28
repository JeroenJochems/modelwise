<?php

namespace Domain\Present\Models;

use Domain\Work2\Models\Listing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class PresentationListing extends Model implements Sortable
{
    use HasShortflakePrimary,
        SortableTrait;

    protected $guarded = [];

    protected $casts = [];

    public $sortable = [
        'order_column_name' => 'order_column',
        'sort_when_creating' => true,
        'sort_on_has_many' => true,
    ];

    public function buildSortQuery()
    {
        return static::query()->where('presentation_id', $this->presentation_id);
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}



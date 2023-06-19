<?php

namespace Domain\Models\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Photo extends Model implements Sortable
{
    use SortableTrait;

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }
}

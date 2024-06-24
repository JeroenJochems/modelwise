<?php

namespace Domain\Work2\Models;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\SortableTrait;

class Listing extends Model
{
    use HasFactory,
        HasShortflakePrimary,
        SortableTrait;

    protected $casts = [
        'available_dates' => 'array',
    ];

    public function buildSortQuery()
    {
        return static::query()->where('role_id', $this->role_id);
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function getPhotosAttribute($value)
    {
        return Photo::whereIn('id', json_decode($value, true) ?? [])->get();
    }

    public function getDigitalsAttribute($value)
    {
        return Photo::whereIn('id', json_decode($value, true) ?? [])->get();
    }
}

<?php

namespace Domain\Profiles\Models;

use Domain\Profiles\Actions\VideoToMux;
use Domain\Profiles\Collections\VideoCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kra8\Snowflake\HasShortflakePrimary;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Video extends Model implements Sortable
{
    use SortableTrait;

    use HasShortflakePrimary;

    public function newCollection($models = [])
    {
        return new VideoCollection($models);
    }

    public $sortable = [
        'order_column_name' => 'sortable_order',
        'sort_when_creating' => true,
    ];

    protected static function booted()
    {
        static::created(function (Video $video) {
            app(VideoToMux::class)->execute($video);
        });
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function videoable(): BelongsTo
    {
        return $this->morphTo();
    }

    public function buildSortQuery()
    {
        return static::query()
            ->where('videoable_id', $this->videoable_id)
            ->where('videoable_type', $this->videoable_type)
            ->where('folder', $this->folder);
    }

    public function getCdnPathAttribute()
    {

        return $this->mux_id
            ? "https://stream.mux.com/".$this->mux_id.".m3u8"
            : env("CDN_URL").$this->path;
    }

    public function getCdnPathThumbAttribute()
    {
        return $this->mux_id
            ? "https://images.mux.com/".$this->mux_id."/animated.gif"
            : null;
    }
}

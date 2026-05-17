<?php

namespace Domain\Profiles\Models;

use Domain\Profiles\Actions\VideoToMux;
use Domain\Profiles\Collections\VideoCollection;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Kra8\Snowflake\HasShortflakePrimary;
use MuxPhp\Api\AssetsApi;
use MuxPhp\Configuration;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Video extends \Illuminate\Database\Eloquent\Model implements Sortable
{
    use SortableTrait;

    use HasShortflakePrimary;

    public const FOLDER_DRAFT = '__draft__';

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
            if ($video->mux_upload_id) {
                return;
            }
            app(VideoToMux::class)->onQueue()->execute($video);
        });
    }

    public function searchableAs(): string
    {
        $name = 'video_index';

        if (app()->environment('local')) {
            return 'dev_'.$name;
        }

        return $name;
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

    public function getMasterUrlAttribute(): ?string
    {
        if (!$this->mux_asset_id) {
            return null;
        }

        $cacheKey = "video:{$this->id}:master_url";

        if ($cached = Cache::get($cacheKey)) {
            return $cached;
        }

        $config = Configuration::getDefaultConfiguration()
            ->setUsername(env('MUX_TOKEN_ID'))
            ->setPassword(env('MUX_TOKEN_SECRET'));

        $assetsApi = new AssetsApi(new Client(), $config);

        try {
            $asset = $assetsApi->getAsset($this->mux_asset_id)->getData();
            $master = $asset->getMaster();

            if ($master && $master->getStatus() === 'ready' && $master->getUrl()) {
                Cache::put($cacheKey, $master->getUrl(), now()->addHour());
                return $master->getUrl();
            }
        } catch (\Throwable) {
        }

        return null;
    }
}

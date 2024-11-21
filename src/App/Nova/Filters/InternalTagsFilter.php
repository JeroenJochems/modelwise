<?php

namespace App\Nova\Filters;

use Domain\Profiles\Models\Model;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Tags\Tag;

class InternalTagsFilter extends BooleanFilter
{
    protected $tagType = Model::TAG_TYPE_INTERNAL;

    public $name = "Internal Tag";

    public function apply(NovaRequest $request, $query, $value)
    {
        $tags = [];

        foreach ($value as $name=>$isSelected) {
            if ($isSelected) {
                $tags[] = $name;
            }
        }

        if (!$tags) return $query;

        return $query->withAnyTags($tags, $this->tagType );
    }

    /**
     * Get the filter's available options.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function options(NovaRequest $request)
    {
        return Tag::whereType($this->tagType)
                ->orderBy('name')
                ->get()
                ->mapWithKeys(fn ($tag) => ["{$tag->name}" => $tag->name]);
    }
}

<?php

namespace App\Nova\Filters;

use Domain\Profiles\Models\Model;
use Laravel\Nova\Filters\BooleanFilter;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Tags\Tag;

class ProfessionsFilter extends BooleanFilter
{
    protected $tagType = Model::TAG_TYPE_PROFESSIONS;

    public $name = "Other professions";

    public function apply(NovaRequest $request, $query, $value)
    {
        $tags = [];

        foreach ($value as $name=>$isSelected) {
            if ($isSelected) {
                $tags[] = $name;
            }
        }

        if (!$tags) return $query;

        return $query->withAnyTags($tags, $this->tagType);
    }

    public function options(NovaRequest $request)
    {
        return Tag::whereType($this->tagType)
                ->orderBy('name')
                ->get()
                ->mapWithKeys(fn ($tag) => ["{$tag->name}" => $tag->name]);
    }
}
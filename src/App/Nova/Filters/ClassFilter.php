<?php

namespace App\Nova\Filters;

use Domain\Profiles\Enums\ModelClass;
use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class ClassFilter extends Filter
{
    public function apply(NovaRequest $request, $query, $value)
    {
        if ($value === "unknown") {
            return $query->whereNull('model_class');
        }

        return $query->where('model_class', $value);
    }

    public function options(NovaRequest $request)
    {
        $options = ["Unknown" => "unknown", ...ModelClass::toArray()];

        return $options;
    }
}

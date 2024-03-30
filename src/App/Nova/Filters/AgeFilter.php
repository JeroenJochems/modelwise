<?php

namespace App\Nova\Filters;

use DigitalCreative\NovaRangeFilter\SliderFilter;
use Laravel\Nova\Filters\RangeFilter;
use Laravel\Nova\Http\Requests\NovaRequest;

class AgeFilter extends SliderFilter
{

    /**
     * Apply the filter to the given query.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply(NovaRequest $request, $query, $value)
    {
        ray($value);
        return $query->where('date_of_birth', '>=', now()->subYears($value[1]))
            ->where('date_of_birth', '<=', now()->subYears($value[0]));
    }


}

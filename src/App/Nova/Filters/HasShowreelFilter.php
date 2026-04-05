<?php

namespace App\Nova\Filters;

use Laravel\Nova\Filters\Filter;
use Laravel\Nova\Http\Requests\NovaRequest;

class HasShowreelFilter extends Filter
{
    public $component = 'select-filter';

    public $name = "Has Showreel";

    public function apply(NovaRequest $request, $query, $value)
    {
        if ($value === 'yes') {
            return $query->whereNotNull('showreel_link')->where('showreel_link', '!=', '');
        }

        if ($value === 'no') {
            return $query->where(function ($q) {
                $q->whereNull('showreel_link')->orWhere('showreel_link', '');
            });
        }

        return $query;
    }

    public function options(NovaRequest $request)
    {
        return [
            'With Showreel' => 'yes',
            'Without Showreel' => 'no',
        ];
    }
}
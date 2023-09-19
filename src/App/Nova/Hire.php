<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

class Hire extends Resource
{
    public static $model = \Domain\Work\Models\Hire::class;

    public static $search = [
    ];

    public function fields(NovaRequest $request)
    {
        return [
        ];
    }
}

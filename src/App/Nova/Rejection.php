<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;

class Rejection extends Resource
{
    public static $model = \Domain\Work\Models\Rejection::class;


    public static $search = [
    ];

    public function fields(NovaRequest $request)
    {
        return [
        ];
    }
}

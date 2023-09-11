<?php

namespace App\Nova;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Tags\Tag as TagModel;

class Hire extends Resource
{
    public static $model = \Domain\Jobs\Models\Hire::class;

    public static $search = [
    ];

    public function fields(NovaRequest $request)
    {
        return [
        ];
    }
}

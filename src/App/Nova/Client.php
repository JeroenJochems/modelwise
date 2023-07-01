<?php

namespace App\Nova;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Client extends Resource
{
    public static $model = \Domain\Jobs\Models\Client::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable()->hide(),
            Text::make("Name"),
            HasMany::make("Jobs"),
        ];
    }

}

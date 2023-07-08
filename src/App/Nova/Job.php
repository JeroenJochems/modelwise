<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Job extends Resource
{
    public static $model = \Domain\Jobs\Models\Job::class;

    public static $title = 'title';

    public static $search = [
        'id',
        'title',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make("Client"),
            Text::make("Title"),
            Textarea::make("Description")->alwaysShow(),
            HasMany::make("Longlisted models"),
        ];
    }

}

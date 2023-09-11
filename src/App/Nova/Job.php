<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
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
        'location'
    ];

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make("Client")->searchable(true)->showCreateRelationButton(),
            BelongsTo::make("Brand")->searchable(true)->showCreateRelationButton(),
            Text::make("Title"),
            Text::make("Location"),
            Textarea::make("Description")->alwaysShow(),
            BelongsTo::make("Responsible user", "responsible_user", User::class),
            HasMany::make("Roles"),
            MorphMany::make("Photos"),
        ];
    }

}

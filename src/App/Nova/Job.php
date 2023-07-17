<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Vyuldashev\NovaMoneyField\Money;

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
            BelongsTo::make("Client")->searchable(true)->showCreateRelationButton(),
            BelongsTo::make("Brand")->searchable(true)->showCreateRelationButton(),
            Text::make("Title"),
            Textarea::make("Description")->alwaysShow(),
            HasMany::make("Roles"),
            MorphMany::make("Photos"),
        ];
    }

}

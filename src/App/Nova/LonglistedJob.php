<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Repeater;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class LonglistedJob extends Resource
{
    public static $model = \Domain\Jobs\Models\LonglistedModel::class;
    public static $title = 'id';
    public static $displayInNavigation = false;
    public static $search = [
        'id',
    ];

    public function title()
    {
        return $this->model->first_name.' '.$this->model->last_name. ' at '.$this->role->job->title.' ('.$this->role->job->client->name.')';
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('Role')->sortable()->searchable(),
        ];
    }

    public static function createButtonLabel() {
        return "Add +";
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

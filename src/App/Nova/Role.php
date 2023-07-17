<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Vyuldashev\NovaMoneyField\Money;

class Role extends Resource
{
    public static $model = \Domain\Jobs\Models\Role::class;
    public static $title = 'name';

    public static $search = [
        'name', 'description'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make("Job")->onlyOnDetail(),
            Text::make("Name"),
            Date::make("Start date"),
            Date::make("End date")->nullable(true),
            Textarea::make("Description")->alwaysShow(),
            Money::make("Fee", "EUR")
                ->storedInMinorUnits(),
            Money::make("Buyout", "EUR")
                ->storedInMinorUnits(),
            Text::make("Buyout note")->hideFromIndex(),
            Text::make("Travel reimbursement note")->hideFromIndex(),
            Text::make('Longlisted models', function() {
                return '<div style="display: flex; width: 400px; height: 120px; overflow-x: scroll; overflow-y: hidden">
                    ' .implode("", $this->longlistedModels->map(function ($shortlisted_model) {
                        return '<img src="'.$shortlisted_model->model->profile_picture_cdn.'?w=720&h=960&fit=crop&fm=auto&crop=faces" width="90" height="120" />';
                    })->toArray())
                    . '</div>';
            })->asHtml()->onlyOnIndex(),
            HasMany::make("Longlisted models"),
            Text::make('Public URL', function() {
                return '<a href="'.route("roles.show", $this->id).'" target="_blank">'.route("roles.show", $this->id).'</a>';
            })->asHtml()->onlyOnDetail(),
        ];
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

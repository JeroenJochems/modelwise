<?php

namespace App\Nova;

use App\Nova\Actions\CreatePresentation;
use App\Nova\Actions\SendInviteToListing;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Listing extends Resource
{
    public static $model = \Domain\Work2\Models\Listing::class;

    
    public function title() {
        return $this->model->name .' at '. $this->role->name;
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            BelongsTo::make("Model")->searchable(),
            BelongsTo::make("Role"),
            Stack::make("Name", [
                Line::make("Role", function () {
                    return $this->role->name;
                })->asHeading(),
                Line::make("Job", function () {
                    return $this->role->job->title;
                })->asSubTitle(),
                Line::make("Model", function () {
                    return $this->model->name;
                })->asBase(),
            ])->onlyOnIndex(),
            Boolean::make("Invited", "invited")
                ->readonly()
                ->onlyOnIndex()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('invited_at') )
                ->resolveUsing(fn($request, $model) => $model['invited_at']!==null),
            Boolean::make("Applied", "applied")
                ->readonly()
                ->onlyOnIndex()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('applied_at') )
                ->resolveUsing(fn($request, $model) => $model['applied_at']!==null),
            Text::make('Photos', fn() =>
                '<div class="flex overflow-x-scroll overflow-y-hidden" style="height: 120px;">' .
                        $this->photos->map(fn($photo) => '<img src="' . $photo->cdn_path_thumb . '" />')->implode('')
                . '</div>'
            )->asHtml(),
            Text::make('Digitals', fn() =>
                '<div class="flex overflow-x-scroll overflow-y-hidden" style="height: 120px;">' .
                        $this->digitals->map(fn($photo) => '<img src="' . $photo->cdn_path_thumb . '" />')->implode('')
                . '</div>'
            )->asHtml(),
            Textarea::make('Cover letter'),
            Textarea::make('Brand conflicted'),
            Text::make('Available dates', fn() => implode(", ", $this->available_dates ?? [])),
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
        return [
            new CreatePresentation(),
            new SendInviteToListing()
        ];
    }
}

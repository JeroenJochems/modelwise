<?php

namespace App\Nova;

use App\Nova\Actions\CreatePresentation;
use App\Nova\Actions\DeleteListing;
use App\Nova\Actions\Hire;
use App\Nova\Actions\Reject;
use App\Nova\Actions\SendInviteToListing;
use App\Nova\Actions\SendMail;
use App\Nova\Actions\Shortlist;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Listing extends Resource
{
    public static $perPageViaRelationship = 50;

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
            BelongsTo::make("Role")->hideFromIndex(),
            Text::make('Photo', function() {
                return "<img src=\"{$this->model->profile_picture_cdn}?twic=v1/focus=auto/cover=120x120\" width=\"120\" height=\"120\" />";
            })->asHtml(),
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
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('invited_at') )
                ->resolveUsing(fn($request, $model) => $model['invited_at']!==null),
            Boolean::make("Applied", "applied")
                ->readonly()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('applied_at') )
                ->resolveUsing(fn($request, $model) => $model['applied_at']!==null),

            Boolean::make("Favorited")
                ->readonly()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('favorited_at') )
                ->resolveUsing(fn($request, $model) => $model['favorited_at']!==null),

            Boolean::make("Shortlisted", "shortlisted")
                ->readonly()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('shortlisted_at') )
                ->resolveUsing(fn($request, $model) => $model['shortlisted_at']!==null),

            Boolean::make("Hired", "hired")
                ->readonly()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('hired_at') )
                ->resolveUsing(fn($request, $model) => $model['hired_at']!==null),

            Boolean::make("Rejected")
                ->readonly()
                ->filterable(fn ($request, $query, $value, $attributes) => $query->{$value ? "whereNotNull" : "whereNull"}('rejected_at') )
                ->resolveUsing(fn($request, $model) => $model['rejected_at']!==null),

            Text::make('Photos', fn() => '<div style="display: flex; width: 340px; overflow-x: scroll">
                        ' .implode("", $this->photos->map(fn($photo) => '<img src="'.$photo->cdn_path_thumb.'" style="height: 120px;" />')->toArray())
                . '</div>')
                ->asHtml()->onlyOnIndex(),
            Text::make('Casting photos', fn() => '<div style="display: flex; width: 340px; overflow-x: scroll">
                        ' .implode("", $this->casting_photos->map(fn($photo) => '<img src="'.$photo->cdn_path_thumb.'" style="height: 120px;" />')->toArray())
                . '</div>')
                ->asHtml()->hideFromIndex(),
            Text::make('Casting videos', fn() => '<div style="display: flex; width: 140px; overflow-x: scroll">
                        ' .$this->casting_videos->map(fn($video) => '<video src="'.$video->cdn_path.'" style="height: 120px;" controls="true" />')->implode('')
                . '</div>')
                ->asHtml()->hideFromIndex(),

            MorphMany::make("Photos")->showOnIndex(true),
            MorphMany::make("Casting photos", "casting_photos", Photo::class)->showOnIndex(true),
            MorphMany::make("Casting videos", "casting_videos", Video::class)->showOnIndex(true),


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
            new SendMail(),
            new CreatePresentation(),
            new SendInviteToListing(),
            new Shortlist(),
            new DeleteListing(),
            new Reject(),
            new Hire(),
        ];
    }
}

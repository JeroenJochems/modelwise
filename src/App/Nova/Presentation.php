<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Presentation extends Resource
{
    public static $model = \Domain\Present\Models\Presentation::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'description',
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
            BelongsTo::make("Role"),
            Text::make("Description"),
            Text::make('Models', fn() => $this->presentationListings->count())->onlyOnIndex(),
            Text::make("Link", fn() => '<a target="_new" href="'.route('presentations.show', $this->id).'">View</a>')->asHtml()->onlyOnIndex(),
            HasMany::make("Listings", "presentationListings", PresentationListing::class),
            Boolean::make("Show name", "should_show_name")->default(true),
            Boolean::make("Show casting media", "should_show_casting_media"),
            Boolean::make("Show digitals", "should_show_digitals"),
            Boolean::make("Show socials", "should_show_socials"),
            Boolean::make("Show cover letter", "should_show_cover_letter"),
            Boolean::make("Show conflicts", "should_show_conflicts"),
            Boolean::make("Show age", "should_show_age"),
            Boolean::make("Show city", "should_show_city"),
            Boolean::make("Show height", "should_show_height")->default(true),
            Boolean::make("Show waist", "should_show_waist")->default(true),
            Boolean::make("Show hips", "should_show_hips")->default(true),
            Boolean::make("Show hair color", "should_show_hair_color")->default(true),
            Boolean::make("Show eye color", "should_show_eye_color")->default(true),
            Boolean::make("Show clothing size", "should_show_clothing_size")->default(true),
            Boolean::make("Show shoe size", "should_show_shoe_size")->default(true),
            Boolean::make("Show cup size", "should_show_cup_size")->default(true),
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

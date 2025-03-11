<?php

namespace App\Nova;

use App\Nova\Filters\RoleUpcoming;
use Fourstacks\NovaCheckboxes\Checkboxes;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Outl1ne\NovaSortable\Traits\HasSortableManyToManyRows;
use Vyuldashev\NovaMoneyField\Money;

class Role extends Resource
{
    use HasSortableManyToManyRows;

    public static $model = \Domain\Jobs\Models\Role::class;

    public function title()
    {
        return $this->job->title .' - '.$this->name.' (' . $this->job->brand?->name .')';
    }

    public static $search = [
        'name', 'description'
    ];

    public static $with = ['listings.model'];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            Stack::make("Role", [
                Line::make("Role", fn() => $this->name)->asHeading(),
                Line::make("Job", fn() => $this->job->title),
                Line::make("Dates", fn() => (!$this->end_date || $this->start_date->is($this->end_date))
                    ? $this->start_date?->format("d-m-Y")
                    : $this->start_date?->format("d-m") . ' till ' . $this->end_date?->format("d-m-Y")
                )
            ])->onlyOnIndex(),
            BelongsTo::make("Job")->hideFromIndex(),
            Text::make("Name")->hideFromIndex(),
            Date::make("Start date")->hideFromIndex(),
            Date::make("End date")->nullable(true)->hideFromIndex(),
            Boolean::make("Is active"),
            Textarea::make("Description")->alwaysShow()->hideFromIndex(),
            Money::make("Fee", "EUR")
                ->storedInMinorUnits(),
            Money::make("Buyout", "EUR")
                ->storedInMinorUnits(),
            Text::make("Buyout note")->hideFromIndex(),
            BooleanGroup::make("Basic fields", "fields")->hideFromIndex()->options([
                'digitals' => 'Digitals',
                'height' => 'Height',
                'chest' => 'Chest',
                'waist' => 'Waist',
                'hips' => 'Hips',
                'shoe_size' => 'Shoe size',
                'head' => 'Head',
                'clothing_size_top' => 'Clothing size, top (XS-XXL)'
            ])->hideFalseValues(),
            new Panel(
                "Fields specific for shortlisted models",
                [
                    BooleanGroup::make("Extra fields")->hideFromIndex()->options([
                        'casting_photos' => 'Casting photos',
                        'casting_videos' => 'Casting videos',
                    ]),
                    Textarea::make("Casting photo instructions", "casting_photo_instructions")->help("Only applicable if field is active")->hideFromIndex()->alwaysShow(),
                    Textarea::make("Casting video instructions", "casting_video_instructions")->help("Only applicable if field is active")->hideFromIndex()->alwaysShow(),
                    Textarea::make("Additional questions", "casting_questions")->hideFromIndex()->alwaysShow(),
                ]
            ),
            Text::make("Travel reimbursement note")->hideFromIndex(),
            HasMany::make("Listings"),
            HasMany::make("Passes"),
            HasMany::make("Presentations"),
            Text::make('Listings', function() {
                return '<div style="display: flex; width: 600px; height: 120px; overflow-x: scroll; overflow-y: hidden">
                    ' .implode("", $this->listings->map(function ($listing) {
                        return '<img src="'.$listing->model->profile_picture_cdn.'" title="'.$listing->model->name.'" height="120" />';
                    })->toArray())
                    . '</div>';
            })->asHtml()->onlyOnIndex(),
            Text::make('Public URL', function() {
                return '<a href="'.route("roles.show", $this->id).'" target="_blank">'.route("roles.show", $this->id).'</a>';
            })->asHtml()->onlyOnDetail(),
            MorphMany::make("Photos", "photos", Photo::class)->showOnIndex(true),
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


    public function filters(NovaRequest $request)
    {
        return [
            new RoleUpcoming(),
        ];
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

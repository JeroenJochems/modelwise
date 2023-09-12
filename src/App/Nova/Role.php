<?php

namespace App\Nova;

use Fourstacks\NovaCheckboxes\Checkboxes;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Vyuldashev\NovaMoneyField\Money;

class Role extends Resource
{
    public static $model = \Domain\Jobs\Models\Role::class;

    public function title()
    {
        return $this->job->title .' - '.$this->name.' (' . $this->job->brand?->name .')';
    }

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
            BooleanGroup::make("Fields")->options([
                'digitals' => 'Digitals',
                'height' => 'Height',
                'chest' => 'Chest',
                'waist' => 'Waist',
                'hips' => 'Hips',
                'shoe_size' => 'Shoe size',
                'head' => 'Head',
            ])->hideFalseValues(),
            Text::make("Travel reimbursement note")->hideFromIndex(),
            Text::make('Invites', function() {
                return '<div style="display: flex; width: 400px; height: 120px; overflow-x: scroll; overflow-y: hidden">
                    ' .implode("", $this->invites->map(function ($invite) {
                        return '<img src="'.$invite->model->profile_picture_cdn.'?w=720&h=960&fit=crop&fm=auto&crop=faces" title="'.$invite->model->name.'" width="90" height="120" />';
                    })->toArray())
                    . '</div>';
            })->asHtml()->onlyOnIndex(),
            Text::make('Photos (private)', function() {

                $privatePhotos = $this->photos()->where("folder", \Domain\Jobs\Models\Role::PHOTO_FOLDER_PRIVATE)->get();

                return '<div style="display: flex; width: 300px; height: 120px; overflow-x: scroll; overflow-y: hidden">
                        ' .implode("", $privatePhotos->map(function ($photo) {
                            return '<img src="'.$photo->cdn_path.'?w=720&h=960&fit=crop&fm=auto&crop=faces" width="90" height="120" />';
                    })->toArray())
                    . '</div>';
            })->asHtml()->onlyOnIndex(),
            HasMany::make("Applications"),
            HasMany::make("Invites"),
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

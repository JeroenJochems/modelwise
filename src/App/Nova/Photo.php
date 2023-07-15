<?php

namespace App\Nova;

use Domain\Models\Models\Photo as Model;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\VaporImage;
use Laravel\Nova\Http\Requests\NovaRequest;

class Photo extends Resource
{
    public static $model = Model::class;
    public static $title = 'folder';
    public static $globallySearchable = false;
    public static $perPageViaRelationship = 10;

    public static function authorizable()
    {
        return false;
    }

    public function fields(NovaRequest $request)
    {
        $options = $this->photoable_type === "job" || $request->viaResource === "jobs"
            ? [Model::FOLDER_JOB_IMAGE => Model::FOLDER_JOB_IMAGE]
            : [Model::FOLDER_WORK_EXPERIENCE, Model::FOLDER_DIGITALS, Model::FOLDER_TATTOOS];

        $options = collect($options)->mapWithKeys(function ($item) {
            return [$item => $item];
        })->toArray();

        return [
            MorphTo::make("Photoable")->onlyOnDetail(),
            Select::make("Folder")->options($options),
            VaporImage::make('Photo', 'path')
                ->path("photos")
                ->indexWidth(200)
                ->detailWidth(500)
                ->preview(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->cdn_path : null;
                })
,
        ];
    }

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

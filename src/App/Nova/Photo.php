<?php

namespace App\Nova;

use Domain\Jobs\Models\Role as RoleModel;
use Domain\Models\Models\Photo as PhotoModel;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\VaporImage;
use Laravel\Nova\Http\Requests\NovaRequest;

class Photo extends Resource
{
    public static $model = PhotoModel::class;
    public static $title = 'folder';
    public static $globallySearchable = false;
    public static $perPageViaRelationship = 10;

    public static function authorizable()
    {
        return false;
    }

    public function fields(NovaRequest $request)
    {
        $resource = $this->photoable_type ?? substr($request->viaResource,0, -1);

        $options = match($resource) {
            "job" => [PhotoModel::FOLDER_JOB_IMAGE => PhotoModel::FOLDER_JOB_IMAGE],
            "brand" => [PhotoModel::FOLDER_BRAND_LOGO],
            "role" => [RoleModel::PHOTO_FOLDER_PRIVATE, RoleModel::PHOTO_FOLDER_PUBLIC],
            "model" => [PhotoModel::FOLDER_WORK_EXPERIENCE, PhotoModel::FOLDER_DIGITALS, PhotoModel::FOLDER_TATTOOS],
            null => []
        };

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

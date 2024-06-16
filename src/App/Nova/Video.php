<?php

namespace App\Nova;

use Domain\Work\Models\Application as ApplicationModel;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\VaporFile;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableManyToManyRows;

class Video extends Resource
{
    use HasSortableManyToManyRows;

    public static $model = \Domain\Profiles\Models\Video::class;
    public static $title = 'folder';
    public static $globallySearchable = false;
    public static $perPageViaRelationship = 10;

    public $sortable = [
        'order_column_name' => 'sortable_order',
        'sort_when_creating' => true,
        'sort_on_has_many' => true,
    ];


    public static function authorizable()
    {
        return false;
    }

    public function fields(NovaRequest $request)
    {
        $resource = $this->videoable_type ?? substr($request->viaResource,0, -1);

        $options = match($resource) {
            "application" => [ApplicationModel::CASTING_VIDEOS => ApplicationModel::CASTING_VIDEOS],
            null => []
        };

        $options = collect($options)->mapWithKeys(function ($item) {
            return [$item => $item];
        })->toArray();

        return [
            MorphTo::make("Videoable")->onlyOnDetail(),
            Select::make("Folder")->options($options),
            Text::make("Video", fn() => '<video src="'.$this->cdn_path.'" style="height: 300px;" controls="true" />')->hideWhenUpdating()->hideWhenCreating()->asHtml(),
            VaporFile::make('Video', 'path')->path("videos")->onlyOnForms(),
            Number::make("Order", "sortable_order")->hideWhenCreating(),
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

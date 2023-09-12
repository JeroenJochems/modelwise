<?php

namespace App\Nova;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Tags\Tag as TagModel;

class Tag extends Resource
{
    public static $model = TagModel::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Select::make('Type')->sortable()
                ->options(\Domain\Profiles\Models\Model::TAG_TYPES)->required(),
            Text::make('Name')->sortable(),
        ];
    }
}

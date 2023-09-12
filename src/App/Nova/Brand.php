<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\VaporImage;
use Laravel\Nova\Http\Requests\NovaRequest;

class Brand extends Resource
{
    public static $model = \Domain\Jobs\Models\Brand::class;

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name')->sortable(),
            Textarea::make('Description'),

            VaporImage::make("Logo", "logo")
                ->path("logos")
                ->preview(function ($value, $disk) {
                    // @phpstan-ignore-next-line
                    return $value ? $this->logo_cdn : null;
                })
                ->hideFromIndex()
                ->detailWidth(300)
                ->disableDownload(),
        ];
    }
}

<?php

namespace App\Nova;

use Domain\Profiles\Models\Document as DocumentModel;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\VaporFile;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableManyToManyRows;

class Document extends Resource
{
    use HasSortableManyToManyRows;

    public static $model = DocumentModel::class;
    public static $title = 'filename';
    public static $globallySearchable = false;
    public static $perPageViaRelationship = 20;

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
        return [
            MorphTo::make("Documentable")->onlyOnDetail(),
            Text::make("Filename")
                ->help("Shown to models as the download label. Leave blank to use the uploaded file name.")
                ->nullable(),
            Text::make("Download", fn () => $this->path
                ? '<a href="'.$this->cdn_path.'" target="_blank" rel="noopener">Open PDF</a>'
                : null
            )->asHtml()->onlyOnDetail(),
            VaporFile::make('PDF', 'path')
                ->path('documents')
                ->acceptedTypes('application/pdf')
                ->storeOriginalName('filename'),
            Number::make("Order", "sortable_order")->hideWhenCreating(),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [];
    }
}
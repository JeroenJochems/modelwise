<?php

namespace App\Nova;

use App\Nova\Actions\CreatePresentation;
use App\Nova\Actions\Shortlist;
use App\Nova\Actions\Reject;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Outl1ne\NovaSortable\Traits\HasSortableRows;

class Application extends Resource
{
    use HasSortableRows;

    public static $model = \Domain\Work\Models\Application::class;

    public function buildSortQuery()
    {
        return static::query()->where('role_id', $this->role_id);
    }

    public function title()
    {
        return $this->model->name. ' - ' . $this->role->name;
    }

    public static function canSort(NovaRequest $request, $resource)
    {
        return true;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Stack::make("Role and status", [
                Line::make("Model", fn() => $this->model->name)->asHeading(),
                Line::make("Status", fn() => ($this->hire ? "Hired" : ($this->rejection ? "Rejected" : "Pending"))),
                Line::make("Role", fn() => $this->role->name),
                Line::make("Job", fn() => $this->role->job->title),
                Line::make("Brand and client", fn() => $this->role->job->brand?->name. ' via '.$this->role->job->client->name)->asSmall(),
            ])->onlyOnIndex(),
            BelongsTo::make("Role")->hideFromIndex(),
            BelongsTo::make("Model")->hideFromIndex()->searchable(),
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
            Text::make("Cover letter"),
            Text::make("Brand conflicted"),
            Boolean::make("Shortlisted", "shortlisted")
                ->resolveUsing(fn($request, $model) => $model['shortlisted_at']!==null)
                ->fillUsing(function($request, $model) { return $model['shortlisted_at'] = $request->shortlisted==="1" ? now() : null; }),
            MorphMany::make("Photos")->showOnIndex(true),
            MorphMany::make("Casting videos", "casting_videos", Video::class)->showOnIndex(true),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            new Shortlist(),
            new Reject(),
            new CreatePresentation(),
        ];
    }

    protected static function afterValidation(NovaRequest $request, $validator)
    {
        $isDuplicate = \Domain\Work\Models\Application::query()
            ->whereModelId($request->model)
            ->whereRoleId($request->role)
            ->exists();

        if ($isDuplicate) {
            $validator->errors()->add('model', 'This model has already applied for this role');
        }
    }
}

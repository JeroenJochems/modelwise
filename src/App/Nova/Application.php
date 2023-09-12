<?php

namespace App\Nova;

use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Application extends Resource
{
    public static $model = \Domain\Jobs\Models\Application::class;

    public function title()
    {
        return $this->model->name. ' - ' . $this->role->name;
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
                Line::make("Status", fn() => ($this->hire ? "Hired" : ($this->rejection ? "Rejected" : "Pending")))->asHeading(),
                Line::make("Model", fn() => $this->model->name),
                Line::make("Role", fn() => $this->role->name),
                Line::make("Job", fn() => $this->role->job->title),
                Line::make("Brand and client", fn() => $this->role->job->brand?->name. ' via '.$this->role->job->client->name)->asSmall(),
            ])->onlyOnIndex(),
            BelongsTo::make("Role")->hideFromIndex(),
            BelongsTo::make("Model")->hideFromIndex(),
            Text::make('Photos', fn() => '<div style="display: flex; width: 340px; overflow-x: scroll">
                        ' .implode("", $this->photos->map(fn($photo) => '<img src="'.$photo->cdn_path_thumb.'" style="height: 120px;" />')->toArray())
                . '</div>')
                ->asHtml()->onlyOnIndex(),
            Text::make('Videos', fn() => '<div style="display: flex; width: 140px; overflow-x: scroll">
                        ' .$this->videos->map(fn($video) => '<video src="'.$video->cdn_path.'" style="height: 120px;" controls="true" />')->implode('')
                . '</div>')
                ->asHtml()->onlyOnIndex(),
            Text::make("Cover letter"),
            Text::make("Brand conflicted"),
            MorphMany::make("Photos")->showOnIndex(true),
            MorphMany::make("Videos")->showOnIndex(true),
        ];
    }
}

<?php

namespace App\Nova\Actions;

use Domain\Work2\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Spatie\Tags\Tag;

class AddTagsToModels extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $tag = Tag::find($fields->get("tag"));

        foreach ($models as $model) {

            if ($model instanceof Listing) {
                $model = $model->model;
            }

            if ($fields->get("should_add")) {
                $model->attachTag($tag);
            } else {
                $model->detachTag($tag);
            }
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Select::make("Action", "should_add")->options([
                1 => 'add tag',
                0 => 'remove tag',
            ])->default(1),
            Select::make('Tag')->options(
                Cache::remember('all_tags', 10, fn () => Tag::orderBy('type')
                        ->orderBy('name')
                        ->get()
                        ->mapWithKeys(function ($tag) { return [$tag->id => "{$tag->type} - {$tag->name}"];}))
            ),
        ];
    }
}

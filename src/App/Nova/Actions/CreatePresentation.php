<?php

namespace App\Nova\Actions;

use Domain\Present\Models\Presentation;
use Domain\Profiles\Models\Model;
use Domain\Work\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;

class CreatePresentation extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $applications)
    {
        $presentation = new Presentation();
        $presentation->role_id = $applications->first()->role_id;
        $presentation->applications = $applications->map(function (Application $application) {
            return $application->id;
        });
        $presentation->should_show_casting_media = $fields->should_show_casting_media;
        $presentation->should_show_conflicts = $fields->should_show_conflicts;
        $presentation->should_show_cover_letter = $fields->should_show_cover_letter;
        $presentation->should_show_socials = $fields->should_show_socials;
        $presentation->should_show_digitals = $fields->should_show_digitals;
        $presentation->save();
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
            Boolean::make('Show casting media', 'should_show_casting_media')->default(true),
            Boolean::make('Show digitals', 'should_show_digitals')->default(true),
            Boolean::make('Show cover letter', 'should_show_cover_letter')->default(true),
            Boolean::make('Show socials', 'should_show_socials')->default(true),
            Boolean::make('Show conflicts', 'should_show_conflicts')->default(true),
        ];
    }
}

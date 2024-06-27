<?php

namespace App\Nova\Actions;

use Domain\Present\Models\Presentation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
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
    public function handle(ActionFields $fields, Collection $listings)
    {
        $presentation = new Presentation();
        $presentation->description = $fields->description;
        $presentation->role_id = $listings->first()->role_id;
        $presentation->should_show_casting_media = $fields->should_show_casting_media;
        $presentation->should_show_conflicts = $fields->should_show_conflicts;
        $presentation->should_show_cover_letter = $fields->should_show_cover_letter;
        $presentation->should_show_socials = $fields->should_show_socials;
        $presentation->should_show_digitals = $fields->should_show_digitals;
        $presentation->save();

        foreach ($listings as $listing) {
            $presentation->presentationListings()->create([
                'listing_id' => $listing->id,
            ]);
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
            Text::make('Description')->help('Only for internal usage'),
            Boolean::make('Show casting media', 'should_show_casting_media')->default(true),
            Boolean::make('Show digitals', 'should_show_digitals')->default(true),
            Boolean::make('Show cover letter', 'should_show_cover_letter')->default(true),
            Boolean::make('Show socials', 'should_show_socials')->default(true),
            Boolean::make('Show conflicts', 'should_show_conflicts')->default(true),
        ];
    }
}

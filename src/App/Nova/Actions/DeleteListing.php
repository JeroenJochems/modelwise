<?php

namespace App\Nova\Actions;

use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class DeleteListing extends Action
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
        DB::transaction(function () use ($fields, $listings) {
            foreach ($listings as $listing) {
                abort_unless($listing instanceof Listing, 400, "Apply this action to a model");
                abort_unless(!$listing->applied_at, 400, "Listing has been applied to");
                abort_unless(!$listing->hired_at, 400, "Listing has been hired");

                $listing->delete();
            }
        });
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
            Select::make('Role', 'role_id')
                ->options(Role::where('start_date', '>', now())->get()->load("job")->mapWithKeys(function ($role) {
                    return [$role->id => $role->job->title . " - " . $role->name];
                }))
                ->searchable(),
        ];
    }
}

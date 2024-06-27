<?php

namespace App\Nova\Actions;

use Domain\Jobs\Models\Role;
use Domain\Work2\Actions\Invite;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendInviteToListing extends Action
{
    use InteractsWithQueue, Queueable;

    public $name = 'Invite';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $listings)
    {
        foreach ($listings as $listing) {
            app(Invite::class)->execute(
                $listing->role,
                $listing->model
            );

            Action::message("Invite for role has been sent to " . $listing->model->name);
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
        ];
    }
}

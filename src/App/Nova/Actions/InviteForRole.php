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

class InviteForRole extends Action
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
        foreach ($models as $model) {

            app(Invite::class)->execute(
                Role::find($fields->role_id),
                $model
            );

            Action::message("Invite for role has been sent to " . $model->name);
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
            Select::make('Role', 'role_id')
                ->options(Role::where('start_date', '>', now())->get()->load("job")->mapWithKeys(function ($role) {
                    return [$role->id => $role->job->title . " - " . $role->name];
                }))
                ->searchable(),
        ];
    }
}

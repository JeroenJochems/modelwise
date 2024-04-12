<?php

namespace App\Nova\Actions;

use Domain\Jobs\Models\Role;
use Domain\Work\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class ApplyForRole extends Action
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

            try {
                $application = new Application();
                $application->role_id = $fields->role_id;
                $application->model_id = $model->id;
                $application->save();

                Action::message("Application for role has been sent to " . $models->first()->first_name . " " . $models->first()->last_name);
            } catch (\Exception $e) {
                if (strpos(strtolower($e->getMessage()), 'duplicate') !== false) {
                    Action::message("Already applied: " . $models->first()->first_name . " " . $models->first()->last_name);
                } else {
                    throw $e;
                }
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
            Select::make('Role', 'role_id')
                ->options(Role::where('start_date', '>', now())->get()->load("job")->mapWithKeys(function ($role) {
                    return [$role->id => $role->job->title . " - " . $role->name];
                }))
                ->searchable(),
        ];
    }
}

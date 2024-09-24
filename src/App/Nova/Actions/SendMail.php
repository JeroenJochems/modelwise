<?php

namespace App\Nova\Actions;

use App\Mail\CleanMail;
use App\Nova\Listing;
use Domain\Profiles\Models\Model;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendMail extends Action
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
        foreach ($models as $object) {

            if ($object instanceof Listing) {

                Mail::to($object->model)
                    ->queue(new CleanMail(
                        messageSubject: $fields->get('subject'),
                        messageContent: $fields->get('content'),
                        actionText: 'View Listing',
                        actionUrl: 'blabla'
                    ));
            }

            if ($object instanceof Model) {
                Mail::to($object)
                    ->queue(new CleanMail(
                        messageSubject: $fields->get('subject'),
                        messageContent: $fields->get('content'),
                    ));
            }
        }

        return Action::message('Mail sent!');
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
            Text::make('Subject', 'subject'),
            Textarea::make('Content', 'content'),
        ];
    }
}

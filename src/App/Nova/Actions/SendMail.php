<?php

namespace App\Nova\Actions;

use App\Mail\CleanMail;
use Domain\Work2\Models\Listing;
use Illuminate\Bus\Queueable;
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

            $to = $object instanceof Listing ? $object->model : $object;

            Mail::to($to)
                ->queue(new CleanMail(
                    messageSubject: $fields->get('subject'),
                    messageContent: [$fields->get('content')],
                ));
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

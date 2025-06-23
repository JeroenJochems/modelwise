<?php

namespace App\Nova\Actions;

use App\Mail\CleanMail;
use App\Notifications\SmsMessage;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class SendSms extends Action
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
            $content = $fields->get('content');
            $content = str_replace("{{firstName}}", $to->first_name, $content);

            $to->notify(new SmsMessage($content));
        }

        return Action::message('Messages sent');
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
            Textarea::make('Content', 'content')->default("Hi {{firstName}},\n\n"),
        ];
    }
}

<?php

namespace Domain\Work2\Reactors;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Events\ModelHasApplied;
use Domain\Work2\Events\ModelWasInvited;
use Domain\Work2\Events\ModelWasRejected;
use Domain\Work2\Projectors\TypeBasedProjector;
use EventSauce\EventSourcing\Message;
use Illuminate\Support\Facades\Mail;

class MailReactor extends TypeBasedProjector
{

    public function handleModelHasApplied(ModelHasApplied $event, Message $message)
    {
        $role = Role::findOrFail($message->aggregateRootId());
        $model = Model::find($event->modelId);

        Mail::to($role->job->responsible_user)
            ->send(new CleanMail(
                'New application for ' . $role->job->title,
                $model->name.' has applied for the role ' . $role->name . ' for '.$role->job->title.'.'
            ));
    }

    public function handleModelWasInvited(ModelWasInvited $event, Message $message)
    {
        $role = Role::findOrFail($message->aggregateRootId());
        $model = Model::findOrFail($event->modelId);

        Mail::to($model)
            ->send(new CleanMail(
                messageSubject: "Are you available for this job?",
                messageContent:
                    "Hi {$model->first_name}\n\n" .
                    "We believe you might be a great fit for this role.\n\n" .
                    "{$role->job->title} - {$role->name}\n\n" .
                    "Are you interested?\n\n",
                actionText: "View role details",
                actionUrl: route('roles.show', $role->id)
            ));
    }

    public function handleModelWasRejected(ModelWasRejected $event, Message $message)
    {
        $role = Role::findOrFail($message->aggregateRootId());
        $model = Model::findOrFail($event->modelId);

        Mail::to($model)
            ->send(new CleanMail(
                messageSubject: $event->messageSubject,
                messageContent: nl2br(
                    "Hi {$model->first_name},\n\n".
                    $event->messageBody
                ),
                actionText: "View role details",
                actionUrl: route('roles.show', $role->id)
            ));


    }
}

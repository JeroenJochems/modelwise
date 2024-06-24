<?php

namespace Domain\Work2\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\Mail;

class Reject
{
    public function execute(Role $role, Model $model, string $subject, string $message)
    {
        $listing = Listing::query()
            ->where('role_id', $role->id)
            ->where('model_id', $model->id)
            ->first();

        if (!$listing) {
            return;
        }

        $listing->rejected_at = now();
        $listing->save();

        Mail::to($model)
            ->send(new CleanMail(
                messageSubject: $subject,
                messageContent: nl2br(
                    "Hi {$model->first_name},\n\n".
                    $message
                ),
                actionText: "View role details",
                actionUrl: route('roles.show', $role->id)
            ));
    }
}

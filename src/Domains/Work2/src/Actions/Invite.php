<?php

namespace Domain\Work2\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\Mail;

class Invite
{
    public function execute(Role $role, Model $model, bool $isShortlisted=false): void
    {
        $listing = Listing::firstOrNew(['role_id' => $role->id, 'model_id' => $model->id]);
        $listing->invited_at = now();
        $listing->shortlisted_at = $isShortlisted ? now() : null;
        $listing->save();

        Mail::to($model)
            ->queue(new CleanMail(
                messageSubject: "Are you available for this job?",
                messageContent: [
                    "Hi {$model->first_name}",
                    "We believe you might be a great fit for this role.",
                    "{$listing->role->job->title} - {$listing->role->name}",
                    $listing->role->job->description,
                    "Are you interested?"
                ],
                actionText: "View role details",
                actionUrl: route('roles.show', $listing->role_id)
            ));
    }
}

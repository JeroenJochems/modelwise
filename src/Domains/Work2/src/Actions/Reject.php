<?php

namespace Domain\Work2\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\Mail;

class Reject
{
    public function execute(Listing $listing, string $subject, string $message)
    {
        $listing->rejected_at = now();
        $listing->save();

        Mail::to($listing->model)
            ->send(new CleanMail(
                messageSubject: $subject,
                messageContent: [
                    "Hi {$listing->model->first_name},",
                    $message
                ],
                actionText: "View role details",
                actionUrl: route('roles.show', $listing->model->id)
            ));
    }
}

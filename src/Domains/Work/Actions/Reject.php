<?php

namespace Domain\Work\Actions;

use App\Notifications\Rejected;
use Domain\Work\Models\Application;
use Domain\Work\Models\Rejection;

class Reject
{
    public function execute(Application $application, string $subject, string $message)
    {
        if ($application->rejection) return;

        $rejection = new Rejection();
        $rejection->application_id = $application->id;
        $rejection->save();

        $application->model->notify(new Rejected($rejection, $subject, $message));
    }
}

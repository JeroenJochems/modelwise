<?php

namespace Domain\Work\Actions;

use App\Notifications\Shortlisted;
use Domain\Work\Models\Application;

class Shortlist
{
    public function execute(Application $application)
    {
        $application->shortlisted_at = now();
        $application->save();

        $application->model->notify(
            new Shortlisted($application)
        );
    }
}

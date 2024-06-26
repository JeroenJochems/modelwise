<?php

namespace Domain\Work2\Actions;

use App\Notifications\Shortlisted;
use Domain\Work2\Models\Listing;

class Shortlist
{
    public function execute(Listing $listing)
    {
        $listing->shortlisted_at = now();
        $listing->save();

        $listing->model->notify(
            new Shortlisted($listing)
        );
    }
}

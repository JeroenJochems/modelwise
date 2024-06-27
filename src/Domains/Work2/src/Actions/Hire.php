<?php

namespace Domain\Work2\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\Mail;

class Hire
{
    public function execute(Listing $listing)
    {
        $listing->hired_at = now();
        $listing->save();
    }
}

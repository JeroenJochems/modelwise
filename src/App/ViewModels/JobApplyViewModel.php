<?php

namespace App\ViewModels;

use Domain\Jobs\Models\Job;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class JobApplyViewModel extends ViewModel
{
    public Job $job;

    public function __construct(Job $job)
    {
        $this->job = $job->load("brand", "client");
    }
}

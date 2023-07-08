<?php

namespace App\Http\Controllers;

use Domain\Jobs\Models\Job;
use Inertia\Inertia;

class JobController extends Controller
{
    public function show(Job $job)
    {
        return Inertia::render('Jobs/Show')
            ->with("job", $job->load('brand', 'client'));
    }
}

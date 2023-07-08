<?php

namespace App\Http\Controllers;

use Domain\Jobs\Models\Job;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function create(Job $job)
    {
        return Inertia::render('Jobs/Show')
            ->with("job", $job->load('brand', 'client'));
    }

    public function store(Job $job)
    {
        //
    }
}

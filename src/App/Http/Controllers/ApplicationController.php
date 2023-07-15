<?php

namespace App\Http\Controllers;

use App\ViewModels\JobApplyViewModel;
use Domain\Jobs\Models\Job;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function create(Job $job)
    {
        return Inertia::render('Jobs/Apply')
            ->with("viewModel", new JobApplyViewModel($job));
    }

    public function store(Job $job)
    {
        //
    }
}

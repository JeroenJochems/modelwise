<?php

namespace App\Http\Controllers;

use App\ViewModels\JobApplyViewModel;
use Domain\Jobs\Models\Job;
use Inertia\Inertia;

class JobController extends Controller
{
    public function show(Job $job)
    {
        $vm = new JobApplyViewModel($job);

        return Inertia::render('Jobs/Show')
            ->with("viewModel", $vm);
    }
}

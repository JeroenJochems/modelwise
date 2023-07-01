<?php

namespace App\Providers;

use Domain\Jobs\Models\Client;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Policies\ClientPolicy;
use Domain\Jobs\Policies\JobPolicy;
use Domain\Models\Models\Model;
use Domain\Models\Policies\ModelPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Model::class => ModelPolicy::class,
        Job::class => JobPolicy::class,
        Client::class => ClientPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

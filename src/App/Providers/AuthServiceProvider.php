<?php

namespace App\Providers;

use Domain\Jobs\Models\Client;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Policies\ClientPolicy;
use Domain\Jobs\Policies\JobPolicy;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Policies\ModelPolicy;
use Domain\Work2\Models\Listing;
use Domain\Work2\Policies\ListingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Support\Policies\UserPolicy;
use Support\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Model::class => ModelPolicy::class,
        Job::class => JobPolicy::class,
        Client::class => ClientPolicy::class,
        Listing::class => ListingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
    }
}

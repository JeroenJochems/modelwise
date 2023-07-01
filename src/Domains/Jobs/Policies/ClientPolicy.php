<?php

namespace Domain\Jobs\Policies;


use Domain\Jobs\Models\Client;
use Illuminate\Contracts\Auth\Authenticatable;

class ClientPolicy
{
    public function view(Authenticatable $authenticatable, Client $client)
    {
        return true;
    }

    public function create(Authenticatable $authenticatable)
    {
        return true;
    }

    public function update(Authenticatable $authenticatable, Client $client)
    {
        return true;
    }

    public function viewAny(Authenticatable $authenticatable)
    {
        return true;
    }
}

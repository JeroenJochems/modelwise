<?php

namespace Domain\Work2\Policies;

use Domain\Work2\Models\Listing;
use Illuminate\Contracts\Auth\Authenticatable;

class ListingPolicy
{
    public function view(Authenticatable $authenticatable, Listing $listing)
    {
        return true;
    }

    public function create(Authenticatable $authenticatable)
    {
        return false;
    }

    public function update(Authenticatable $authenticatable, Listing $listing)
    {
        return true;
    }

    public function addPhotos(Authenticatable $authenticatable, Listing $listing)
    {
        return true;
    }

    public function addPhoto(Authenticatable $authenticatable, Listing $listing)
    {
        return true;
    }

    public function viewAny(Authenticatable $authenticatable)
    {
        return true;
    }

    public function viewNova(Authenticatable $authenticatable)
    {
        return false;
    }
}

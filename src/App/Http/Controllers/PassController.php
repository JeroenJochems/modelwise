<?php

namespace App\Http\Controllers;

use Domain\Jobs\Data\ApplyData;
use Domain\Jobs\Models\Role;
use Domain\Work\Actions\Pass;

class PassController extends Controller
{
    public function store(Role $role)
    {
        app(Pass::class)(auth()->user(), $role);

        return redirect()->back();
    }
}

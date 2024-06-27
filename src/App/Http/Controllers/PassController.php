<?php

namespace App\Http\Controllers;

use Domain\Jobs\Models\Role;
use Domain\Work2\Actions\Pass;

class PassController extends Controller
{
    public function store(Role $role)
    {
        app(Pass::class)(auth()->user(), $role);

        return redirect()->back();
    }
}

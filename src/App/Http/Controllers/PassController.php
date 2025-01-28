<?php

namespace App\Http\Controllers;

use Domain\Jobs\Models\Role;
use Domain\Work2\Models\Pass;

class PassController extends Controller
{
    public function toggle(Role $role)
    {
        $pass = Pass::firstOrCreate([
            'role_id' => $role->id,
            'model_id' => auth()->id()
        ]);

        if ($pass->wasRecentlyCreated===false) {
            $pass->delete();
        }

        return redirect()->back();
    }
}

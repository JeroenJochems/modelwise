<?php

namespace App\Http\Controllers;

use Domain\Jobs\Models\Role;
use Domain\Work2\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AcknowledgeBriefController extends Controller
{
    public function __invoke(Request $request, Role $role): RedirectResponse
    {
        $listing = Listing::where('role_id', $role->id)
            ->where('model_id', $request->user()->getAuthIdentifier())
            ->firstOrFail();

        $acknowledged = (bool) $request->input('acknowledged', true);

        $listing->brief_acknowledged_at = $acknowledged ? now() : null;
        $listing->save();

        return back();
    }
}

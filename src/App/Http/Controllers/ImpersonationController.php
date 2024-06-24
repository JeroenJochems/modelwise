<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Laravel\Nova\Contracts\ImpersonatesUsers;
use Laravel\Nova\Util;

class ImpersonationController extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function stop(ImpersonatesUsers $impersonator)
    {
        $impersonator->stopImpersonating(request(), Auth::guard(), Util::userModel());

        return redirect()->to('/admin');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\ModelCreated;
use Domain\Profiles\Actions\RegisterModel;
use Domain\Profiles\Data\RegisterModelData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisterModelController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterModelData $data): RedirectResponse
    {
        $data->viewedRoles = request()->session()->get('viewed_roles', []);

        $model = (new RegisterModel())($data);

        $model->notify(new ModelCreated());

        Auth::login($model);
        return redirect(route('onboarding.personal-details'));
    }
}

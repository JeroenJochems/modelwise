<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Models\Actions\RegisterModel;
use Domain\Models\Data\RegisterModelData;
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
        $model = (new RegisterModel())($data);

        Auth::login($model);

        return redirect(route('onboarding.personal-details'));
    }
}
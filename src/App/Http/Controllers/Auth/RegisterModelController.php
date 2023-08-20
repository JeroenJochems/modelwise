<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Domain\Profiles\Actions\RegisterModel;
use Domain\Profiles\Actions\SendMail;
use Domain\Profiles\Data\Mail\MailData;
use Domain\Profiles\Data\RegisterModelData;
use Domain\Profiles\Data\Templates;
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

        app(SendMail::class)(
            new MailData(
                $model,
                Templates::registrationCompleted
            )
        );

        return redirect(route('onboarding.personal-details'));
    }
}

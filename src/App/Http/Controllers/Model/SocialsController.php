<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use Domain\Models\Data\ModelSocialsData;
use Inertia\Inertia;

class SocialsController extends Controller
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/Socials")
            ->with([
                'modelData' => ModelSocialsData::from(auth()->user())->toArray()
            ]);
    }

    public function store(ModelSocialsData $data)
    {
        $model = auth()->user();
        $model->update($data->toArray());

        if ($data->website == "http://") $model->website = null;

        $model->has_completed_onboarding = true;
        $model->save();

        return redirect()->route('account.index');
    }
}

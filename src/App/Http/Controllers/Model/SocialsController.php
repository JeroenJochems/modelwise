<?php

namespace App\Http\Controllers\Model;

use Domain\Profiles\Data\ModelSocialsData;
use Inertia\Inertia;

class SocialsController extends BaseOnboardingController
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
        if ($data->showreel_link == "http://") $model->showreel_link = null;

        $model->has_completed_onboarding = true;
        $model->save();

        return $this->nextOrReturn();
    }
}

<?php

namespace App\Http\Controllers\Model;

use App\ViewModels\ProfessionalExperienceViewModel;
use Domain\Profiles\Models\Model;
use Inertia\Inertia;

class ProfessionalExperienceController extends BaseOnboardingController
{
    public function index()
    {
        return Inertia::render("Model/Onboarding/ProfessionalExperience")
            ->with('vm', new ProfessionalExperienceViewModel(auth()->user()));
    }

    public function store()
    {
        /** @var Model $model */
        $model = auth()->user();

        $model->syncTagsWithType(request()->input('categories'), Model::TAG_TYPE_MODEL_EXPERIENCE);
        $model->syncTagsWithType(request()->input('professions'), Model::TAG_TYPE_PROFESSIONS);
        $model->other_categories = request()->input('otherCategories');
        $model->save();

        return $this->nextOrReturn();
    }
}

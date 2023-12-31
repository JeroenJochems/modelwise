<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Transformers\EnumArray;
use App\ViewModels\ModelExclusiveCountriesViewModel;
use Domain\Profiles\Models\Model;
use Inertia\Inertia;
use PrinsFrank\Standards\Country\CountryAlpha2;
use Support\Enums\ModelCountries;

class ExclusiveCountriesController extends BaseOnboardingController
{
    public function index()
    {
        $vm = new ModelExclusiveCountriesViewModel(auth()->user());

        return Inertia::render("Model/Onboarding/ExclusiveCountries")
            ->with([
                'viewModel' => $vm,
                'modelingCountries' => EnumArray::transform(ModelCountries::cases()),
                'allCountries' => EnumArray::transform(CountryAlpha2::cases())
            ]);
    }

    public function done()
    {
        /** @var Model $model */
        $model = auth()->user();

        $model->update(['seen_exclusive_countries' => true]);

        return $this->nextOrReturn();
    }

    public function store()
    {
        $validated = $this->validate(request(), [
            'country' => 'required|string'
        ]);

        /** @var Model $model */
        $model = auth()->user();
        $model->exclusiveCountries()->create($validated);

        return back();
    }

    public function delete($country)
    {
        /** @var Model $model */
        $model = auth()->user();
        $model->exclusiveCountries()->where('country', $country)->delete();

        return back();
    }


}

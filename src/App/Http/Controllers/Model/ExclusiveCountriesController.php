<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Transformers\EnumArray;
use App\ViewModels\ModelExclusiveCountriesViewModel;
use Domain\Models\Models\Model;
use Inertia\Inertia;
use PrinsFrank\Standards\Country\CountryAlpha2;

class ExclusiveCountriesController extends Controller
{
    public function index()
    {
        $vm = new ModelExclusiveCountriesViewModel(auth()->user());

        return Inertia::render("Model/Onboarding/ExclusiveCountries")
            ->with([
                'viewModel' => $vm,
                'allCountries' => EnumArray::transform(CountryAlpha2::cases())
            ]);
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

<?php

namespace App\ViewModels;

use Domain\Profiles\Models\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use PrinsFrank\Standards\Country\CountryAlpha2;
use Spatie\ViewModels\ViewModel;

/** @typescript  */
class ModelExclusiveCountriesViewModel extends ViewModel
{
    /** @var array<CountryAlpha2> */
    public $countryCodes = [];

    public function __construct(Model|Authenticatable $model)
    {
        $this->countryCodes = $model->exclusiveCountries()->pluck("country");
    }
}
